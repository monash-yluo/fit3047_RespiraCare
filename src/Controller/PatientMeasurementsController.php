<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use DateTime;

/**
 * PatientMeasurements Controller
 *
 * @property \App\Model\Table\PatientMeasurementsTable $PatientMeasurements
 */
class PatientMeasurementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->checkRole(['patient']);

        $datePreset = $this->request->getQuery('date_preset');
        $patientId = $this->getPatientId();

        $query = $this->PatientMeasurements->find()
            ->where(['PatientMeasurements.patient_id' => $patientId])
            ->orderBy(['PatientMeasurements.measured_at' => 'DESC']);

        if (!empty($datePreset)) {
            $query = $this->applyDateFilter($query, $datePreset);
        }

        $patientMeasurements = $this->paginate($query, [
            'limit' => 10,
        ]);

        $this->set(compact('patientMeasurements'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/patient_measurements_table');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Patient Measurement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->checkRole(['admin', 'clinician']);

        $patientMeasurement = $this->PatientMeasurements->get($id, contain: ['Patients' => ['Users', 'Clinicians' => ['Users']]]);
        $this->set(compact('patientMeasurement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Patient Measurement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $this->checkRole(['admin', 'patient']);
        $role = $this->Authentication->getIdentity()->role;

        // 权限检查：如果是患者，确保只能更改自己的 / Permission check: if patient, ensure they can only edit their own records
        if ($role === 'patient') {
            $patientMeasurement = $this->PatientMeasurements->get($id);
            if ($patientMeasurement->patient_id !== $this->getPatientId()) {
                $this->Flash->error(__('You are not authorized to edit this record.'));

                return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
            }
        }

        $patientMeasurement = $this->PatientMeasurements->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patientMeasurement = $this->PatientMeasurements->patchEntity($patientMeasurement, $this->request->getData());

            # 检查舒张压必须小于收缩压 / Check that diastolic is less than systolic
            # 先检查是否有 血压数据，再比较，避免空值导致的错误 / Check if blood pressure data is present before comparing to avoid errors from null values
            if ($patientMeasurement->diastolic && $patientMeasurement->systolic && $patientMeasurement->diastolic >= $patientMeasurement->systolic) {
                $this->Flash->error(__('Diastolic pressure must be less than systolic pressure.'));
                $this->set(compact('patientMeasurement'));

                return;
            }

            if ($patientMeasurement->measured_at && $patientMeasurement->measured_at->isFuture()) {
                $this->Flash->error(__('The measurement date and time cannot be in the future.'));
            } elseif ($this->PatientMeasurements->save($patientMeasurement)) {
                $this->Flash->success(__('The patient measurement has been saved.'));

                if ($role === 'patient') {
                    return $this->redirect(['controller' => 'PatientMeasurements', 'action' => 'patientView', $patientMeasurement->id]);
                } elseif ($role === 'admin') {
                    return $this->redirect(['controller' => 'PatientMeasurements', 'action' => 'view', $patientMeasurement->id]);
                }
            } else {
                $this->Flash->error(__('The patient measurement could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('patientMeasurement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Patient Measurement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->checkRole(['admin', 'patient']);

        // 权限检查：如果是患者，确保只能删除自己的 / Permission check: if patient, ensure they can only delete their own records
        if ($this->Authentication->getIdentity()->role === 'patient') {
            $patientMeasurement = $this->PatientMeasurements->get($id);
            if ($patientMeasurement->patient_id !== $this->getPatientId()) {
                $this->Flash->error(__('You are not authorized to delete this record.'));

                return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
            }
        }

        $this->request->allowMethod(['post', 'delete']);
        $patientMeasurement = $this->PatientMeasurements->get($id);
        if ($this->PatientMeasurements->delete($patientMeasurement)) {
            $this->Flash->success(__('The measurement has been deleted.'));
        } else {
            $this->Flash->error(__('The measurement could not be deleted. Please, try again.'));
        }

        if ($this->Authentication->getIdentity()->role === 'admin') {
            return $this->redirect(['controller' => 'Patients', 'action' => 'view', $patientMeasurement->patient_id]);
        } else {
            return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
        }
    }

    public function add(?string $patientId = null)
    {
        # 权限检查：允许 admin 和 patient
        $this->checkRole(['admin', 'patient']);

        $patientMeasurement = $this->PatientMeasurements->newEmptyEntity();
        $actualPatientId = null;

        $identity = $this->Authentication->getIdentity();

        if ($identity->role === 'admin') {
            // Admin 从参数中获取 patient_id
            $actualPatientId = $patientId ?? $this->request->getData('patient_id');
        } else {
            // Patient 从登录用户自动查询
            $actualPatientId = $this->getPatientId();
        }

        if (!$actualPatientId) {
            $this->Flash->error(__('Patient profile not found.'));
            if ($identity->role === 'admin') {
                return $this->redirect(['controller' => 'Patients', 'action' => 'view', $patientId]);
            } else {
                return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
            }
        }

        if ($this->request->is('post')) {
            $patientMeasurement = $this->PatientMeasurements->patchEntity($patientMeasurement, $this->request->getData());
            $patientMeasurement->set('patient_id', $actualPatientId);

            # 检查舒张压必须小于收缩压 / Check that diastolic is less than systolic
            # 先检查是否有 血压数据，再比较，避免空值导致的错误 / Check if blood pressure data is present before comparing to avoid errors from null values
            if ($patientMeasurement->diastolic && $patientMeasurement->systolic && $patientMeasurement->diastolic >= $patientMeasurement->systolic) {
                $this->Flash->error(__('Diastolic pressure must be less than systolic pressure.'));
                $this->set(compact('patientMeasurement'));

                return;
            }

            if ($patientMeasurement->measured_at && $patientMeasurement->measured_at->isFuture()) {
                $this->Flash->error(__('The measurement date and time cannot be in the future.'));
            } elseif ($this->PatientMeasurements->save($patientMeasurement)) {
                $this->Flash->success(__('The measurement data has been successfully saved.'));

                if ($identity->role === 'admin') {
                    return $this->redirect(['controller' => 'Patients', 'action' => 'view', $actualPatientId]);
                } else {
                    return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
                }
            } else {
                $this->Flash->error(__('Failed to save. Please try again.'));
            }
        }

        $this->set(compact('patientMeasurement'));
    }

    public function patientView(?string $id = null)
    {
        $this->checkRole(['patient']);

        // 1. 获取当前登录账户的 User ID
        $currentUserId = $this->Authentication->getIdentity()->get('id');

        // 2. 在查询时，通过 Patients 表做 Inner Join 过滤
        // 确保这条测量记录所属的 Patient，其对应的 user_id 是当前登录者
        $patientMeasurement = $this->PatientMeasurements->find()
            ->where(['PatientMeasurements.id' => $id])
            ->contain(['Patients' => function ($q) use ($currentUserId) {
                return $q->where(['Patients.user_id' => $currentUserId]);
            }])
            ->first();

        // 3. 安全检查
        // 如果查询结果为空，或者关联的 Patient 没查到（说明 user_id 不匹配）
        if (!$patientMeasurement || !$patientMeasurement->patient) {
            $this->Flash->error(__('You are not authorized to view this record.'));

            return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
        }

        $this->set(compact('patientMeasurement'));
    }

    public function skip($timeSlot = null)
    {
        $this->checkRole(['patient']);
        $this->request->allowMethod(['post', 'delete']);

        $slotTimes = [
            'morning' => [8, 0],
            'midday' => [12, 0],
            'afternoon' => [16, 0],
            'evening' => [20, 0],
        ];

        // Get the patient
        $identity = $this->Authentication->getIdentity();
        $patient = $this->fetchTable('Patients')
            ->find()
            ->contain(['Users', 'Clinicians.Users'])
            ->where(['Patients.user_id' => $identity->get('id')])
            ->first();

        if (!$patient) {
            $this->Flash->error(__('Patient profile not found.'));

            return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
        }

        [$hour, $minute] = $slotTimes[strtolower($timeSlot)] ?? [FrozenTime::now('Australia/Sydney')->hour, FrozenTime::now('Australia/Sydney')->minute];
        $scheduledTime = FrozenTime::now('Australia/Sydney')->setTime($hour, $minute);

        // Add an empty
        $measurement = $this->PatientMeasurements->newEmptyEntity();

        $measurement->set('patient_id', $patient->id);
        $measurement->set('measured_at', $scheduledTime);
        $measurement->set('notes', sprintf(
            '%s skipped their %s measurements.',
            $patient->user->full_name,
            strtolower($timeSlot),
        ));

        if ($this->PatientMeasurements->save($measurement, ['validate' => false])) {
            if (!empty($patient->clinician) && !empty($patient->clinician->user_id)) {
                $remindersTable = $this->fetchTable('Reminders');
                $reminder = $remindersTable->newEmptyEntity();

                $reminder->set('receiver_id', $patient->clinician->user_id);
                $reminder->set('message', sprintf(
                    'System Alert: %s %s has skipped their %s reading on %s.',
                    $identity->get('first_name'),
                    $identity->get('last_name'),
                    ucfirst($timeSlot),
                    FrozenTime::now()->format('M d, Y'),
                ));

                $remindersTable->save($reminder);
            }

            $this->Flash->success(__('You have skipped the {0} reading.', ucfirst($timeSlot)));
        } else {
            $this->Flash->error(__('Unable to skip reading. Please try again.'));
        }

        return $this->redirect(['controller' => 'Patients', 'action' => 'dashboard']);
    }

    private function applyDateFilter($query, $preset)
    {
        $date = null;
        switch ($preset) {
            case 'today':
                $date = new DateTime('today');
                break;
            case '7':
                $date = new DateTime('-7 days');
                break;
            case '30':
                $date = new DateTime('-30 days');
                break;
            case '90':
                $date = new DateTime('-90 days');
                break;
        }

        return $date ? $query->where(['PatientMeasurements.measured_at >=' => $date]) : $query;
    }
}
