<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;

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

        $this->Authentication->allowUnauthenticated(['login', 'logout', 'resetPassword']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
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
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
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
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
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
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
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

    protected function _roleRedirect($role)
    {
        if ($role === 'admin') {
            return $this->redirect(
                [
                    'controller' => 'Admins',
                    'action' => 'dashboard',
                ],
            ); // admin
        } elseif ($role === 'patient') {
            return $this->redirect(
                [
                    'controller' => 'PatientPortals',
                    'action' => 'dashboard',
                ],
            ); // Patient
        } else {
            return null;
        }
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('get')) {
            // 0. 先用 getIdentity 看用户是不是之前就登录过了 (Session 还在)
            $identity = $this->Authentication->getIdentity();

            if ($identity) {
                $redirect = $this->_roleRedirect($identity->role);
                if ($redirect) {
                    return $redirect;
                } else {
                    $this->Authentication->logout();
                }
            }
        }

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
                $redirect = $this->_roleRedirect($result->getData()->role);

                if ($redirect) {
                    return $redirect;
                } else {
                    $this->Authentication->logout();
                }
            }

            // 如果账号密码错误
            if (!$result->isValid()) {
                $this->Flash->error(__('Invalid username or password'));
            }
        }
    }

    /**
     * Logout method.
     *
     * Logs the current user out and redirects them to the login page.
     *
     * @return \Cake\Http\Response|null Redirects to the login page.
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Reset password method.
     *
     * Allows a user to reset their password after verifying their identity
     * through first name, last name, and email. It also includes
     * CAPTCHA verification to prevent abuse.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful password reset, otherwise renders the view.
     */
    public function resetPassword()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // --- 1. 获取并校验 Turnstile Token ---
            $token = $data['cf-turnstile-response'];

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

                return; // 停止执行，让用户停留在登录页
            }

            // 1. 基础验证：确保两次输入的新密码一致
            if (empty($data['new_password']) || $data['new_password'] !== $data['confirm_new_password']) {
                $this->Flash->error(__('New passwords do not match or are empty.'));

                return;
            }

            // 2. 根据 first_name, last_name, email 查找用户
            $user = $this->Users->find()
                ->where([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                ])
                ->first();

            if ($user) {
                // 3. 修改密码并保存
                $user->password = $data['new_password'];

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your password has been reset successfully.'));

                    return $this->redirect(['action' => 'login']);
                }
                $this->Flash->error(__('Unable to update the password. Please try again.'));
            } else {
                // 4. 用户信息不匹配
                $this->Flash->error(__('User details do not match our records.'));
            }
        }
    }
}
