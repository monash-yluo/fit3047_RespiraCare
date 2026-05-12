<?php

/**
 * @var \App\View\AppView $this
 * @var string $verifyCode
 * @var string $userName
 */
?>
<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #305BAB; margin: 0 0 10px 0;">Password Reset Request</h2>
        <p style="color: #666; font-size: 14px; margin: 0;">Secure your account with a new password</p>
    </div>

    <p>Hello <?= h($userName) ?>,</p>

    <p>We received a request to reset your password. Use the verification code below to proceed with resetting your password:</p>

    <div style="background: linear-gradient(135deg, #305BAB 0%, #4a7bc4 100%); padding: 30px; border-radius: 8px; text-align: center; margin: 30px 0; box-shadow: 0 2px 8px rgba(48, 91, 171, 0.15);">
        <p style="color: #fff; font-size: 14px; margin: 0 0 15px 0;">Your Verification Code</p>
        <h1 style="color: #fff; letter-spacing: 6px; margin: 0; font-size: 36px; font-weight: bold;">
            <?= h($verifyCode) ?>
        </h1>
    </div>

    <div style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; border-radius: 4px; margin: 20px 0;">
        <p style="margin: 0; color: #856404;">
            <strong>⏱️ This code will expire in 10 minutes.</strong> Please use it soon.
        </p>
    </div>

    <p style="margin: 20px 0;"><strong>How to reset your password:</strong></p>
    <ol style="color: #666; margin: 10px 0 20px 20px;">
        <li>Go back to the password reset page</li>
        <li>Enter your email address</li>
        <li>Paste the verification code above</li>
        <li>Enter your new password</li>
        <li>Click "Reset Password" to confirm</li>
    </ol>

    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; margin: 20px 0;">
        <p style="margin: 0; color: #666; font-size: 13px;">
            <strong>Didn't request this?</strong> If you did not request a password reset, please ignore this email or contact our support team immediately. Your account remains secure.
        </p>
    </div>

    <p style="margin: 30px 0 10px 0;">Best regards,<br><strong style="color: #305BAB;">RespiraCare Team</strong></p>

    <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">
    <p style="font-size: 12px; color: #999; text-align: center; margin: 0;">
        This is an automated security email. Please do not reply to this message.<br>
        For support, visit our website or contact us through the app.
    </p>
</div>