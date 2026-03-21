<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContactMessage> $contactMessages
 */
?>
<div class="contactMessages index content">
    <?= $this->Html->link(__('New Contact Message'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Contact Messages') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactMessages as $contactMessage): ?>
                <tr>
                    <td><?= $this->Number->format($contactMessage->id) ?></td>
                    <td><?= $contactMessage->hasValue('patient') ? $this->Html->link($contactMessage->patient->id, ['controller' => 'Patients', 'action' => 'view', $contactMessage->patient->id]) : '' ?></td>
                    <td><?= h($contactMessage->first_name) ?></td>
                    <td><?= h($contactMessage->last_name) ?></td>
                    <td><?= h($contactMessage->email) ?></td>
                    <td><?= h($contactMessage->category) ?></td>
                    <td><?= h($contactMessage->status) ?></td>
                    <td><?= h($contactMessage->created) ?></td>
                    <td><?= h($contactMessage->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contactMessage->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contactMessage->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $contactMessage->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $contactMessage->id),
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