<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;

/**
 * ContactMessages Controller
 *
 * @property \App\Model\Table\ContactMessagesTable $ContactMessages
 */
class ContactMessagesController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['contact']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->checkRole(['admin']);

        $query = $this->ContactMessages->find()
            ->contain(['Patients']);

        $query = $this->ContactMessages->find()
            ->contain(['Patients']);
        $contactMessages = $this->paginate($query);

        $this->set(compact('contactMessages'));
    }

    /**
     * View method
     *
     * @param string|null $id Contact Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->checkRole(['admin']);

        $contactMessage = $this->ContactMessages->get($id, contain: ['Patients']);

        $contactMessage = $this->ContactMessages->get($id, contain: ['Patients']);
        $this->set(compact('contactMessage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contactMessage = $this->ContactMessages->newEmptyEntity();
        if ($this->request->is('post')) {
            $contactMessage = $this->ContactMessages->patchEntity($contactMessage, $this->request->getData());
            if ($this->ContactMessages->save($contactMessage)) {
                $this->Flash->success(__('The contact message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact message could not be saved. Please, try again.'));
        }
        $patients = $this->ContactMessages->Patients->find('list', limit: 200)->all();
        $this->set(compact('contactMessage', 'patients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $this->checkRole(['admin']);

        $contactMessage = $this->ContactMessages->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contactMessage = $this->ContactMessages->patchEntity($contactMessage, $this->request->getData());
            if ($this->ContactMessages->save($contactMessage)) {
                $this->Flash->success(__('The contact message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact message could not be saved. Please, try again.'));
        }
        $patients = $this->ContactMessages->Patients->find('list', limit: 200)->all();
        $this->set(compact('contactMessage', 'patients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->checkRole(['admin']);

        $this->request->allowMethod(['post', 'delete']);
        $contactMessage = $this->ContactMessages->get($id);
        if ($this->ContactMessages->delete($contactMessage)) {
            $this->Flash->success(__('The contact message has been deleted.'));
        } else {
            $this->Flash->error(__('The contact message could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    public function contact()
    {
        $contactMessage = $this->ContactMessages->newEmptyEntity();

        if ($this->request->is('post')) {
            // --- 1. 获取并校验 Turnstile Token ---
            $token = $this->request->getData('cf-turnstile-response');

            $http = new Client();
            $response = $http->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => Configure::read('Turnstile.secretKey'), // 改用 Configure::read('Turnstile.secretKey')
                'response' => $token,
                'remoteip' => $this->request->clientIp(),
            ]);

            $outcome = $response->getJson();

            // --- 2. 如果验证码校验失败 ---
            if (!($outcome['success'] ?? false)) {
                $this->Flash->error(__('CAPTCHA verification failed. Please try again.'));
            }
            // --- 3. 如果验证码校验成功 ---
            else {
                $contactMessage = $this->ContactMessages->patchEntity($contactMessage, $this->request->getData());
                if ($this->ContactMessages->save($contactMessage)) {
                    $this->Flash->success(__('The contact message has been saved.'));

                    return $this->redirect(['action' => 'contact']);
                }
                $this->Flash->error(__('The contact message could not be saved. Please, try again.'));
            }
        }

        $patients = $this->ContactMessages->Patients->find('list', limit: 200)->all();
        $this->set(compact('contactMessage', 'patients'));
    }

    public function changeStatus($id = null)
    {
        $contactMessage = $this->ContactMessages->get($id);
        $contactMessage->status = $contactMessage->status === 'open' ? 'close' : 'open';
        $this->ContactMessages->save($contactMessage);
        $this->Flash->success(__('The status of the contact message has been changed.'));

        return $this->redirect(['action' => 'view', $id]);
    }
}
