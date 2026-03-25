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
        $reminders = $this->fetchTable('Reminders')->find()
            ->contain(['Patients', 'Clinicians'])
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
