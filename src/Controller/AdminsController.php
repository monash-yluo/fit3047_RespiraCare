<?php
declare(strict_types=1);

namespace App\Controller;

use DateTime;

class AdminsController extends AppController
{
    public function dashboard()
    {
        $this->checkRole(['admin']);

        // Contact Message Table
        $searchTerm = $this->request->getQuery('search');
        $query = $this->fetchTable('ContactMessages')->find();

        if (!empty($searchTerm)) {
            $query->where([
                'OR' => [
                    'ContactMessages.first_name LIKE' => '%' . $searchTerm . '%',
                    'ContactMessages.last_name LIKE' => '%' . $searchTerm . '%',
                    'ContactMessages.email LIKE' => '%' . $searchTerm . '%',
                    'ContactMessages.category LIKE' => '%' . $searchTerm . '%',
                ],
            ]);
        }

        $contactMessages = $this->paginate($query, [
            'limit' => 10,
            'order' => ['created' => 'desc'],
        ]);

        // Card Data
        $totalMessages = $query->count();
        $totalClinicians = $this->fetchTable('Clinicians')->find()->count();
        $totalPatients = $this->fetchTable('Patients')->find()->count();

        // Chart Variable
        $chartLabels = [];
        $messagesChartData = [];
        $patientsChartData = [];

        $contactMessagesTable = $this->fetchTable('ContactMessages');
        $patientsTable = $this->fetchTable('Patients');

        // Chart Data
        for ($i = 5; $i >= 0; $i--) {
            $date = new DateTime("first day of -$i months");
            $monthStart = $date->format('Y-m-01 00:00:00');
            $monthEnd = $date->format('Y-m-t 23:59:59');

            $chartLabels[] = $date->format('M Y');

            // Query messages for that specific month
            $messagesChartData[] = $contactMessagesTable->find()
                ->where([
                    'created >=' => $monthStart,
                    'created <=' => $monthEnd,
                ])
                ->count();

            // Query new patients for that specific month
            $patientsChartData[] = $patientsTable->find()
                ->where([
                    'created >=' => $monthStart,
                    'created <=' => $monthEnd,
                ])
                ->count();
        }

        $this->set(compact(
            'contactMessages',
            'totalMessages',
            'totalClinicians',
            'totalPatients',
            'chartLabels',
            'messagesChartData',
            'patientsChartData',
        ));

        // ajax
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/admin_dashboard_table');
        }
    }
}
