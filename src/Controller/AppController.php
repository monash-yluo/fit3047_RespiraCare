<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

        // load Authentication component
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\EventInterface $event An Event instance
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // // 判断插件
        // $plugin = $this->request->getParam('plugin');
        // $controller = $this->request->getParam('controller');
        // debug("Plugin: $plugin, Controller: $controller");

        // if ($plugin === 'ContentBlocks' && $controller === 'ContentBlocks') {
        //     $this->checkRole(['admin']); // 仅管理员允许访问
        // }

        if (
            $this->request->is('get') &&
            !$this->request->is('ajax') &&
            $this->request->getParam('action') !== 'goBack'
        ) {
            $session = $this->request->getSession();
            $history = $session->read('User.History', []);
            $currentUrl = $this->request->getRequestTarget();

            // Prevent recording the exact same page twice in a row
            if (end($history) !== $currentUrl) {
                $history[] = $currentUrl;

                // Keep the last 10 pages in memory
                if (count($history) > 10) {
                    array_shift($history);
                }
                $session->write('User.History', $history);
            }
        }

        $identity = $this->Authentication->getIdentity();
        $reminders = null;

        if ($identity) {
            $reminders = $this->fetchTable('Reminders')->find()
                ->contain(['Senders'])
                ->where(['Reminders.receiver_id' => $identity->get('id')])
                ->orderBy(['Reminders.created' => 'DESC'])
                ->limit(5)
                ->all();
        }

        $this->set(compact('identity', 'reminders'));
    }

    /**
     * Generic utility method to retrieve the Patient ID of the currently logged-in user.
     *
     * @return int|null The Patient ID, or null if not found
     */
    protected function getPatientId(): ?int
    {
        // 1. Get the User ID of the currently logged-in account
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return null;
        }

        $userId = $identity->get('id');

        // 2. Find the associated Patient
        // Use getTableLocator to ensure loading the Patients table in any Controller
        $patient = $this->getTableLocator()->get('Patients')
            ->find()
            ->where(['user_id' => $userId])
            ->select(['id']) // Only select ID to improve efficiency
            ->first();

        return $patient ? (int)$patient->id : null;
    }

    protected function getClinicianId(): ?int
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return null;
        }
        $userId = $identity->get('id');

        $clinician = $this->getTableLocator()->get('Clinicians')
            ->find()
            ->where(['user_id' => $userId])
            ->select(['id'])
            ->first();

        return $clinician ? (int)$clinician->id : null;
    }

    protected function checkRole(array $requiredRole)
    {
        $identity = $this->Authentication->getIdentity();

        if (!$identity || !in_array($identity->get('role'), $requiredRole)) {
            throw new NotFoundException('Page not found');
        }
    }

    public function goBack(): \Cake\Http\Response
    {
        $session = $this->request->getSession();
        $history = $session->read('User.History', []);

        // Remove current page
        array_pop($history);

        // Deduplicate trailing entries
        while (count($history) >= 2 && end($history) === $history[count($history) - 2]) {
            array_pop($history);
        }

        // Pop the target stack
        $target = array_pop($history);

        // Save trimmed history
        $session->write('User.History', $history);

        if (!$target) {
            $identity = $this->request->getAttribute('identity');
            $role = $identity?->role;
            $dashboardRoutes = [
                'admin'     => ['controller' => 'Admins',     'action' => 'dashboard'],
                'clinician' => ['controller' => 'Clinicians', 'action' => 'dashboard'],
                'patient'   => ['controller' => 'Patients',   'action' => 'dashboard'],
            ];
            return $this->redirect($dashboardRoutes[$role] ?? '/');
        }

        return $this->redirect($target);
    }
}
