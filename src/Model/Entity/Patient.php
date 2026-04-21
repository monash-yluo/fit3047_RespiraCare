<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Patient Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $clinician_id
 * @property \Cake\I18n\Date|null $dob
 * @property string|null $sex
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Clinician $clinician
 * @property \App\Model\Entity\AiInsight[] $ai_insights
 * @property \App\Model\Entity\Booking[] $bookings
 * @property \App\Model\Entity\ContactMessage[] $contact_messages
 * @property \App\Model\Entity\PatientMeasurement[] $patient_measurements
 * @property \App\Model\Entity\SymptomLog[] $symptom_logs
 */
class Patient extends Entity
{
    protected array $_virtual = ['full_name'];

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
        'user_id' => true,
        'clinician_id' => true,
        'dob' => true,
        'sex' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'clinician' => true,
        'ai_insights' => true,
        'bookings' => true,
        'contact_messages' => true,
        'patient_measurements' => true,
        'symptom_logs' => true,
    ];

    /**
     * Get Full name of the user
     *
     * @return string
     */
    protected function _getFullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
