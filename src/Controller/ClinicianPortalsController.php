<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class ClinicianPortalsController extends AppController
{

    /**
     * @return void
     */
    public function dashboard()
    {
        $this->checkRole(['clinician']);
        
        $clinicianId = $this->getClinicianId();
        
        if ($clinicianId) {
            // Get patients assigned to this clinician
            $patientsQuery = $this->fetchTable('Patients')->find()
                ->where(['clinician_id' => $clinicianId])
                ->contain(['Users']);
            
            $patients = $this->paginate($patientsQuery);
            $patientCount = $this->fetchTable('Patients')->find()
                ->where(['clinician_id' => $clinicianId])
                ->count();
            
            $this->set(compact('patients', 'patientCount'));
        }
    }
}
