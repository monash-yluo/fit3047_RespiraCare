<?php

/**
 * @var \App\View\AppView $this
 * @var string $verifyCode
 * @var string $userName
 */
?>
<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px;">
    <h2>Password Reset Request</h2>

    <p>Hello <?= h($userName) ?>,</p>

    <p>You have requested to reset your password. Please use the verification code below to proceed:</p>

    <div style="background-color: #f0f0f0; padding: 20px; border-radius: 5px; text-align: center;">
        <h3 style="color: #305BAB; letter-spacing: 5px;">
            <?= h($verifyCode) ?>
        </h3>
    </div>

    <p><strong>This code will expire in 10 minutes.</strong></p>

    <p>If you did not request this password reset, please ignore this email.</p>

    <p>Best regards,<br>RespiraCare Team</p>
</div>