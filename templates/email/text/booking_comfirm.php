<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string $patientName
 * @var string $clinicianName
 */
?>
Booking Confirmed

Hello <?= h($patientName) ?>,

Your booking has been confirmed! Here are the details of your appointment:

APPOINTMENT DETAILS
===================

Clinician:     <?= h($clinicianName) . "\n" ?>
Date & Time:   <?= $booking->scheduled_date->format('M d, Y \a\t h:i A') . "\n" ?>
<?php if (!empty($booking->notes)): ?>
Notes:         <?= h($booking->notes) . "\n" ?>
<?php endif; ?>

WHAT'S NEXT?
============

- Please arrive 5 minutes early to your appointment
- If you need to reschedule, please contact your clinician as soon as possible
- If you have any questions, feel free to reach out to us

We look forward to seeing you soon!

Best regards,
RespiraCare Team

---
This is an automated email. Please do not reply to this message.
