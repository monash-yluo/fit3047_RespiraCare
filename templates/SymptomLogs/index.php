<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SymptomLog> $symptomLogs
 */
?>
<div class="symptomLogs index content">
    <?= $this->Html->link(__('New Symptom Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Symptom Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('logged_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($symptomLogs as $symptomLog): ?>
                <tr>
                    <td><?= $this->Number->format($symptomLog->id) ?></td>
                    <td><?= $symptomLog->hasValue('patient') ? $this->Html->link($symptomLog->patient->id, ['controller' => 'Patients', 'action' => 'view', $symptomLog->patient->id]) : '' ?></td>
                    <td><?= h($symptomLog->logged_at) ?></td>
                    <td><?= h($symptomLog->created) ?></td>
                    <td><?= h($symptomLog->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $symptomLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $symptomLog->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $symptomLog->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $symptomLog->id),
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