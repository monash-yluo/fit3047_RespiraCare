<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;

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
        $this->checkRole(['admin']);

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
        $identity = $this->Authentication->getIdentity();

        // 先获取基本用户信息
        $user = $this->Users->get($id, contain: []);

        if ($identity->get('role') !== 'admin' && $identity->get('id') !== $user->id) {
            throw new NotFoundException('Page not found');
        }

        // 根据用户的 role 加载相关关联数据
        if ($user->role === 'patient') {
            // 使用 Patients 表加载患者信息
            $patientsTable = $this->fetchTable('Patients');
            $patient = $patientsTable->find()
                ->where(['Patients.user_id' => $user->id])
                ->first();

            if ($patient) {
                // 如果有分配的 clinician，加载 clinician 信息
                if (!empty($patient->clinician_id)) {
                    $cliniciansTable = $this->fetchTable('Clinicians');
                    $clinician = $cliniciansTable->find()
                        ->where(['Clinicians.id' => $patient->clinician_id])
                        ->contain(['Users'])
                        ->first();
                    $patient->clinician = $clinician;
                }
                $user->patient = $patient;
            }
        } elseif ($user->role === 'clinician') {
            // 使用 Clinicians 表加载临床医生信息
            $cliniciansTable = $this->fetchTable('Clinicians');
            $clinician = $cliniciansTable->find()
                ->where(['Clinicians.user_id' => $user->id])
                ->first();

            if ($clinician) {
                $user->clinician = $clinician;
            }
        }

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->checkRole(['admin']);

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Extract patient data before patching entity
            $patientData = [];
            $role = $data['role'] ?? null;

            if ($role === 'patient') {
                // Store patient data separately
                if (!empty($data['patient_dob'])) {
                    $patientData['dob'] = $data['patient_dob'];
                }
                if (!empty($data['patient_sex'])) {
                    $patientData['sex'] = $data['patient_sex'];
                }
                if (!empty($data['patient_notes'])) {
                    $patientData['notes'] = $data['patient_notes'];
                }
                if (!empty($data['patient_clinician_id'])) {
                    $patientData['clinician_id'] = $data['patient_clinician_id'];
                }

                // Remove patient data from user data
                unset($data['patient_dob']);
                unset($data['patient_sex']);
                unset($data['patient_notes']);
                unset($data['patient_clinician_id']);
            }

            // Handle file upload
            if (isset($data['image_path'])) {
                $file = $data['image_path'];
                // Check if it's an uploaded file with actual content
                if (is_object($file) && method_exists($file, 'getClientFilename') && !empty($file->getClientFilename()) && $file->getSize() > 0) {
                    try {
                        $uploadDir = WWW_ROOT . 'img' . DS . 'users' . DS;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $filename = time() . '_' . $file->getClientFilename();
                        $file->moveTo($uploadDir . $filename);
                        $data['image_path'] = '/img/users/' . $filename;
                    } catch (\Exception $e) {
                        $this->Flash->error(__('Failed to upload image: ' . $e->getMessage()));
                        $this->set(compact('user'));
                        return;
                    }
                } else {
                    unset($data['image_path']);
                }
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                // If role is patient, create patient record
                if ($role === 'patient') {
                    $patientsTable = $this->fetchTable('Patients');
                    $patient = $patientsTable->newEmptyEntity();
                    $patientData['user_id'] = $user->id;

                    $patient = $patientsTable->patchEntity($patient, $patientData);
                    if (!$patientsTable->save($patient)) {
                        // If patient creation fails, delete the created user
                        $this->Users->delete($user);
                        $this->Flash->error(__('Failed to create patient record. User has been reverted.'));
                        $this->set(compact('user'));
                        return;
                    }
                }
                if ($role === 'clinician') {
                    $cliniciansTable = $this->fetchTable('Clinicians');
                    $clinician = $cliniciansTable->newEmptyEntity();
                    $clinician->user_id = $user->id;

                    if (!$cliniciansTable->save($clinician)) {
                        // If clinician creation fails, delete the created user
                        $this->Users->delete($user);
                        $this->Flash->error(__('Failed to create clinician record. User has been reverted.'));
                        $this->set(compact('user'));
                        return;
                    }
                }

                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        // Load clinicians list for patient clinician assignment
        $clinicians = [];
        $cliniciansTable = $this->fetchTable('Clinicians');
        $cliniciansList = $cliniciansTable->find()
            ->contain(['Users'])
            ->all();

        foreach ($cliniciansList as $clinician) {
            $clinicians[$clinician->id] = $clinician->user->first_name . ' ' . $clinician->user->last_name;
        }

        $this->set(compact('user', 'clinicians'));
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
        $this->checkRole(['admin']);

        $user = $this->Users->get($id, contain: []);

        // Load patient data if user is a patient
        if ($user->role === 'patient') {
            $patientsTable = $this->fetchTable('Patients');
            $patient = $patientsTable->find()
                ->where(['Patients.user_id' => $user->id])
                ->first();

            if ($patient) {
                $user->patient = $patient;
            }
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Extract patient data before patching entity
            $patientData = [];

            if ($user->role === 'patient') {
                // Store patient data separately
                if (!empty($data['patient_dob'])) {
                    $patientData['dob'] = $data['patient_dob'];
                }
                if (!empty($data['patient_sex'])) {
                    $patientData['sex'] = $data['patient_sex'];
                }
                if (!empty($data['patient_notes'])) {
                    $patientData['notes'] = $data['patient_notes'];
                }
                // Handle clinician_id - can be empty/null
                if (isset($data['patient_clinician_id'])) {
                    $patientData['clinician_id'] = !empty($data['patient_clinician_id']) ? $data['patient_clinician_id'] : null;
                }

                // Remove patient data from user data
                unset($data['patient_dob']);
                unset($data['patient_sex']);
                unset($data['patient_notes']);
                unset($data['patient_clinician_id']);
            }

            // If password is empty, don't update it
            if (empty($data['password'])) {
                unset($data['password']);
            }

            // Handle file upload
            if (isset($data['image_path'])) {
                $file = $data['image_path'];
                // Check if it's an uploaded file with actual content
                if (is_object($file) && method_exists($file, 'getClientFilename') && !empty($file->getClientFilename()) && $file->getSize() > 0) {
                    try {
                        $uploadDir = WWW_ROOT . 'img' . DS . 'users' . DS;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $filename = time() . '_' . $file->getClientFilename();
                        $file->moveTo($uploadDir . $filename);
                        $data['image_path'] = '/img/users/' . $filename;
                    } catch (\Exception $e) {
                        $this->Flash->error(__('Failed to upload image: ' . $e->getMessage()));
                        $this->set(compact('user'));
                        return;
                    }
                } else {
                    unset($data['image_path']);
                }
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                // Save patient data if exists
                if (isset($user->patient) && !empty($patientData)) {
                    $patientsTable = $this->fetchTable('Patients');
                    $patient = $user->patient;
                    $patient = $patientsTable->patchEntity($patient, $patientData);
                    $patientsTable->save($patient);
                }

                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        // Clear password field so form doesn't display the hash
        unset($user->password);

        // Load clinicians list for patient clinician assignment
        $clinicians = [];
        if ($user->role === 'patient') {
            $cliniciansTable = $this->fetchTable('Clinicians');
            $cliniciansList = $cliniciansTable->find()
                ->contain(['Users'])
                ->all();

            foreach ($cliniciansList as $clinician) {
                $clinicians[$clinician->id] = $clinician->user->first_name . ' ' . $clinician->user->last_name;
            }
        }

        $this->set(compact('user', 'clinicians'));
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
        $this->checkRole(['admin']);

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function roleRedirect($role)
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
                    'controller' => 'Patients',
                    'action' => 'dashboard',
                ],
            ); // Patient
        } elseif ($role === 'clinician') {
            return $this->redirect(
                [
                    'controller' => 'Clinicians',
                    'action' => 'dashboard',
                ],
            ); // Clinician
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
                $redirect = $this->roleRedirect($identity->role);
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
                $redirect = $this->roleRedirect($result->getData()->role);

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
