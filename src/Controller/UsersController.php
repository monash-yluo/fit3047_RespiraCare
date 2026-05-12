<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\Mailer;
use Exception;
use Psr\Http\Message\UploadedFileInterface;
use SplFileInfo;

use function Cake\Error\debug;

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

        $this->Authentication->allowUnauthenticated(['login', 'logout', 'resetPassword', 'sendVerifyCode']);
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

        // 1. Get the search term from the URL
        $search = $this->request->getQuery('search');

        // 2. If a search term exists, apply the WHERE conditions
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Users.first_name LIKE' => '%' . $search . '%',
                    'Users.last_name LIKE' => '%' . $search . '%',
                    'Users.phone LIKE' => '%' . $search . '%',
                    'Users.email LIKE' => '%' . $search . '%',
                ],
            ]);
        }

        $filter = $this->request->getQuery('role');

        if (!empty($filter)) {
            $query->where([
                'Users.role' => $filter
            ]);
        }

        $this->paginate = [
            'limit' => 10,
            'order' => ['Users.created' => 'DESC'],
        ];

        $users = $this->paginate($query);
        $this->set(compact('users'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/users_table');
        }
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

        if ($identity->get('role') === 'patient' && $identity->get('id') !== $user->id) {
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
                // 如果是 clinician，还加载他负责的患者列表
                $patientsTable = $this->fetchTable('Patients');
                $patients = $patientsTable->find()
                    ->where(['Patients.clinician_id' => $clinician->id])
                    ->contain(['Users'])
                    ->all();

                if ($patients) {
                    $clinician->patients = $patients;
                }
            }

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
            $tempFile = null;
            $newFilename = null;

            if (!empty($data['phone'])) {
                $digits = preg_replace('/[^0-9]/', '', $data['phone']);
                if (str_starts_with($digits, '61')) {
                    $digits = substr($digits, 2);
                }

                if (str_starts_with($digits, '0')) {
                    $digits = substr($digits, 1);
                }

                $digitCount = strlen($digits);
                if ($digitCount === 9) {
                    // Apply the +61 format
                    $data['phone'] = sprintf(
                        '+61 %s %s %s',
                        substr($digits, 0, 3),
                        substr($digits, 3, 3),
                        substr($digits, 6, 3),
                    );
                }
            }

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
            if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFileInterface) {
                $file = $data['image_path'];

                if ($file->getError() !== 0) {
                    if ($file->getError() === 1 || $file->getError() === 2) {
                        $this->Flash->error(__('The file is too big.'));
                    } elseif ($file->getError() !== 4) {
                        $this->Flash->error(__('Error uploading image.'));
                    }
                    if ($file->getError() !== 4) {
                        return $this->render();
                    }
                }

                if ($file->getClientFilename() !== '' && $file->getSize() > 0) {
                    // Prepare metadata but DON'T MOVE
                    $extension = preg_replace(
                        '/[^a-z0-9]/',
                        '',
                        strtolower((new SplFileInfo($file->getClientFilename()))->getExtension()),
                    );
                    $newFilename = md5(random_bytes(10)) . '.' . $extension;
                    $tempFile = $file;

                    $data['image_path'] = $newFilename;
                } else {
                    unset($data['image_path']);
                }
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                // Move the file to the correct location
                if ($tempFile && $newFilename) {
                    try {
                        $destDir = WWW_ROOT . 'img' . DS . 'users';
                        if (!is_dir($destDir)) {
                            mkdir($destDir, 0755, true);
                        }

                        $tempFile->moveTo($destDir . DS . $newFilename);
                    } catch (Exception $e) {
                        $this->Flash->warning(__('User saved, but image upload failed.'));
                    }
                }

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
            $tempFile = null;
            $newFilename = null;
            $oldImageFilename = $user->image_path;

            // Extract patient data before patching entity
            $patientData = [];

            if (!empty($data['phone'])) {
                $digits = preg_replace('/[^0-9]/', '', $data['phone']);
                if (str_starts_with($digits, '61')) {
                    $digits = substr($digits, 2);
                }

                if (str_starts_with($digits, '0')) {
                    $digits = substr($digits, 1);
                }

                $digitCount = strlen($digits);
                if ($digitCount === 9) {
                    // Apply the +61 format
                    $data['phone'] = sprintf(
                        '+61 %s %s %s',
                        substr($digits, 0, 3),
                        substr($digits, 3, 3),
                        substr($digits, 6, 3),
                    );
                }
            }

            if ($user->role === 'patient') {
                $patient = $data['patient'] ?? [];

                // Store patient data separately
                if (!empty($patient['dob'])) {
                    $patientData['dob'] = $patient['dob'];
                }
                if (!empty($patient['sex'])) {
                    $patientData['sex'] = $patient['sex'];
                }
                if (!empty($patient['notes'])) {
                    $patientData['notes'] = $patient['notes'];
                }
                // Handle clinician_id - can be empty/null
                if (array_key_exists('clinician_id', $patient)) {
                    $patientData['clinician_id'] = !empty($patient['clinician_id']) ? $patient['clinician_id'] : null;
                }

                // Remove patient data from user data
                unset($data['patient']);
            }

            // If password is empty, don't update it
            if (empty($data['password'])) {
                unset($data['password']);
            }

            // Handle file upload
            if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFileInterface) {
                $file = $data['image_path'];

                if ($file->getError() !== 0) {
                    if ($file->getError() === 4) {
                        unset($data['image_path']);
                    } else {
                        if ($file->getError() === 1 || $file->getError() === 2) {
                            $this->Flash->error(__('The file you uploaded is too big.'));
                        } else {
                            $this->Flash->error(__('There was an error uploading the file.'));
                        }

                        return $this->render();
                    }
                }

                if ($file->getClientFilename() !== '' && $file->getSize() > 0) {
                    $extension = preg_replace(
                        '/[^a-z0-9]/',
                        '',
                        strtolower((new SplFileInfo($file->getClientFilename()))->getExtension()),
                    );
                    $newFilename = md5(random_bytes(10)) . '.' . $extension;
                    $tempFile = $file;

                    // Set filename for the entity check
                    $data['image_path'] = $newFilename;
                } else {
                    unset($data['image_path']);
                }
            }

            // If no Image is uploaded and was checked to remove
            if (!empty($data['delete_image']) && $data['delete_image'] === 'on' && empty($data['image_path'])) {
                $data['image_path'] = null;
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $destDir = WWW_ROOT . 'img' . DS . 'users';
                $oldFilepath = !empty($oldImageFilename) ? $destDir . DS . $oldImageFilename : null;

                if (!empty($data['delete_image']) && $data['delete_image'] === 'on' && empty($tempFile)) {
                    if ($oldFilepath && file_exists($oldFilepath) && is_file($oldFilepath)) {
                        unlink($oldFilepath);
                    }
                }

                if ($tempFile && $newFilename) {
                    try {
                        if (!is_dir($destDir)) {
                            mkdir($destDir, 0755, true);
                        }

                        $tempFile->moveTo($destDir . DS . $newFilename);

                        if ($oldFilepath && file_exists($oldFilepath) && is_file($oldFilepath)) {
                            unlink($oldFilepath);
                        }
                    } catch (Exception $e) {
                        $this->Flash->warning(__('User saved, but new image could not be processed.'));
                    }
                }

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
        $oldImageFilename = $user->image_path;

        if ($user->email === 'admin@respiracare.com') {
            $this->Flash->error(__('The master administrator account cannot be deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Users->delete($user)) {
            if (!empty($oldImageFilename)) {
                $oldFilepath = WWW_ROOT . 'img' . DS . 'users' . DS . $oldImageFilename;
                if (file_exists($oldFilepath) && is_file($oldFilepath)) {
                    unlink($oldFilepath);
                }
            }

            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteImage($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        $oldImage = $user->image_path;
        $user->image_path = null;

        if ($this->Users->save($user)) {
            if ($oldImage) {
                $path = WWW_ROOT . 'img' . DS . 'users' . DS . $oldImage;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $this->Flash->success(__('The image has been deleted.'));
        } else {
            $this->Flash->error(__('The image could not be deleted.'));
        }

        return $this->redirect(['action' => 'edit', $id]);
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
     * through email and verification code. It also includes
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
                'secret' => Configure::read('Turnstile.secretKey'),
                'response' => $token,
                'remoteip' => $this->request->clientIp(),
            ]);

            $outcome = $response->getJson();

            // --- 2. 如果验证码校验失败 ---
            if (!($outcome['success'] ?? false)) {
                $this->Flash->error(__('CAPTCHA verification failed. Please try again.'));

                return;
            }

            // --- 3. 验证邮箱验证码 ---
            $email = $data['email'] ?? null;
            $verifyCode = $data['verify_code'] ?? null;

            if (!$email || !$verifyCode) {
                $this->Flash->error(__('Email and verification code are required.'));

                return;
            }

            // 检查验证码是否正确
            $codeKey = 'reset_code_' . $email;
            $storedCode = \Cake\Cache\Cache::read($codeKey);

            if ($storedCode === null || $storedCode != $verifyCode) {
                $this->Flash->error(__('Invalid or expired verification code. Please request a new code.'));

                return;
            }

            // --- 4. 验证新密码 ---
            $password = $data['password'] ?? null;
            $passwordConfirm = $data['password_confirm'] ?? null;

            if (!$password || !$passwordConfirm) {
                $this->Flash->error(__('Password and confirmation are required.'));

                return;
            }

            if ($password !== $passwordConfirm) {
                $this->Flash->error(__('Passwords do not match.'));

                return;
            }

            if (strlen($password) < 8) {
                $this->Flash->error(__('Password must be at least 8 characters long.'));

                return;
            }

            // --- 5. 查找用户并更新密码 ---
            $user = $this->Users->findByEmail($email)->first();

            if (!$user) {
                $this->Flash->error(__('User not found.'));

                return;
            }

            // 更新密码
            $user->password = $password;

            if ($this->Users->save($user)) {
                // 验证码正确，清除缓存
                \Cake\Cache\Cache::delete($codeKey);

                $this->Flash->success(__('Your password has been reset successfully. Please log in with your new password.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            } else {
                $this->Flash->error(__('Failed to reset password. Please try again.'));

                return;
            }
        }
    }
    
    /**
     * Send verify code to email
     *
     * @return \Cake\Http\Response
     */
    public function sendVerifyCode()
    {
        if (!$this->request->is('post')) {
            return $this->response
                ->withStatus(405)
                ->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Method not allowed']));
        }

        $data = $this->request->getData();
        $email = $data['email'] ?? null;

        if (!$email) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Email is required'
                ]));
        }

        // 检查邮箱是否存在
        $user = $this->Users->findByEmail($email)->first();
        if (!$user) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Email not found in our records'
                ]));
        }

        // 生成验证码
        $verifyCode = rand(100000, 999999);
        
        try {
            // 保存验证码到缓存（有效期10分钟）
            $codeKey = 'reset_code_' . $email;
            \Cake\Cache\Cache::write($codeKey, $verifyCode, 'default', '+10 minutes');


            // 发送邮件
            $mailer = new Mailer();
            // $mailer->setTransport('cpanel');
            $mailer->setTo($email)
                ->setEmailFormat('both')
                ->setSubject('Password Reset Verification Code - RespiraCare');
            
            $mailer->viewBuilder()
                ->setVar('verifyCode', $verifyCode)
                ->setVar('userName', $user->first_name)
                ->setTemplate('reset_code_email')
                ->setLayout('email');
            
            $mailer->send();
            
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'message' => 'Verification code sent successfully'
                ]));
        } catch (Exception $e) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]));
        }
    }
}
