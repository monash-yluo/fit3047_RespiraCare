<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 * @var string[]|\Cake\Collection\CollectionInterface $clinicians
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reminder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reminder->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Reminders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reminders form content">
            <?= $this->Form->create($reminder) ?>
            <fieldset>
                <legend><?= __('Edit Reminder') ?></legend>
                <?php
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('clinician_id', ['options' => $clinicians, 'empty' => true]);
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
