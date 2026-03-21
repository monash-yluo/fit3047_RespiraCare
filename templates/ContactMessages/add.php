<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactMessage $contactMessage
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 */
?>
<div class="row">
    <div class="column column-80">
        <div class="contactMessages form content">
            <?= $this->Form->create($contactMessage) ?>
            <fieldset>
                <legend><?= __('Add Contact Message') ?></legend>
                <?php
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('category');
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
