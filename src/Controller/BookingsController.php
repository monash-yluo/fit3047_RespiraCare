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
        $query = $this->Bookings->find()
            ->contain(['Patients', 'Clinicians']);
        $bookings = $this->paginate($query);

        $this->set(compact('bookings'));
    }

    public function patientIndex()
    {
        // Auto-decline pending bookings that are past their scheduled date
        $this->Bookings->updateExpiredPendingBookings();

        // Count pending bookings
        $pendingCount = $this->Bookings->find()
            ->where(['Bookings.status' => 'pending'])
            ->count();

        // Get upcoming bookings (not paginated)
        $today = new \DateTime();
        $upcomingBookings = $this->Bookings->find()
            ->contain(['Clinicians.Users', 'Patients.Users'])
            ->where(['Bookings.scheduled_date >=' => $today->format('Y-m-d')])
            ->orderBy(['Bookings.scheduled_date' => 'ASC'])
            ->all();

        // Get all bookings (paginated)
        $query = $this->Bookings->find()
            ->contain(['Clinicians.Users', 'Patients.Users'])
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
        $booking = $this->Bookings->get($id, contain: ['Patients', 'Clinicians']);
        $this->set(compact('booking'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $booking = $this->Bookings->newEmptyEntity();
        if ($this->request->is('post')) {
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
        $this->request->allowMethod(['post', 'delete']);
        $booking = $this->Bookings->get($id);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
