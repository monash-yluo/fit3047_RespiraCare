<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AiInsight $aiInsight
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ai Insight'), ['action' => 'edit', $aiInsight->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ai Insight'), ['action' => 'delete', $aiInsight->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aiInsight->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Ai Insights'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ai Insight'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="aiInsights view content">
            <h3><?= h($aiInsight->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $aiInsight->hasValue('patient') ? $this->Html->link($aiInsight->patient->id, ['controller' => 'Patients', 'action' => 'view', $aiInsight->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($aiInsight->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk Level') ?></th>
                    <td><?= $this->Number->format($aiInsight->risk_level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($aiInsight->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($aiInsight->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($aiInsight->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>