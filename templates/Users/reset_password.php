<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

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
                echo $this->Form->control('new_password', ['type' => 'password']);
                echo $this->Form->control('confirm_new_password', ['type' => 'password']);
                ?>
            </fieldset>
            <div class="cf-turnstile" data-sitekey="<?= Configure::read('Turnstile.siteKey') ?>" data-theme="light" data-size="normal"></div>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script
    src="https://challenges.cloudflare.com/turnstile/v0/api.js"
    async
    defer
></script>

