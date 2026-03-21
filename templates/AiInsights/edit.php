<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AiInsight $aiInsight
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $aiInsight->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $aiInsight->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Ai Insights'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="aiInsights form content">
            <?= $this->Form->create($aiInsight) ?>
            <fieldset>
                <legend><?= __('Edit Ai Insight') ?></legend>
                <?php
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('risk_level');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
