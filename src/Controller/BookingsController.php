<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Log\Log;
use Cake\Mailer\Mailer;
use DateTime;
use Exception;

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

        $search = $this->request->getQuery('search');
        $status = $this->request->getQuery('status');

        if (!empty($status)) {
            $query->where(['Bookings.status' => $status]);
        }

        if (!empty($search)) {
            // Find Patient by Search
            $matchingPatientIds = $this->Bookings->Patients->find()
                ->select(['Patients.id'])
                ->innerJoinWith('Users')
                ->where([
                    'OR' => [
                        'Users.first_name LIKE' => '%' . $search . '%',
                        'Users.last_name LIKE' => '%' . $search . '%',
                        'Users.email LIKE' => '%' . $search . '%',
                    ],
                ]);

            // Find Clinician by Search
            $matchingClinicianIds = $this->Bookings->Clinicians->find()
                ->select(['Clinicians.id'])
                ->innerJoinWith('Users')
                ->where([
                    'OR' => [
                        'Users.first_name LIKE' => '%' . $search . '%',
                        'Users.last_name LIKE' => '%' . $search . '%',
                        'Users.email LIKE' => '%' . $search . '%',
                    ],
                ]);

            // If existed, return
            $query->where([
                'OR' => [
                    'Bookings.patient_id IN' => $matchingPatientIds,
                    'Bookings.clinician_id IN' => $matchingClinicianIds,
                ],
            ]);
        }

        $preset = $this->request->getQuery('date_preset');

        if ($preset === 'today') {
            $query->where(['Bookings.scheduled_date >=' => new DateTime('today')]);
        } elseif (in_array($preset, ['7', '30', '90'])) {
            $query->where(['Bookings.scheduled_date >=' => new DateTime("-{$preset} days")]);
        }

        $this->paginate = [
            'limit' => 10,
            'order' => ['Bookings.created' => 'DESC'],
        ];

        $bookings = $this->paginate($query);
        $this->set(compact('bookings'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/bookings_table');
        }
    }

    public function patientClinicianIndex()
    {
        $this->checkRole(['patient', 'clinician']);

        $identity = $this->Authentication->getIdentity();
        $target = $this->request->getQuery('target');
        $status = $this->request->getQuery('status');
        $preset = $this->request->getQuery('date_preset');
        $role = $identity->role;

        $patientId = null;
        $clinicianId = null;

        if ($role === 'patient') {
            $patientId = $this->getPatientId();
        } elseif ($role === 'clinician') {
            $clinicianId = $this->getClinicianId();
        }

        $this->Bookings->updateExpiredPendingBookings();

        $bookingConditions = function ($exp) use ($patientId, $clinicianId) {
            if ($patientId) {
                return $exp->eq('Bookings.patient_id', $patientId);
            }
            if ($clinicianId) {
                return $exp->eq('Bookings.clinician_id', $clinicianId);
            }

            return $exp;
        };

        $pendingCount = $this->Bookings->find()
            ->where(['Bookings.status' => 'pending'])
            ->andWhere($bookingConditions)
            ->count();

        $today = new DateTime();

        $baseQuery = $this->Bookings->find()
            ->contain(['Clinicians.Users', 'Patients.Users'])
            ->andWhere($bookingConditions);

        $upcomingQuery = clone $baseQuery;
        $upcomingQuery
            ->where(['Bookings.scheduled_date >=' => $today->format('Y-m-d')])
            ->orderBy(['Bookings.scheduled_date' => 'ASC']);

        $query = clone $baseQuery;
        $query->orderBy(['Bookings.scheduled_date' => 'DESC']);

        if ($target === 'upcomingBookings') {
            if (!empty($status)) {
                $upcomingQuery->where(['Bookings.status' => $status]);
            }
        }

        if ($target === 'allBookings') {
            if (!empty($status)) {
                $query->where(['Bookings.status' => $status]);
            }

            if (!empty($preset)) {
                if ($preset === 'today') {
                    $query->where(['Bookings.scheduled_date >=' => new DateTime('today')]);
                } elseif (in_array($preset, ['7', '30', '90'])) {
                    $query->where(['Bookings.scheduled_date >=' => new DateTime("-{$preset} days")]);
                }
            }
        }

        // 3. Paginate with Scopes
        $bookings = $this->paginate($query, [
            'scope' => 'bookings',
            'limit' => 10,
        ]);

        $upcomingBookings = $this->paginate($upcomingQuery, [
            'scope' => 'upcomingBookings',
            'limit' => 10,
        ]);

        $this->set(compact('pendingCount', 'upcomingBookings', 'bookings'));

        // Handle AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            if ($target === 'upcomingBookings') {
                return $this->render('/element/table/entity_tables/bookings_clinician_table');
            } elseif ($target === 'allBookings') {
                return $this->render('/element/table/entity_tables/bookings_all_table');
            } else {
                throw new Exception('Something went wrong!');
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
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
            // 如果确认预约，发送确认邮件给患者
            if ($status === 'confirmed') {
                $booking = $this->Bookings->get($id, contain: ['Patients.Users', 'Clinicians.Users']);

                try {
                    $mailer = new Mailer();
                    $mailer->setTo($booking->patient->user->email)
                        ->setEmailFormat('both')
                        ->setSubject('Booking Confirmed - RespiraCare')
                        ->setReplyTo($booking->clinician->user->email);

                    $mailer->viewBuilder()
                        ->setVar('booking', $booking)
                        ->setVar('patientName', $booking->patient->user->first_name)
                        ->setVar('clinicianName', $booking->clinician->user->first_name . ' ' . $booking->clinician->user->last_name)
                        ->setTemplate('booking_comfirm')
                        ->setLayout('email');

                    $mailer->send();

                    $this->Flash->success(__('The booking status has been updated and a confirmation email has been sent to the patient.'));
                } catch (Exception $e) {
                    $this->Flash->error(__('Booking status updated, but failed to send confirmation email. Please contact support.'));
                }
            }

            // 如果拒绝预约，发送拒绝邮件给患者
            if ($status === 'declined') {
                $booking = $this->Bookings->get($id, contain: ['Patients.Users', 'Clinicians.Users']);

                try {
                    $mailer = new Mailer();
                    $mailer->setTo($booking->patient->user->email)
                        ->setEmailFormat('both')
                        ->setSubject('Booking Declined - RespiraCare')
                        ->setReplyTo($booking->clinician->user->email);

                    $mailer->viewBuilder()
                        ->setVar('booking', $booking)
                        ->setVar('patientName', $booking->patient->user->first_name)
                        ->setVar('clinicianName', $booking->clinician->user->first_name . ' ' . $booking->clinician->user->last_name)
                        ->setTemplate('booking_decline')
                        ->setLayout('email');

                    $mailer->send();

                    $this->Flash->success(__('The booking status has been updated and a decline email has been sent to the patient.'));
                } catch (Exception $e) {
                    $this->Flash->error(__('Booking status updated, but failed to send decline email. Please contact support.'));
                }
            }
        } else {
            $this->Flash->error(__('The booking status could not be updated. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->checkRole(['admin', 'patient']); // Only admins and patients can delete bookings
        $this->request->allowMethod(['post', 'delete']);

        $booking = $this->Bookings->get($id, ['contain' => ['Patients.Clinicians']]);

        if ($this->Bookings->delete($booking)) {
            $isUpcoming =
                $booking->scheduled_date &&
                $booking->scheduled_date->isFuture() &&
                $booking->status === 'confirmed';

            if ($isUpcoming && !empty($booking->patient->clinician) && !empty($booking->patient->clinician->user_id)) {
                $remindersTable = $this->fetchTable('Reminders');

                // Format the booking date/time
                $bookingTime = $booking->scheduled_date->format('M d, Y g:i A');

                $reminder = $remindersTable->newEmptyEntity();
                $reminder->set([
                    'receiver_id' => $booking->patient->clinician->user_id,
                    'message' => sprintf(
                        'Booking Cancelled: A booking scheduled for %s has been cancelled.',
                        $bookingTime,
                    ),
                ]);

                $remindersTable->save($reminder);
            }

            $this->Flash->success(__('The booking has been cancelled.'));
        } else {
            $this->Flash->error(__('The booking could not be cancelled. Please, try again.'));
        }

        if ($this->Authentication->getIdentity()->role === 'admin') {
            return $this->redirect(['action' => 'index']);
        } else {
            return $this->redirect(['action' => 'patientClinicianIndex']);
        }
    }

    public function getBookedSlots($clinicianId = null)
    {
        $this->request->allowMethod(['get', 'ajax']);
        $this->viewBuilder()->setClassName('Json');

        $this->log('Testing');

        if (!$clinicianId) {
            return $this->set(['blocked' => []])->viewBuilder()->setOption('serialize', ['blocked']);
        }

        // Find all future, non-cancelled bookings for this clinician
        $bookings = $this->Bookings->find()
            ->where([
                'clinician_id' => $clinicianId,
                'status !=' => 'declined',
                'scheduled_date >=' => new DateTime('today'),
            ])
            ->all();

        $blocked = [];
        foreach ($bookings as $booking) {
            $duration = $booking->duration ?? 30;

            // Format exactly Flatpickr
            $blocked[] = [
                'from' => $booking->scheduled_date->format('Y-m-d H:i'),
                'to' => (clone $booking->scheduled_date)->modify("+{$duration} minutes")->format('Y-m-d H:i'),
            ];
        }

        $this->set(compact('blocked'));
        $this->viewBuilder()->setOption('serialize', ['blocked']);
    }
}
