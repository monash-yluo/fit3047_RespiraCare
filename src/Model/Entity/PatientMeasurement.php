<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PatientMeasurement Entity
 *
 * @property int $id
 * @property int $patient_id
 * @property \Cake\I18n\DateTime $measured_at
 * @property int|null $spo2
 * @property int|null $heart_rate
 * @property float|null $temperature
 * @property int|null $respiratory_rate
 * @property int|null $peak_flow
 * @property int|null $blood_pressure_systolic
 * @property int|null $blood_pressure_diastolic
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Patient $patient
 */
class PatientMeasurement extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'patient_id' => true,
        'measured_at' => true,
        'spo2' => true,
        'heart_rate' => true,
        'temperature' => true,
        'respiratory_rate' => true,
        'peak_flow' => true,
        'blood_pressure_systolic' => true,
        'blood_pressure_diastolic' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'patient' => true,
    ];
}
