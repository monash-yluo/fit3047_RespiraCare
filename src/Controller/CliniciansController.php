<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Clinicians Controller
 *
 * @property \App\Model\Table\CliniciansTable $Clinicians
 */
class CliniciansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->checkRole(['admin']);

        $query = $this->Clinicians->find()
            ->contain(['Users']);

        // 1. Get the search term from the URL
        $search = $this->request->getQuery('search');

        // 2. If a search term exists, apply the WHERE conditions
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Users.first_name LIKE' => '%' . $search . '%',
                    'Users.last_name LIKE' => '%' . $search . '%',
                    'Users.phone LIKE' => '%' . $search . '%',
                    'Users.email LIKE' => '%' . $search . '%',
                ],
            ]);
        }

        $this->paginate = [
            'limit' => 10,
            'order' => ['Users.created' => 'DESC'],
        ];

        $clinicians = $this->paginate($query);
        $this->set(compact('clinicians'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/clinicians_table');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Clinician id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clinician = $this->Clinicians->get($id);
        if ($this->Clinicians->delete($clinician)) {
            $this->Flash->success(__('The clinician has been deleted.'));
        } else {
            $this->Flash->error(__('The clinician could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return void
     */
    public function dashboard()
    {
        $this->checkRole(['clinician']);
        $identity = $this->request->getAttribute('identity');
        $clinicianId = $this->getClinicianId();

        if ($clinicianId) {
            $search = $this->request->getQuery('search');

            // 1. Patients Query (Same as before)
            $patientsQuery = $this->fetchTable('Patients')->find()
                ->where(['Patients.clinician_id' => $clinicianId])
                ->contain(['Users']);

            if (!empty($search)) {
                $patientsQuery->where([
                    'OR' => [
                        'Users.first_name LIKE' => '%' . $search . '%',
                        'Users.last_name LIKE' => '%' . $search . '%',
                    ],
                ]);
            }

            $this->paginate = [
                'limit' => 10,
            ];

            $patients = $this->paginate($patientsQuery);
            $patientCount = $patientsQuery->count();

            // 2. Total Reminders
            $reminderCount = $this->fetchTable('Reminders')->find()
                ->where(['receiver_id' => $identity->id])
                ->count();

            // 3. Urgent Patients Logic based on your specific columns
            $urgentPatientCount = $this->fetchTable('Patients')->find()
                ->where(['Patients.clinician_id' => $clinicianId])
                ->matching('PatientMeasurements', function ($q) {
                    return $q->where([
                        'OR' => [
                            'PatientMeasurements.spo2 <' => 80,
                            'PatientMeasurements.blood_pressure_systolic >' => 140,
                            'PatientMeasurements.blood_pressure_diastolic >' => 90,
                            'PatientMeasurements.temperature >' => 40,
                            'PatientMeasurements.heart_rate >' => 110,
                            'PatientMeasurements.heart_rate <' => 50,
                        ],
                    ]);
                })
                ->distinct(['Patients.id'])
                ->count();

            $todaysBookings = $this->fetchTable('Bookings')->find()
                ->contain(['Patients.Users'])
                ->where([
                    'Bookings.clinician_id' => $clinicianId,
                    'Bookings.status !=' => 'declined',
                    'Bookings.scheduled_date >=' => date('Y-m-d 00:00:00'),
                    'Bookings.scheduled_date <=' => date('Y-m-d 23:59:59'),
                ])
                ->orderBy(['Bookings.scheduled_date' => 'ASC'])
                ->all();

            $this->set(compact('patients', 'patientCount', 'reminderCount', 'urgentPatientCount', 'todaysBookings'));

            if ($this->request->is('ajax')) {
                $this->viewBuilder()->disableAutoLayout();

                return $this->render('/element/table/entity_tables/clinician_dashboard_table');
            }
        }
    }
}
