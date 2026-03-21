<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomType $symptomType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Symptom Type'), ['action' => 'edit', $symptomType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Symptom Type'), ['action' => 'delete', $symptomType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $symptomType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Symptom Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Symptom Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="symptomTypes view content">
            <h3><?= h($symptomType->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($symptomType->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($symptomType->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Symptom Logs') ?></h4>
                <?php if (!empty($symptomType->symptom_logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Logged At') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($symptomType->symptom_logs as $symptomLog) : ?>
                        <tr>
                            <td><?= h($symptomLog->id) ?></td>
                            <td><?= h($symptomLog->patient_id) ?></td>
                            <td><?= h($symptomLog->description) ?></td>
                            <td><?= h($symptomLog->logged_at) ?></td>
                            <td><?= h($symptomLog->notes) ?></td>
                            <td><?= h($symptomLog->created) ?></td>
                            <td><?= h($symptomLog->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SymptomLogs', 'action' => 'view', $symptomLog->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SymptomLogs', 'action' => 'edit', $symptomLog->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'SymptomLogs', 'action' => 'delete', $symptomLog->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $symptomLog->id),
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