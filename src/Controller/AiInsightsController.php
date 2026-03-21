<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AiInsights Controller
 *
 * @property \App\Model\Table\AiInsightsTable $AiInsights
 */
class AiInsightsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AiInsights->find()
            ->contain(['Patients']);
        $aiInsights = $this->paginate($query);

        $this->set(compact('aiInsights'));
    }

    /**
     * View method
     *
     * @param string|null $id Ai Insight id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $aiInsight = $this->AiInsights->get($id, contain: ['Patients']);
        $this->set(compact('aiInsight'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aiInsight = $this->AiInsights->newEmptyEntity();
        if ($this->request->is('post')) {
            $aiInsight = $this->AiInsights->patchEntity($aiInsight, $this->request->getData());
            if ($this->AiInsights->save($aiInsight)) {
                $this->Flash->success(__('The ai insight has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ai insight could not be saved. Please, try again.'));
        }
        $patients = $this->AiInsights->Patients->find('list', limit: 200)->all();
        $this->set(compact('aiInsight', 'patients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ai Insight id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $aiInsight = $this->AiInsights->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aiInsight = $this->AiInsights->patchEntity($aiInsight, $this->request->getData());
            if ($this->AiInsights->save($aiInsight)) {
                $this->Flash->success(__('The ai insight has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ai insight could not be saved. Please, try again.'));
        }
        $patients = $this->AiInsights->Patients->find('list', limit: 200)->all();
        $this->set(compact('aiInsight', 'patients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ai Insight id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $aiInsight = $this->AiInsights->get($id);
        if ($this->AiInsights->delete($aiInsight)) {
            $this->Flash->success(__('The ai insight has been deleted.'));
        } else {
            $this->Flash->error(__('The ai insight could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
