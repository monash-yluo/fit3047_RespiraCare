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
                    <label class="fw-bold small mb-2 d-block">Email</label>
                    <div class="d-flex gap-2 w-100">
                        <div class="flex-grow-1">
                            <?= $this->Form->control('email', [
                                'class' => 'form-control form-control-lg shadow-sm fs-6 w-100',
                                'label' => false,
                                'required' => true,
                                'autofocus' => true,
                            ]) ?>
                        </div>
                        <button type="button" class="btn text-white fw-bold px-4 rounded-3 shadow-sm" 
                                style="background-color: #305BAB; border: none; font-size: 1rem; white-space: nowrap;"
                                id="sendVerifyBtn"
                                onclick="sendVerifyCode()">
                            Send Code
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('verify_code', [
                        'class' => 'form-control form-control-lg shadow-sm fs-6',
                        'label' => ['text' => 'Verify Code', 'class' => 'fw-bold small mb-2'],
                        'placeholder' => 'Enter the code sent to your email',
                        'required' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('password', [
                        'type' => 'password',
                        'class' => 'form-control form-control-lg shadow-sm fs-6',
                        'label' => ['text' => 'New Password', 'class' => 'fw-bold small mb-2'],
                        'placeholder' => 'Enter your new password',
                        'required' => true,
                    ]) ?>
                </div>

                <div class="mb-4">
                    <?= $this->Form->control('password_confirm', [
                        'type' => 'password',
                        'class' => 'form-control form-control-lg shadow-sm fs-6',
                        'label' => ['text' => 'Confirm Password', 'class' => 'fw-bold small mb-2'],
                        'placeholder' => 'Confirm your new password',
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

<script>
    function sendVerifyCode() {
        const email = document.querySelector('input[name="email"]').value;
        const btn = document.getElementById('sendVerifyBtn');

        if (!email) {
            alert('Please enter your email address first');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = 'Sending...';

        fetch('<?= $this->Url->build(['controller' => 'Users', 'action' => 'sendVerifyCode']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('input[name="_csrfToken"]').value
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Server error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Verification code sent to your email!');
                    btn.innerHTML = 'Code Sent ✓';
                    btn.style.backgroundColor = '#28a745';
                } else {
                    alert(data.message || 'Failed to send verification code');
                    btn.disabled = false;
                    btn.innerHTML = 'Send Code';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`Error: ${error.message}`);
                btn.disabled = false;
                btn.innerHTML = 'Send Code';
            });
    }
</script>