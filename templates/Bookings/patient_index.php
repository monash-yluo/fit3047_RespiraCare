<?php

/**
 * Patient Bookings Index
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 * @var iterable<\App\Model\Entity\Booking> $upcomingBookings
 * @var int $pendingCount
 */

$this->setLayout($identity->role);

$this->assign('title', 'My Bookings');

// Status color mapping
$statusColors = [
    'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
    'declined' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
];
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'My Bookings',
        'description' => 'Manage your consultation bookings with clinicians.',
    ]) ?>

    <div class="grid w-full grid-cols-1 gap-4 mb-6 sm:grid-cols-2 2xl:grid-cols-3">

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Pending Bookings') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    <?= $pendingCount ?? 0 ?>
                </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Awaiting confirmation') ?></p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Upcoming Bookings') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    <?= count($upcomingBookings) ?>
                </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Scheduled consultations') ?></p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400 mb-3"><?= __('Request Booking') ?></h3>
                <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900 w-full">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Request New Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Upcoming Bookings Table -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Upcoming Appointments</h2>

        <?php $this->start('table_content'); ?>
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Clinician
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Date & Time
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Status
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    <?= __('Actions') ?>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

            <?php
            $filteredBookings = array_filter($upcomingBookings->toArray(), function ($booking) {
                return in_array($booking->status, ['pending', 'declined', 'confirmed']);
            });
            ?>

            <?php if (count($filteredBookings) === 0): ?>
                <?= $this->element('table/table_empty_state', [
                    'title' => 'No upcoming appointments',
                    'message' => 'You have no upcoming bookings scheduled.',
                ]) ?>
            <?php else: ?>
                <?php foreach ($filteredBookings as $booking): ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">
                            <?= ($booking->hasValue('clinician') && $booking->clinician && $booking->clinician->hasValue('user') && $booking->clinician->user) ? h($booking->clinician->user->first_name . ' ' . $booking->clinician->user->last_name) : '-' ?>
                        </td>
                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                <?= $this->Time->format($booking->scheduled_date, 'dd MMM, YYYY') ?>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <?= $this->Time->format($booking->scheduled_date, 'HH:mm') ?>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$booking->status] ?? '' ?>">
                                <?= h($booking->status) ?>
                            </span>
                        </td>
                        <td class="p-4 space-x-2 whitespace-nowrap">
                            <?= $this->Html->link(
                                '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                                ['action' => 'view', $booking->id],
                                ['escape' => false, 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                            ) ?>
                            <?= $this->Html->link(
                                '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>',
                                ['action' => 'edit', $booking->id],
                                ['escape' => false, 'title' => __('Edit'), 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800']
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <?php $this->end(); ?>

        <?= $this->element('table/table_wrapper', ['search' => false]) ?>
    </div>

    <!-- All Bookings Table -->
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Booking History</h2>

        <?php $this->start('table_content'); ?>
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Clinician
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Date & Time
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Status
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    Created
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    <?= __('Actions') ?>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

            <?php if ($bookings->isEmpty()): ?>
                <?= $this->element('table/table_empty_state', [
                    'title' => 'No bookings found',
                    'message' => 'You have no booking history.',
                ]) ?>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">
                            <?= ($booking->hasValue('clinician') && $booking->clinician && $booking->clinician->hasValue('user') && $booking->clinician->user) ? h($booking->clinician->user->full_name) : '-' ?>
                        </td>
                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                <?= $this->Time->format($booking->scheduled_date, 'dd MMM, YYYY') ?>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <?= $this->Time->format($booking->scheduled_date, 'HH:mm') ?>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' ?>">
                                <?= h($booking->status) ?>
                            </span>
                        </td>
                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                <?= $this->Time->format($booking->created, 'dd MMM, YYYY') ?>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <?= $this->Time->format($booking->created, 'HH:mm') ?>
                            </div>
                        </td>
                        <td class="p-4 space-x-2 whitespace-nowrap">
                            <?= $this->Html->link(
                                '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                                ['action' => 'view', $booking->id],
                                ['escape' => false, 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                                ['action' => 'delete', $booking->id],
                                ['escape' => false, 'confirm' => __('Delete this booking?'), 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800']
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <?php $this->end(); ?>

        <?= $this->element('table/table_wrapper', ['search' => false]) ?>

        <!-- Pagination -->
        <?= $this->element('table/pagination_footer') ?>
    </div>