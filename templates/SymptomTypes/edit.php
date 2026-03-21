<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomType $symptomType
 * @var string[]|\Cake\Collection\CollectionInterface $symptomLogs
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $symptomType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $symptomType->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Symptom Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="symptomTypes form content">
            <?= $this->Form->create($symptomType) ?>
            <fieldset>
                <legend><?= __('Edit Symptom Type') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('symptom_logs._ids', ['options' => $symptomLogs]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
