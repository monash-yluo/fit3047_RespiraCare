<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Reminder> $reminders
 */
?>
<div class="reminders index content">
    <?= $this->Html->link(__('New Reminder'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reminders') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('clinician_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reminders as $reminder): ?>
                <tr>
                    <td><?= $this->Number->format($reminder->id) ?></td>
                    <td><?= $reminder->hasValue('patient') ? $this->Html->link($reminder->patient->id, ['controller' => 'Patients', 'action' => 'view', $reminder->patient->id]) : '' ?></td>
                    <td><?= $reminder->hasValue('clinician') ? $this->Html->link($reminder->clinician->id, ['controller' => 'Clinicians', 'action' => 'view', $reminder->clinician->id]) : '' ?></td>
                    <td><?= h($reminder->created) ?></td>
                    <td><?= h($reminder->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $reminder->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reminder->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $reminder->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $reminder->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>