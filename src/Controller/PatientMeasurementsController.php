<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

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
        $this->checkRole(['admin', 'clinician']);
        // TEMP
        throw new NotFoundException('Page not found');

        $query = $this->PatientMeasurements->find()
            ->contain(['Patients']);
        $patientMeasurements = $this->paginate($query);

        $this->set(compact('patientMeasurements'));
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
            if ($patientMeasurement->diastolic >= $patientMeasurement->systolic) {
                $this->Flash->error(__('Diastolic pressure must be less than systolic pressure.'));
                $this->set(compact('patientMeasurement', 'patients'));
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
        $patients = $this->PatientMeasurements->Patients->find('list', limit: 200)->all();
        $this->set(compact('patientMeasurement', 'patients'));
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
            if ($patientMeasurement->diastolic >= $patientMeasurement->systolic) {
                $this->Flash->error(__('Diastolic pressure must be less than systolic pressure.'));
                $this->set(compact('patientMeasurement', 'patients'));
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

        $this->set(compact('patientMeasurement', 'patientId'));
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
}
