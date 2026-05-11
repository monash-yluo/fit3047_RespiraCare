<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reminders Controller
 *
 * @property \App\Model\Table\RemindersTable $Reminders
 */

use Cake\Http\Exception\NotFoundException;

class RemindersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $search = $this->request->getQuery('search');
        $query = $this->Reminders->find()
            ->contain(['Receivers', 'Senders']);

        $isReadParam = $this->request->getQuery('is_read');

        if ($isReadParam === 'unread') {
            $query->where(['Reminders.is_read' => 0]);
        } elseif ($isReadParam === 'read') {
            $query->where(['Reminders.is_read' => 1]);
        }

        // Only admins can see all reminders, others can only see their own
        $identity = $this->Authentication->getIdentity();
        if ($identity && $identity->role !== 'admin') {
            $query->where([
                'OR' => [
                    'receiver_id' => $identity->id,
                    'sender_id' => $identity->id,
                ],
            ]);
        }

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Receivers.first_name LIKE' => '%' . $search . '%',
                    'Receivers.last_name LIKE' => '%' . $search . '%',
                    'Senders.first_name LIKE' => '%' . $search . '%',
                    'Senders.last_name LIKE' => '%' . $search . '%',
                ],
            ]);
        }

        $this->paginate = [
            'limit' => 10,
            'order' => ['created' => 'DESC'],
        ];

        $reminders = $this->paginate($query);
        $this->set(compact('reminders'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/reminders_table');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Reminder id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $reminder = $this->Reminders->get($id, contain: ['Receivers', 'Senders']);

        // Only admins can see all reminders, others can only see their own
        $identity = $this->Authentication->getIdentity();
        if ($identity && $identity->role !== 'admin') {
            if ($reminder->receiver_id !== $identity->id && $reminder->sender_id !== $identity->id) {
                throw new NotFoundException(__('Page not found'));
            }
        }

        if ($reminder->receiver_id === $identity->get('id') && !$reminder->is_read) {
            $reminder->is_read = true;
            $this->Reminders->save($reminder);
        }

        $this->set(compact('reminder'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reminder = $this->Reminders->newEmptyEntity();
        $senders = $this->Authentication->getIdentity();

        if ($this->request->is('post')) {
            $reminder = $this->Reminders->patchEntity($reminder, $this->request->getData());
            $reminder->set('sender_id', $senders->id);

            if ($reminder->receiver_id === $senders->id) {
                $this->Flash->error(__('You cannot send a reminder to yourself.'));
            }

            if ($this->Reminders->save($reminder)) {
                $this->Flash->success(__('The reminder has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reminder could not be saved. Please, try again.'));
        }
        $receivers = $this->Reminders->Receivers->find('list', limit: 200)->where(['Receivers.id !=' => $senders->id])->all();
        $senders = $this->Reminders->Senders->find('list', limit: 200)->all();
        $this->set(compact('reminder', 'receivers', 'senders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reminder id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $reminder = $this->Reminders->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reminder = $this->Reminders->patchEntity($reminder, $this->request->getData());
            if ($this->Reminders->save($reminder)) {
                $this->Flash->success(__('The reminder has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reminder could not be saved. Please, try again.'));
        }
        $receivers = $this->Reminders->Receivers->find('list', limit: 200)->all();
        $senders = $this->Reminders->Senders->find('list', limit: 200)->all();
        $this->set(compact('reminder', 'receivers', 'senders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reminder id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reminder = $this->Reminders->get($id);
        if ($this->Reminders->delete($reminder)) {
            $this->Flash->success(__('The reminder has been deleted.'));
        } else {
            $this->Flash->error(__('The reminder could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
