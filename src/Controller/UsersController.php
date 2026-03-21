<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

         $this->Authentication->allowUnauthenticated(['login']);
    }

    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @return Response|null|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('get')) {
            // 0. 先用 getIdentity 看用户是不是之前就登录过了 (Session 还在)
            $identity = $this->Authentication->getIdentity();
//            \Cake\Error\debug($identity);
            if ($identity) {
                return $this->redirect(['action' => 'index']); // 已登录
            }
        }


        if ($this->request->is('post')) {
            // --- 1. 获取并校验 Turnstile Token ---
            $token = $this->request->getData('cf-turnstile-response');

            $http = new \Cake\Http\Client();
            $response = $http->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => Configure::read('Turnstile.secretKey'), // 改用 Configure::read('Turnstile.secretKey')
                'response' => $token,
                'remoteip' => $this->request->clientIp()
            ]);

            $outcome = $response->getJson();
//            \Cake\Error\debug($outcome);

            // --- 2. 如果验证码校验失败 ---
            if (!($outcome['success'] ?? false)) {
                $this->Flash->error(__('CAPTCHA verification failed. Please try again.'));
                // 关键：如果插件已经因为账号密码对而登录了，这里必须强制登出
                $this->Authentication->logout();
                return; // 停止执行，让用户停留在登录页
            }

            // --- 3. 验证码通过后，再判断账号密码是否正确 ---
            $result = $this->Authentication->getResult(); // 这个只是获取结果真实的登录逻辑在中间页已经执行过了
            if ($result && $result->isValid()) {
                $redirect = $this->request->getQuery('redirect', [
                    'controller' => 'Users',
                    'action' => 'index'
                ]);
                return $this->redirect($redirect);
            }

            // 如果账号密码错误
            if (!$result->isValid()) {
                $this->Flash->error(__('Invalid username or password'));
            }
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
