<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SymptomLogs Controller
 *
 * @property \App\Model\Table\SymptomLogsTable $SymptomLogs
 */
class SymptomLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SymptomLogs->find()
            ->contain(['Patients']);
        $symptomLogs = $this->paginate($query);

        $this->set(compact('symptomLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Symptom Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $symptomLog = $this->SymptomLogs->get($id, contain: ['Patients', 'SymptomTypes']);
        $this->set(compact('symptomLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $symptomLog = $this->SymptomLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $symptomLog = $this->SymptomLogs->patchEntity($symptomLog, $this->request->getData());
            if ($this->SymptomLogs->save($symptomLog)) {
                $this->Flash->success(__('The symptom log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The symptom log could not be saved. Please, try again.'));
        }
        $patients = $this->SymptomLogs->Patients->find('list', limit: 200)->all();
        $symptomTypes = $this->SymptomLogs->SymptomTypes->find('list', limit: 200)->all();
        $this->set(compact('symptomLog', 'patients', 'symptomTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Symptom Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $symptomLog = $this->SymptomLogs->get($id, contain: ['SymptomTypes']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $symptomLog = $this->SymptomLogs->patchEntity($symptomLog, $this->request->getData());
            if ($this->SymptomLogs->save($symptomLog)) {
                $this->Flash->success(__('The symptom log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The symptom log could not be saved. Please, try again.'));
        }
        $patients = $this->SymptomLogs->Patients->find('list', limit: 200)->all();
        $symptomTypes = $this->SymptomLogs->SymptomTypes->find('list', limit: 200)->all();
        $this->set(compact('symptomLog', 'patients', 'symptomTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Symptom Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $symptomLog = $this->SymptomLogs->get($id);
        if ($this->SymptomLogs->delete($symptomLog)) {
            $this->Flash->success(__('The symptom log has been deleted.'));
        } else {
            $this->Flash->error(__('The symptom log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function patientIndex()
    {
        $patientId = $this->getPatientId();

        if (!$patientId) {
            $this->Flash->error(__('Patient profile not found.'));

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $query = $this->SymptomLogs->find()
            ->where(['patient_id' => $patientId])
            ->contain(['SymptomTypes']);

        $symptomLogs = $this->paginate($query, [
            'limit' => 10,
            'order' => ['started_at' => 'desc'],
        ]);

        $this->set(compact('symptomLogs'));
    }

    public function patientAdd()
    {
        $symptomLog = $this->SymptomLogs->newEmptyEntity();

        $patientId = $this->getPatientId();
        if (!$patientId) {
            $this->Flash->error(__('Patient profile not found.'));
            return $this->redirect(['controller' => 'PatientPortals', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $symptomLog = $this->SymptomLogs->patchEntity($symptomLog, $this->request->getData());
            $symptomLog->patient_id = $patientId;

            if ($this->SymptomLogs->save($symptomLog)) {
                $this->Flash->success(__('The symptom log has been saved.'));

                return $this->redirect(['action' => 'patientIndex']);
            }
            $this->Flash->error(__('The symptom log could not be saved. Please, try again.'));
        }

        $symptomTypes = $this->SymptomLogs->SymptomTypes->find('list', limit: 200)->all();
        $this->set(compact('symptomLog', 'symptomTypes'));
    }
}
