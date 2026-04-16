<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class PatientPortalsController extends AppController
{

    /**
     * @return void
     */
    public function dashboard()
    {
        $this->checkRole(['patient']);

        parent::initialize();

        $identity = $this->Authentication->getIdentity();

        if ($identity->get('role') !== 'patient') {
            throw new NotFoundException('Page not found');
        }

        // 1. 获取当前登录账户的 User ID
        $userId = $identity->get('id');

        // 2. 找到该 User 关联的 Patient 记录
        $patient = $this->fetchTable('Patients')
            ->find()
            ->where(['user_id' => $userId])
            ->first();

        // 安全检查：如果该用户没有关联的病人资料
        if (!$patient) {
            $this->Flash->error(__('Patient profile not found.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // 3. 构建查询：只获取属于该 patient_id 的测量数据
        $query = $this->fetchTable('PatientMeasurements')
            ->find()
            ->where(['patient_id' => $patient->id]);

        // 4. 执行分页
        $patientMeasurements = $this->paginate($query, [
            'limit' => 10,
            'order' => ['measured_at' => 'desc'],
        ]);

        $this->set(compact('patientMeasurements'));
    }
}
