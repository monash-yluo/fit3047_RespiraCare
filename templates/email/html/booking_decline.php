<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string $patientName
 * @var string $clinicianName
 * @var string $reason
 */
?>
<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px;">
    <h2 style="color: #d9534f;">Booking Request Declined</h2>

    <p>Hello <?= h($patientName) ?>,</p>

    <p>We regret to inform you that your booking request has been declined. Here are the details:</p>

    <div style="background-color: #f9f9f9; padding: 20px; border-left: 4px solid #d9534f; border-radius: 5px; margin: 20px 0;">
        <p><strong>Appointment Details:</strong></p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; font-weight: bold; width: 40%; color: #d9534f;">Clinician:</td>
                <td style="padding: 10px 0;"><?= h($clinicianName) ?></td>
            </tr>
            <tr style="border-top: 1px solid #e0e0e0;">
                <td style="padding: 10px 0; font-weight: bold; color: #d9534f;">Requested Date & Time:</td>
                <td style="padding: 10px 0;"><?= $booking->scheduled_date->format('M d, Y \a\t h:i A') ?></td>
            </tr>
        </table>
    </div>

    <p><strong>What Can You Do?</strong></p>
    <ul style="color: #666;">
        <li>Please try booking another available time slot that suits your schedule</li>
        <li>If you have any questions about the decline, please contact your clinician</li>
        <li>You can view available appointments in your patient dashboard</li>
    </ul>

    <p>We apologize for any inconvenience and look forward to scheduling your appointment at a mutually convenient time.</p>

    <p>Best regards,<br><strong style="color: #305BAB;">RespiraCare Team</strong></p>

    <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">
    <p style="font-size: 12px; color: #999; text-align: center;">
        This is an automated email. Please do not reply to this message.
    </p>
</div>
