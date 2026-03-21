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
    public function view($id = null)
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
    public function edit($id = null)
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $patientMeasurement = $this->PatientMeasurements->get($id);
        if ($this->PatientMeasurements->delete($patientMeasurement)) {
            $this->Flash->success(__('The patient measurement has been deleted.'));
        } else {
            $this->Flash->error(__('The patient measurement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
