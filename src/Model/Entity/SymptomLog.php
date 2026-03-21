<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SymptomLog Entity
 *
 * @property int $id
 * @property int $patient_id
 * @property string|null $description
 * @property \Cake\I18n\DateTime $logged_at
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\SymptomType[] $symptom_types
 */
class SymptomLog extends Entity
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
        'description' => true,
        'logged_at' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'patient' => true,
        'symptom_types' => true,
    ];
}
