<?php
declare(strict_types=1);

namespace App\Controller;

class AdminsController extends AppController
{
    /**
     * @return void
     */
    public function dashboard(): void
    {
        $currentUserId = $this->Authentication->getIdentity()->get('id');

        $reminders = $this->fetchTable('Reminders')->find()
            ->contain(['Senders'])
            ->where(['Reminders.receiver_id' => $currentUserId])
            ->orderBy(['Reminders.created' => 'DESC'])
            ->limit(5)
            ->all();

        $contactMessages = $this->paginate(
            $this->fetchTable('ContactMessages')->find(),
            [
            'limit' => 10,
            'order' => ['created' => 'desc'],
            ],
        );

        $this->set(compact('reminders', 'contactMessages'));
    }
}
