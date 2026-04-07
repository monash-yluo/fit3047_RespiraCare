<?php
declare(strict_types=1);

namespace App\Controller;

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
        $patientMeasurement = $this->PatientMeasurements->get($id, contain: ['Patients']);
        $this->set(compact('patientMeasurement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $patientMeasurement = $this->PatientMeasurements->newEmptyEntity();
        if ($this->request->is('post')) {
            $patientMeasurement = $this->PatientMeasurements->patchEntity($patientMeasurement, $this->request->getData());
            if ($this->PatientMeasurements->save($patientMeasurement)) {
                $this->Flash->success(__('The patient measurement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient measurement could not be saved. Please, try again.'));
        }
        $patients = $this->PatientMeasurements->Patients->find('list', limit: 200)->all();
        $this->set(compact('patientMeasurement', 'patients'));
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
        $patientMeasurement = $this->PatientMeasurements->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patientMeasurement = $this->PatientMeasurements->patchEntity($patientMeasurement, $this->request->getData());
            if ($this->PatientMeasurements->save($patientMeasurement)) {
                $this->Flash->success(__('The patient measurement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient measurement could not be saved. Please, try again.'));
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
        $this->request->allowMethod(['post', 'delete']);
        $patientMeasurement = $this->PatientMeasurements->get($id);
        if ($this->PatientMeasurements->delete($patientMeasurement)) {
            $this->Flash->success(__('The measurement has been deleted.'));
        } else {
            $this->Flash->error(__('The measurement could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    public function patientAdd()
    {
        $patientMeasurement = $this->PatientMeasurements->newEmptyEntity();

        if ($this->request->is('post')) {
            $patientMeasurement = $this->PatientMeasurements->patchEntity($patientMeasurement, $this->request->getData());

            // 1. 获取当前登录 User 的 ID
            $userId = $this->Authentication->getIdentity()->get('id');

            // 2. 通过 user_id 找到对应的 patient 记录
            $patient = $this->PatientMeasurements->Patients->find()
                ->select(['id'])
                ->where(['user_id' => $userId])
                ->first();

            if ($patient) {
                // 3. 将真正的 patient_id 赋值
                $patientMeasurement->patient_id = $patient->id;

                if ($this->PatientMeasurements->save($patientMeasurement)) {
                    $this->Flash->success(__('The measurement data has been successfully saved.'));
                    return $this->redirect(['controller' => 'PatientPortals', 'action' => 'dashboard']);
                }
            } else {
                $this->Flash->error(__('Patient profile not found. Please contact the administrator.'));
            }

            $this->Flash->error(__('Failed to save. Please try again.'));
        }
        $this->set(compact('patientMeasurement'));
    }

    public function patientView(?string $id = null)
    {
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
            return $this->redirect(['controller' => 'PatientPortals', 'action' => 'dashboard']);
        }

        $this->set(compact('patientMeasurement'));
    }
}
