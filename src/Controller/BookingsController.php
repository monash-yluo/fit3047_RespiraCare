<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Bookings Controller
 *
 * @property \App\Model\Table\BookingsTable $Bookings
 */
class BookingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->checkRole(['admin']); // Only admins can access this method

        $query = $this->Bookings->find()
            ->contain(['Patients.Users', 'Clinicians.Users']);
        $bookings = $this->paginate($query);

        $this->paginate = [
            'limit' => 10,
            'order' => ['created' => 'DESC'],
        ];

        $this->set(compact('bookings'));
    }

    public function patientClinicianIndex()
    {
        $this->checkRole(['patient', 'clinician']); // Only patients and clinicians can access this method

        $patientId = null;
        $clinicianId = null;
        if ($this->Authentication->getIdentity()->role === 'patient') {
            $patientId = $this->getPatientId();
        } else if ($this->Authentication->getIdentity()->role === 'clinician') {
            $clinicianId = $this->getClinicianId();
        }

        // Auto-decline pending bookings that are past their scheduled date
        $this->Bookings->updateExpiredPendingBookings();

        // Count pending bookings
        $pendingCount = $this->Bookings->find()
            ->where(['Bookings.status' => 'pending'])
            ->andWhere(function ($exp) use ($patientId, $clinicianId) {
                if ($patientId) {
                    return $exp->eq('Bookings.patient_id', $patientId);
                } else if ($clinicianId) {
                    return $exp->eq('Bookings.clinician_id', $clinicianId);
                }
                return null;
            })
            ->count();

        // Get upcoming bookings (not paginated)
        $today = new \DateTime();
        $upcomingBookings = $this->Bookings->find()
            ->contain(['Clinicians.Users', 'Patients.Users'])
            ->where(['Bookings.scheduled_date >=' => $today->format('Y-m-d')])
            ->andWhere(function ($exp) use ($patientId, $clinicianId) {
                if ($patientId) {
                    return $exp->eq('Bookings.patient_id', $patientId);
                } else if ($clinicianId) {
                    return $exp->eq('Bookings.clinician_id', $clinicianId);
                }
                return null;
            })
            ->orderBy(['Bookings.scheduled_date' => 'ASC'])
            ->all();

        // Get all bookings (paginated)
        $query = $this->Bookings->find()
            ->contain(['Clinicians.Users', 'Patients.Users'])
            ->andWhere(function ($exp) use ($patientId, $clinicianId) {
                if ($patientId) {
                    return $exp->eq('Bookings.patient_id', $patientId);
                } else if ($clinicianId) {
                    return $exp->eq('Bookings.clinician_id', $clinicianId);
                }
                return null;
            })
            ->orderBy(['Bookings.scheduled_date' => 'DESC']);
        $bookings = $this->paginate($query);

        $this->set(compact('pendingCount', 'upcomingBookings', 'bookings'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $booking = $this->Bookings->get($id, contain: ['Patients' => ['Users', 'Clinicians' => ['Users']], 'Clinicians' => ['Users']]);
        $this->set(compact('booking'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->checkRole(['patient', 'admin']); // Only patients and admins can add bookings

        $booking = $this->Bookings->newEmptyEntity();
        if ($this->request->is('post')) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());

            if ($identity = $this->Authentication->getIdentity()->role === 'patient') {
                $booking->patient_id = $this->getPatientId(); // Set patient_id to the logged-in patient's ID
            }


            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));

                if ($this->Authentication->getIdentity()->role === 'admin') {
                    return $this->redirect(['action' => 'index']);
                } else {
                    return $this->redirect(['action' => 'patientClinicianIndex']);
                }
            }
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
        
        $clinicians = $this->Bookings->Clinicians->find('list', contain: ['Users'])->all();
        $patients = $this->Bookings->Patients->find('list', contain: ['Users'])->all();
        
        $this->set(compact('booking', 'clinicians', 'patients'));
    }

    public function changeStatus($id = null, $status = null)
    {
        $this->checkRole(['admin', 'clinician']); // Only admins and clinicians can change booking status

        $booking = $this->Bookings->get($id);
        if (!in_array($status, ['confirmed', 'pending', 'declined'])) {
            $this->Flash->error(__('Invalid status value.'));
            return $this->redirect($this->referer());
        }

        $booking->status = $status;
        if ($this->Bookings->save($booking)) {
            $this->Flash->success(__('The booking status has been updated to {0}.', h(ucfirst($status))));
        } else {
            $this->Flash->error(__('The booking status could not be updated. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $booking = $this->Bookings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());
            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
        $patients = $this->Bookings->Patients->find('list', limit: 200)->all();
        $clinicians = $this->Bookings->Clinicians->find('list', limit: 200)->all();
        $this->set(compact('booking', 'patients', 'clinicians'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->checkRole(['admin', 'patient']); // Only admins and patients can delete bookings

        $this->request->allowMethod(['post', 'delete']);
        $booking = $this->Bookings->get($id);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }

        if ($this->Authentication->getIdentity()->role === 'admin') {
            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(['action' => 'patientClinicianIndex']);
        }
    }
}
