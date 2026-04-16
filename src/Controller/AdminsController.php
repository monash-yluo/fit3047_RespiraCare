<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class AdminsController extends AppController
{

    public function dashboard()
    {
        $this->checkRole(['admin']);

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
