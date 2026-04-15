<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class AdminsController extends AppController
{

    public function dashboard()
    {
        $identity = $this->Authentication->getIdentity();

        if ($identity->get('role') !== 'admin') {
            throw new NotFoundException('Page not found');
        }

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
