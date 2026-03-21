<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Booking Entity
 *
 * @property int $id
 * @property int $patient_id
 * @property int $clinician_id
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $scheduled_date
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Clinician $clinician
 */
class Booking extends Entity
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
        'clinician_id' => true,
        'notes' => true,
        'scheduled_date' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'patient' => true,
        'clinician' => true,
    ];
}
