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
        $contactMessages = $this->paginate(
            $this->fetchTable('ContactMessages')->find(),
            [
            'limit' => 10,
            'order' => ['created' => 'desc'],
            ],
        );

        $this->set(compact('contactMessages'));
    }
}
