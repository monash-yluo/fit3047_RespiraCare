<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

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

        $query = $this->Patients->find()
            ->contain(['Users', 'Clinicians.Users']);
        $patients = $this->paginate($query);

        $this->set(compact('patients'));
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
        $identity = $this->request->getAttribute('identity');
        $this->checkRole(['clinician']);

        $clinicianId = $this->getClinicianId();

        if ($clinicianId) {
            // Get own patients
            $myPatientsQuery = $this->Patients->find()
                ->where(['clinician_id' => $clinicianId])
                ->contain(['Users', 'Clinicians.Users']);
            $myPatients = $this->paginate($myPatientsQuery, ['scope' => 'myPatients']);

            // Get all patients
            $allPatientsQuery = $this->Patients->find()
                ->contain(['Users', 'Clinicians.Users']);
            $allPatients = $this->paginate($allPatientsQuery, ['scope' => 'allPatients']);

            $this->set(compact('myPatients', 'allPatients'));
        }
    }

    /**
     * @return void
     */
    public function dashboard()
    {
        $this->checkRole(['patient']);

        parent::initialize();

        $identity = $this->Authentication->getIdentity();

        if ($identity->get('role') !== 'patient') {
            throw new NotFoundException('Page not found');
        }

        // 1. 获取当前登录账户的 User ID
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

        // 3. 构建查询：只获取属于该 patient_id 的测量数据
        $query = $this->fetchTable('PatientMeasurements')
            ->find()
            ->where(['patient_id' => $patient->id]);

        // 4. 执行分页
        $patientMeasurements = $this->paginate($query, [
            'limit' => 10,
            'order' => ['measured_at' => 'desc'],
        ]);

        $this->set(compact('patientMeasurements'));
    }
}
