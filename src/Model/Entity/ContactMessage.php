<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContactMessage Entity
 *
 * @property int $id
 * @property int|null $patient_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $category
 * @property string|null $status
 * @property string $message
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Patient $patient
 */
class ContactMessage extends Entity
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
        'patient_id' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'category' => true,
        'status' => true,
        'message' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'patient' => true,
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
