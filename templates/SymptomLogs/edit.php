<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomLog $symptomLog
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 * @var string[]|\Cake\Collection\CollectionInterface $symptomTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $symptomLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $symptomLog->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Symptom Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="symptomLogs form content">
            <?= $this->Form->create($symptomLog) ?>
            <fieldset>
                <legend><?= __('Edit Symptom Log') ?></legend>
                <?php
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('logged_at');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('symptom_types._ids', ['options' => $symptomTypes]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
