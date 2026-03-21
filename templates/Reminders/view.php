<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Reminder'), ['action' => 'edit', $reminder->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Reminder'), ['action' => 'delete', $reminder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reminder->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reminders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Reminder'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reminders view content">
            <h3><?= h($reminder->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $reminder->hasValue('patient') ? $this->Html->link($reminder->patient->id, ['controller' => 'Patients', 'action' => 'view', $reminder->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinician') ?></th>
                    <td><?= $reminder->hasValue('clinician') ? $this->Html->link($reminder->clinician->id, ['controller' => 'Clinicians', 'action' => 'view', $reminder->clinician->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($reminder->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sent At') ?></th>
                    <td><?= h($reminder->sent_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($reminder->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($reminder->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($reminder->message)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>