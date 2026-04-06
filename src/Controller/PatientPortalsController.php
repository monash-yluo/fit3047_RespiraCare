<?php
declare(strict_types=1);

namespace App\Controller;

class PatientPortalsController extends AppController
{
    /**
     * @return void
     */
    public function dashboard(): void
    {
        $patientMeasurements = $this->paginate(
            $this->fetchTable('PatientMeasurements')->find(),
            [
                'limit' => 10,
                'order' => ['measured_at' => 'desc'],
            ],
        );

        $this->set(compact('patientMeasurements'));
    }
}
