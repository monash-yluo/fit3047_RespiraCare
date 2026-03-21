<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
<div class="users form content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <legend><?= __('test Email: admin@respiracare.com') ?></legend>
        <legend><?= __('test Password: 123') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <div class="cf-turnstile" data-sitekey="<?= Configure::read('Turnstile.siteKey') ?>" data-theme="light" data-size="normal"></div>
    <?= $this->Form->button(__('Login')) ?>
    <?= $this->Form->end() ?>
<!--    添加一个forget password 链接-->
    <?= $this->Html->link(__('Forget Password?'), ['controller' => 'Users', 'action' => 'resetPassword']) ?>
</div>
<script
    src="https://challenges.cloudflare.com/turnstile/v0/api.js"
    async
    defer
></script>
