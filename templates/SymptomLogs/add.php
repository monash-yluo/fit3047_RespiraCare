<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomLog $symptomLog
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $symptomTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Symptom Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="symptomLogs form content">
            <?= $this->Form->create($symptomLog) ?>
            <fieldset>
                <legend><?= __('Add Symptom Log') ?></legend>
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
