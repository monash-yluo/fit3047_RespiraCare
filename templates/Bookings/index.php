<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */

$this->setLayout($identity->role);
$this->assign('title', 'Manage Bookings');

?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Manage Bookings',
        'description' => 'View and manage all system bookings.',
        'actionLabel' => __('New Booking'),
        'actionUrl' => ['action' => 'add'],
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'hasDateFilter' => true,
        'tableElement' => 'table/entity_tables/bookings_table',
        'filterConfig' => [
            'paramName' => 'status',
            'options' => [
                '' => 'All',
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'declined' => 'declined',
            ],
        ],
    ]) ?>
</div>
