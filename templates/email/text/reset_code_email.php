<?php
/**
 * @var \App\View\AppView $this
 * @var string $verifyCode
 * @var string $userName
 */
?>
PASSWORD RESET REQUEST

Hello <?= h($userName) ?>,

You have requested to reset your password. Please use the verification code below to proceed:

<?= h($verifyCode) ?>

IMPORTANT: This code will expire in 10 minutes.

If you did not request this password reset, please ignore this email.

Best regards,
RespiraCare Team
