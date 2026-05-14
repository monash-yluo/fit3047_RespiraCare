<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string $patientName
 * @var string $clinicianName
 * @var string $reason
 */
?>
Booking Request Declined

Hello <?= h($patientName) ?>,

We regret to inform you that your booking request has been declined. Here are the details:

APPOINTMENT DETAILS
===================

Clinician:           <?= h($clinicianName) . "\n" ?>
Requested Date & Time: <?= $booking->scheduled_date->format('M d, Y \a\t h:i A') . "\n" ?>

WHAT CAN YOU DO?
================

- Please try booking another available time slot that suits your schedule
- If you have any questions about the decline, please contact your clinician
- You can view available appointments in your patient dashboard

We apologize for any inconvenience and look forward to scheduling your appointment at a mutually convenient time.

Best regards,
RespiraCare Team

---
This is an automated email. Please do not reply to this message.
