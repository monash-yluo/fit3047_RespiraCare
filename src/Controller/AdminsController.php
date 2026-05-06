<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class AdminsController extends AppController
{

    public function dashboard()
    {
        $this->checkRole(['admin']);

        $searchTerm = $this->request->getQuery('search');
        $query = $this->fetchTable('ContactMessages')->find();

        if (!empty($searchTerm)) {
            $query->where([
                'OR' => [
                    'ContactMessages.first_name LIKE' => '%' . $searchTerm . '%',
                    'ContactMessages.last_name LIKE' => '%' . $searchTerm . '%',
                    'ContactMessages.email LIKE' => '%' . $searchTerm . '%',
                    'ContactMessages.category LIKE' => '%' . $searchTerm . '%',
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

        $this->set(compact('contactMessages', 'totalMessages', 'totalClinicians', 'totalPatients'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/admin_dashboard_table');
        }
    }
}
