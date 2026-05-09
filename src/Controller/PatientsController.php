<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Exception;

/**
 * Patients Controller
 *
 * @property \App\Model\Table\PatientsTable $Patients
 */
class PatientsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->checkRole(['admin']);

        $search = $this->request->getQuery('search');
        $query = $this->Patients->find()
            ->contain(['Users', 'Clinicians.Users']);

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Users.first_name LIKE' => '%' . $search . '%',
                    'Users.last_name LIKE' => '%' . $search . '%',
                    'Users.email LIKE' => '%' . $search . '%',
                    'Users.phone LIKE' => '%' . $search . '%',
                ],
            ]);
        }

        $this->paginate = [
            'limit' => 10,
            'order' => ['Users.created' => 'DESC'],
        ];

        $patients = $this->paginate($query);
        $this->set(compact('patients'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/patients_table');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->checkRole(['admin', 'clinician']);

        $patient = $this->Patients->get($id, contain: ['Users', 'Clinicians.Users', 'PatientMeasurements', 'SymptomLogs' => ['SymptomTypes']]);
        $this->set(compact('patient'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->checkRole(['admin']);

        $this->request->allowMethod(['post', 'delete']);
        $patient = $this->Patients->get($id);
        if ($this->Patients->delete($patient)) {
            $this->Flash->success(__('The patient has been deleted.'));
        } else {
            $this->Flash->error(__('The patient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function clinicianIndex()
    {
        $this->checkRole(['clinician']);

        $search = $this->request->getQuery('search');
        $targetTable = $this->request->getQuery('target');
        $clinicianId = $this->getClinicianId();

        if ($clinicianId) {
            $myPatientsQuery = $this->Patients->find()
                ->where(['Patients.clinician_id' => $clinicianId])
                ->contain(['Users', 'Clinicians.Users']);

            if (!empty($search) && $targetTable === 'my_patients') {
                $myPatientsQuery->where([
                    'OR' => [
                        'Users.first_name LIKE' => '%' . $search . '%',
                        'Users.last_name LIKE' => '%' . $search . '%',
                        'Users.phone LIKE' => '%' . $search . '%',
                    ],
                ]);
            }

            $allPatientsQuery = $this->Patients->find()
                ->contain(['Users', 'Clinicians.Users']);

            if (!empty($search) && ($targetTable === 'all_patients' || empty($targetTable))) {
                $allPatientsQuery->where([
                    'OR' => [
                        'Users.first_name LIKE' => '%' . $search . '%',
                        'Users.last_name LIKE' => '%' . $search . '%',
                        'Users.phone LIKE' => '%' . $search . '%',
                    ],
                ]);
            }

            $myPatients = $this->paginate($myPatientsQuery, [
                'scope' => 'myPatients',
                'limit' => 10,
            ]);

            $allPatients = $this->paginate($allPatientsQuery, [
                'scope' => 'allPatients',
                'limit' => 10,
            ]);

            $this->set(compact('myPatients', 'allPatients'));

            if ($this->request->is('ajax')) {
                $this->viewBuilder()->disableAutoLayout();

                if ($targetTable === 'my_patients') {
                    return $this->render('/element/table/entity_tables/clinician_patients_table');
                } elseif ($targetTable === 'all_patients') {
                    return $this->render('/element/table/entity_tables/clinician_allpatients_table');
                } else {
                    throw new Exception('Something went wrong!');
                }
            }
        }
    }

    /**
     * @return void
     */
    public function dashboard()
    {
        $this->checkRole(['patient']);

        parent::initialize();

        // 1. 获取当前登录账户的 User ID
        $identity = $this->Authentication->getIdentity();
        $userId = $identity->get('id');

        // 2. 找到该 User 关联的 Patient 记录
        $patient = $this->fetchTable('Patients')
            ->find()
            ->where(['user_id' => $userId])
            ->first();

        // 安全检查：如果该用户没有关联的病人资料
        if (!$patient) {
            $this->Flash->error(__('Patient profile not found.'));

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $todayStart = FrozenTime::now()->startOfDay();
        $todayEnd = FrozenTime::now()->endOfDay();

        $todaysMeasurements = $this->fetchTable('PatientMeasurements')
            ->find()
            ->where([
                'patient_id' => $patient->id,
                'measured_at >=' => $todayStart,
                'measured_at <=' => $todayEnd,
            ])
            ->all();

        $timeSlots = [
            'morning' => false,
            'midday' => false,
            'afternoon' => false,
            'evening' => false,
        ];

        foreach ($todaysMeasurements as $measurement) {
            // Get the hour in 24-hour format (0 to 23)
            $hour = (int)$measurement->measured_at->format('G');

            if ($hour < 12) {
                $timeSlots['morning'] = true;
            } elseif ($hour >= 12 && $hour < 16) {
                $timeSlots['midday'] = true;
            } elseif ($hour >= 16 && $hour < 20) {
                $timeSlots['afternoon'] = true;
            } else {
                $timeSlots['evening'] = true;
            }
        }

        // Count how many true
        $completedCount = count(array_filter($timeSlots));

        // 3. 构建查询：只获取属于该 patient_id 的测量数据
        $query = $this->fetchTable('PatientMeasurements')
            ->find()
            ->where(['patient_id' => $patient->id]);

        // 4. 执行分页
        $patientMeasurements = $this->paginate($query, [
            'limit' => 10,
            'order' => ['measured_at' => 'desc'],
        ]);

        $this->set(compact('patientMeasurements', 'completedCount', 'timeSlots'));
    }

}
