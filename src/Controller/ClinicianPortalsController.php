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
    }
}
