<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SymptomType> $symptomTypes
 */
?>
<div class="symptomTypes index content">
    <?= $this->Html->link(__('New Symptom Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Symptom Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($symptomTypes as $symptomType): ?>
                <tr>
                    <td><?= $this->Number->format($symptomType->id) ?></td>
                    <td><?= h($symptomType->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $symptomType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $symptomType->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $symptomType->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $symptomType->id),
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