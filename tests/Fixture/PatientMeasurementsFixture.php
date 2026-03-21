<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PatientMeasurementsFixture
 */
class PatientMeasurementsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'patient_id' => 1,
                'measured_at' => '2026-03-21 04:38:08',
                'spo2' => 1,
                'heart_rate' => 1,
                'temperature' => 1,
                'respiratory_rate' => 1,
                'peak_flow' => 1,
                'blood_pressure_systolic' => 1,
                'blood_pressure_diastolic' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-03-21 04:38:08',
                'modified' => '2026-03-21 04:38:08',
            ],
        ];
        parent::init();
    }
}
