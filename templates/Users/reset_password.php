<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Reset Password') ?></legend>
                <?php
                echo $this->Form->control('first_name');
                echo $this->Form->control('last_name');
                echo $this->Form->control('email');
                echo $this->Form->control('new_password');
                echo $this->Form->control('confirm_new_password');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

