<?php
declare(strict_types=1);

namespace App\Controller;

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
        $patient = $this->Patients->get($id, contain: ['Users', 'Clinicians.Users', 'PatientMeasurements', 'SymptomLogs' => ['SymptomTypes']]);
        $this->set(compact('patient'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $patient = $this->Patients->newEmptyEntity();
        if ($this->request->is('post')) {
            $patient = $this->Patients->patchEntity($patient, $this->request->getData());
            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('The patient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient could not be saved. Please, try again.'));
        }
        $users = $this->Patients->Users->find('list', limit: 200)->all();
        $clinicians = $this->Patients->Clinicians->find('list', limit: 200)->all();
        $this->set(compact('patient', 'users', 'clinicians'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $patient = $this->Patients->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patient = $this->Patients->patchEntity($patient, $this->request->getData());
            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('The patient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient could not be saved. Please, try again.'));
        }
        $users = $this->Patients->Users->find('list', limit: 200)->all();
        $clinicians = $this->Patients->Clinicians->find('list', limit: 200)->all();
        $this->set(compact('patient', 'users', 'clinicians'));
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
}
