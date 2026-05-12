<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SymptomTypes Controller
 *
 * @property \App\Model\Table\SymptomTypesTable $SymptomTypes
 */
class SymptomTypesController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->checkRole(['admin']);

        $symptomType = $this->SymptomTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $symptomType = $this->SymptomTypes->patchEntity($symptomType, $this->request->getData());
            if ($this->SymptomTypes->save($symptomType)) {
                $this->Flash->success(__('The symptom type has been saved.'));

                return $this->redirect(['controller' => 'AdminContentBlocks', 'action' => 'index']);
            }
            $this->Flash->error(__('The symptom type could not be saved. Please, try again.'));
        }
        $symptomLogs = $this->SymptomTypes->SymptomLogs->find('list', limit: 200)->all();
        $this->set(compact('symptomType', 'symptomLogs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Symptom Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->checkRole(['admin']);

        $this->request->allowMethod(['post', 'delete']);
        $symptomType = $this->SymptomTypes->get($id);
        if ($this->SymptomTypes->delete($symptomType)) {
            $this->Flash->success(__('The symptom type has been deleted.'));
        } else {
            $this->Flash->error(__('The symptom type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'AdminContentBlocks', 'action' => 'index']);
    }
}
