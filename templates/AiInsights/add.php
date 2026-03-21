<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AiInsight $aiInsight
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Ai Insights'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="aiInsights form content">
            <?= $this->Form->create($aiInsight) ?>
            <fieldset>
                <legend><?= __('Add Ai Insight') ?></legend>
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
