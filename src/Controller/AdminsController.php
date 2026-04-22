<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class AdminsController extends AppController
{

    public function dashboard()
    {
        $this->checkRole(['admin']);

        $search = $this->request->getQuery('search');
        $query = $this->fetchTable('ContactMessages')->find();

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'ContactMessages.first_name LIKE' => '%' . $search . '%',
                    'ContactMessages.last_name LIKE' => '%' . $search . '%',
                    'ContactMessages.email LIKE' => '%' . $search . '%',
                    'ContactMessages.category LIKE' => '%' . $search . '%',
                ]
            ]);
        }

        $contactMessages = $this->paginate($query, [
            'limit' => 10,
            'order' => ['created' => 'desc'],
        ]);

        $totalMessages = $query->count();
        $totalClinicians = $this->fetchTable('Clinicians')->find()->count();
        $totalPatients = $this->fetchTable('Patients')->find()->count();

        $this->set(compact('contactMessages', 'totalMessages', 'totalClinicians', 'totalPatients', 'search'));
    }
}
