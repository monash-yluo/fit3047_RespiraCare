<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$this->setLayout('landing');
$this->assign('title', 'Reset Password | RespiraCare');
?>

<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container my-5">
        <div class="row align-items-center gy-5">

            <div class="col-lg-5 pe-lg-5" data-aos="fade-right">

                <h2 class="fw-bold mb-4 login-title">
                    Reset Password
                </h2>

                <?= $this->Flash->render() ?>

                <?= $this->Form->create(null, ['class' => 'needs-validation']) ?>

                <div class="mb-4">
                    <?= $this->Form->control('email', [
                        'class' => 'form-control form-control-lg shadow-sm',
                        'label' => ['text' => 'Email', 'class' => 'fw-bold small mb-2'],
                        'required' => true,
                        'autofocus' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('first_name', [
                        'class' => 'form-control form-control-lg shadow-sm',
                        'label' => ['text' => 'First Name', 'class' => 'fw-bold small mb-2'],
                        'required' => true,
                        'autofocus' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('last_name', [
                        'class' => 'form-control form-control-lg shadow-sm',
                        'label' => ['text' => 'Last Name', 'class' => 'fw-bold small mb-2'],
                        'required' => true,
                        'autofocus' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('new_password', [
                        'class' => 'form-control form-control-lg shadow-sm',
                        'label' => ['text' => 'New Password', 'class' => 'fw-bold small mb-2'],
                        'type' => 'password',
                        'required' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('confirm_new_password', [
                        'class' => 'form-control form-control-lg shadow-sm',
                        'label' => ['text' => 'Confirm New Password', 'class' => 'fw-bold small mb-2'],
                        'type' => 'password',
                        'required' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <div class="cf-turnstile"
                         data-sitekey="<?= h(Configure::read('Turnstile.siteKey')) ?>"
                         data-theme="light"
                         data-size="normal"></div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-2">
                    <?= $this->Form->button(__('Reset Password'), [
                        'class' => 'btn text-white fw-bold px-5 py-2 rounded-3 shadow-sm',
                        'style' => 'background-color: #305BAB; border: none; font-size: 1.1rem;',
                        'onclick' => "this.innerHTML='Resetting...'; setTimeout(() => { this.disabled=true; }, 100);",
                    ]) ?>

                    <?= $this->Html->link(
                        __('Back to Login'),
                        ['controller' => 'Users', 'action' => 'login'],
                        ['class' => 'text-decoration-none fw-semibold small', 'style' => 'color: #6390e3;'],
                    ) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>

            <div class="col-lg-7 d-none d-lg-block text-center rounded-circle bg-white p-4"
                 data-aos="fade-left">
                <?= $this->Html->image('admin-login-vector.png', [
                    'class' => 'img-fluid',
                    'alt' => 'RespiraCare Administrator Dashboard',
                    'style' => 'max-height: 500px; object-fit: contain;',
                ]) ?>
            </div>

        </div>
    </div>
</section>

<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>


