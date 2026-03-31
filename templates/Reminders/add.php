<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 * @var \Cake\Collection\CollectionInterface|string[] $receivers
 * @var \Cake\Collection\CollectionInterface|string[] $senders
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Reminders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reminders form content">
            <?= $this->Form->create($reminder) ?>
            <fieldset>
                <legend><?= __('Add Reminder') ?></legend>
                <?php
                    echo $this->Form->control('receiver_id', ['options' => $receivers]);
                    echo $this->Form->control('sender_id', ['options' => $senders, 'empty' => true]);
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
