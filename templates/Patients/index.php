<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Patient> $patients
 */
?>
<div class="patients index content">
    <?= $this->Html->link(__('New Patient'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Patients') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('clinician_id') ?></th>
                    <th><?= $this->Paginator->sort('dob') ?></th>
                    <th><?= $this->Paginator->sort('sex') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= $this->Number->format($patient->id) ?></td>
                    <td><?= $patient->hasValue('user') ? $this->Html->link($patient->user->first_name, ['controller' => 'Users', 'action' => 'view', $patient->user->id]) : '' ?></td>
                    <td><?= $patient->hasValue('clinician') ? $this->Html->link($patient->clinician->id, ['controller' => 'Clinicians', 'action' => 'view', $patient->clinician->id]) : '' ?></td>
                    <td><?= h($patient->dob) ?></td>
                    <td><?= h($patient->sex) ?></td>
                    <td><?= h($patient->phone) ?></td>
                    <td><?= h($patient->created) ?></td>
                    <td><?= h($patient->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $patient->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $patient->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $patient->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $patient->id),
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