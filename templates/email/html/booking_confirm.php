<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string $patientName
 * @var string $clinicianName
 */
?>
<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px;">
    <h2 style="color: #305BAB;">Booking Confirmed</h2>

    <p>Hello <?= h($patientName) ?>,</p>

    <p>Your booking has been confirmed! Here are the details of your appointment:</p>

    <div style="background-color: #f9f9f9; padding: 20px; border-left: 4px solid #305BAB; border-radius: 5px; margin: 20px 0;">
        <p><strong>Appointment Details:</strong></p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; font-weight: bold; width: 40%; color: #305BAB;">Clinician:</td>
                <td style="padding: 10px 0;"><?= h($clinicianName) ?></td>
            </tr>
            <tr style="border-top: 1px solid #e0e0e0;">
                <td style="padding: 10px 0; font-weight: bold; color: #305BAB;">Date & Time:</td>
                <td style="padding: 10px 0;"><?= $booking->scheduled_date->format('M d, Y \a\t h:i A') ?></td>
            </tr>
            <?php if (!empty($booking->notes)): ?>
                <tr style="border-top: 1px solid #e0e0e0;">
                    <td style="padding: 10px 0; font-weight: bold; color: #305BAB; vertical-align: top;">Notes:</td>
                    <td style="padding: 10px 0;"><?= h($booking->notes) ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <p><strong>What's Next?</strong></p>
    <ul style="color: #666;">
        <li>Please arrive 5 minutes early to your appointment</li>
        <li>If you need to reschedule, please contact your clinician as soon as possible</li>
        <li>If you have any questions, feel free to reach out to us</li>
    </ul>

    <p>We look forward to seeing you soon!</p>

    <p>Best regards,<br><strong style="color: #305BAB;">RespiraCare Team</strong></p>

    <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">
    <p style="font-size: 12px; color: #999; text-align: center;">
        This is an automated email. Please do not reply to this message.
    </p>
</div>