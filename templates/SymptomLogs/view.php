<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomLog $symptomLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Symptom Log'), ['action' => 'edit', $symptomLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Symptom Log'), ['action' => 'delete', $symptomLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $symptomLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Symptom Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Symptom Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="symptomLogs view content">
            <h3><?= h($symptomLog->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $symptomLog->hasValue('patient') ? $this->Html->link($symptomLog->patient->id, ['controller' => 'Patients', 'action' => 'view', $symptomLog->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($symptomLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Logged At') ?></th>
                    <td><?= h($symptomLog->logged_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($symptomLog->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($symptomLog->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($symptomLog->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($symptomLog->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Symptom Types') ?></h4>
                <?php if (!empty($symptomLog->symptom_types)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($symptomLog->symptom_types as $symptomType) : ?>
                        <tr>
                            <td><?= h($symptomType->id) ?></td>
                            <td><?= h($symptomType->name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SymptomTypes', 'action' => 'view', $symptomType->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SymptomTypes', 'action' => 'edit', $symptomType->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'SymptomTypes', 'action' => 'delete', $symptomType->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $symptomType->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>