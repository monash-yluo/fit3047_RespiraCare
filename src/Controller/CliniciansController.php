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
        $this->checkRole(["admin"]);

        $query = $this->Clinicians->find()
            ->contain(['Users']);
        $clinicians = $this->paginate($query);

        $this->set(compact('clinicians'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clinician id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
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

        $clinicianId = $this->getClinicianId();

        if ($clinicianId) {
            // Get patients assigned to this clinician
            $patientsQuery = $this->fetchTable('Patients')->find()
                ->where(['clinician_id' => $clinicianId])
                ->contain(['Users']);

            $patients = $this->paginate($patientsQuery);
            $patientCount = $this->fetchTable('Patients')->find()
                ->where(['clinician_id' => $clinicianId])
                ->count();

            $this->set(compact('patients', 'patientCount'));
        }
    }
}
