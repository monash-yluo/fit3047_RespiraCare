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
     * View method
     *
     * @param string|null $id Symptom Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->checkRole(['admin', 'clinician']);

        $symptomLog = $this->SymptomLogs->get($id, contain: ['Patients' => ['Users', 'Clinicians' => ['Users']], 'SymptomTypes']);
        $this->set(compact('symptomLog'));
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
        $this->checkRole(['admin', 'patient']);

        $identity = $this->Authentication->getIdentity();

        # 权限检查：如果是患者，确保只能更改自己的 / Permission check: if patient, ensure they can only edit their own logs
        if ($identity->role === 'patient') {
            $symptomLog = $this->SymptomLogs->get($id);
            if ($symptomLog->patient_id !== $this->getPatientId()) {
                $this->Flash->error(__('You do not have permission to edit this symptom log.'));
                return $this->redirect(['action' => 'patientIndex']);
            }
        }

        $symptomLog = $this->SymptomLogs->get($id, contain: ['SymptomTypes']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $symptomLog = $this->SymptomLogs->patchEntity($symptomLog, $this->request->getData());
            if ($this->SymptomLogs->save($symptomLog)) {
                $this->Flash->success(__('The symptom log has been saved.'));

                // 根据角色返回不同的重定向 / Redirect differently based on role
                if ($identity->role === 'admin' || $identity->role === 'clinician') {
                    return $this->redirect(['controller' => 'Patients', 'action' => 'view', $symptomLog->patient_id]);
                } else {
                    return $this->redirect(['controller' => 'SymptomLogs', 'action' => 'patientView', $symptomLog->id]);
                }
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
        $this->checkRole(['admin', 'patient']);

        $identity = $this->Authentication->getIdentity();

        # 权限检查：如果是患者，确保只能删除自己的日志 / Permission check: if patient, ensure they can only delete their own logs
        if ($identity->role === 'patient') {
            $symptomLog = $this->SymptomLogs->get($id);
            if ($symptomLog->patient_id !== $this->getPatientId()) {
                $this->Flash->error(__('You do not have permission to delete this symptom log.'));

                return $this->redirect(['action' => 'patientIndex']);
            }
        }

        $this->request->allowMethod(['post', 'delete']);
        $symptomLog = $this->SymptomLogs->get($id);
        if ($this->SymptomLogs->delete($symptomLog)) {
            $this->Flash->success(__('The symptom log has been deleted.'));
        } else {
            $this->Flash->error(__('The symptom log could not be deleted. Please, try again.'));
        }

        if ($identity->role === 'admin' || $identity->role === 'clinician') {
            return $this->redirect(['controller' => 'Patients', 'action' => 'view', $symptomLog->patient_id]);
        } else {
            return $this->redirect(['controller' => 'SymptomLogs', 'action' => 'patientIndex']);
        }
    }

    public function patientIndex()
    {
        $this->checkRole(['patient']);

        $patientId = $this->getPatientId();
        $datePreset = $this->request->getQuery('date_preset');
        $symptomType = $this->request->getQuery('symptoms_type');

        if (!$patientId) {
            $this->Flash->error(__('Patient profile not found.'));

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $query = $this->SymptomLogs->find()
            ->where(['patient_id' => $patientId])
            ->contain(['SymptomTypes'])
            ->orderBy(['SymptomLogs.created' => 'DESC']);

        if (!empty($datePreset)) {
            $query = $this->applyDateFilter($query, $datePreset);
        }

        if ($symptomType === 'no_symptom') {
            $query->notMatching('SymptomTypes');
        } elseif ($symptomType === 'with_symtoms') {
            $query->matching('SymptomTypes')->distinct(['SymptomLogs.id']);
        }

        $symptomLogs = $this->paginate($query, [
            'limit' => 10,
        ]);

        $this->set(compact('symptomLogs'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
            return $this->render('/element/table/entity_tables/patient_symptoms_table');
        }
    }

    public function add(?string $patientId = null)
    {
        # 权限检查：允许 admin 和 patient / Permission check: allow admin and patient
        $this->checkRole(['admin', 'patient']);

        $symptomLog = $this->SymptomLogs->newEmptyEntity();
        $actualPatientId = null;

        $identity = $this->Authentication->getIdentity();

        if ($identity->role === 'admin') {
            // Admin 从参数中获取 patient_id / Admin gets patient_id from parameter
            $actualPatientId = $patientId ?? $this->request->getData('patient_id');
        } else {
            // Patient 从登录用户自动查询 / Patient automatically gets from logged-in user
            $actualPatientId = $this->getPatientId();
        }

        if (!$actualPatientId) {
            $this->Flash->error(__('Patient profile not found.'));
            if ($identity->role === 'admin') {
                return $this->redirect(['controller' => 'Patients', 'action' => 'index']);
            } else {
                return $this->redirect(['controller' => 'SymptomLogs', 'action' => 'patientIndex']);
            }
        }

        if ($this->request->is('post')) {
            $symptomLog = $this->SymptomLogs->patchEntity($symptomLog, $this->request->getData());
            $symptomLog->patient_id = $actualPatientId;

            if ($this->SymptomLogs->save($symptomLog)) {
                $this->Flash->success(__('The symptom log has been saved.'));

                // 根据角色返回不同的重定向 / Redirect differently based on role
                if ($identity->role === 'admin' || $identity->role === 'clinician') {
                    return $this->redirect(['controller' => 'Patients', 'action' => 'view', $actualPatientId]);
                } else {
                    return $this->redirect(['controller' => 'SymptomLogs', 'action' => 'patientIndex']);
                }
            }
            $this->Flash->error(__('The symptom log could not be saved. Please, try again.'));
        }

        $symptomTypes = $this->SymptomLogs->SymptomTypes->find('list', limit: 200)->all();
        $this->set(compact('symptomLog', 'symptomTypes', 'patientId'));
    }

    public function patientView(?string $id = null)
    {
        $this->checkRole(['patient']);

        $patientId = $this->getPatientId();
        if (!$patientId) {
            $this->Flash->error(__('Patient profile not found.'));
            return $this->redirect(['controller' => 'Patients', 'action' => 'index']);
        }

        $symptomLog = $this->SymptomLogs->find()
            ->where(['SymptomLogs.id' => $id, 'SymptomLogs.patient_id' => $patientId])
            ->contain(['SymptomTypes'])
            ->first();

        if (!$symptomLog) {
            $this->Flash->error(__('Symptom log not found.'));
            return $this->redirect(['action' => 'patientIndex']);
        }

        $this->set(compact('symptomLog'));
    }

    /**
     * Helper to keep logic clean
     */
    private function applyDateFilter($query, $preset)
    {
        $start = null;
        switch ($preset) {
            case 'today': $start = new \DateTime('today'); break;
            case '7': $start = new \DateTime('-7 days'); break;
            case '30': $start = new \DateTime('-30 days'); break;
            case '90': $start = new \DateTime('-90 days'); break;
        }
        return $start ? $query->where(['SymptomLogs.created >=' => $start]) : $query;
    }
}
