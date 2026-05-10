<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reminder Entity
 *
 * @property int $id
 * @property int $receiver_id
 * @property int|null $sender_id
 * @property string $message
 * @property bool $is_read
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property \App\Model\Entity\User $receiver
 * @property \App\Model\Entity\User $sender
 */
class Reminder extends Entity
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
        'receiver_id' => true,
        'sender_id' => true,
        'message' => true,
        'is_read' => true,
        'created' => true,
        'modified' => true,
        'receiver' => true,
        'sender' => true,
    ];
}
