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

        <?php if($identity->role === 'patient'): ?>
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
        <?php endif; ?>
    </div>

    <!-- Upcoming Bookings Table -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Upcoming Appointments</h2>
        <?= $this->element('table/table_wrapper', [
            'hasSearch' => false,
            'tableElement' => 'table/entity_tables/bookings_clinician_table',
            'filterConfig' => [
                'paramName' => 'status',
                'target' => 'upcomingBookings',
                'options' => [
                    '' => 'All',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                ],
            ],
        ]) ?>
    </div>

    <div class="h-px my-10 bg-gray-200 border-0 dark:bg-gray-700"></div>

    <!-- All Bookings Table -->
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Booking History</h2>

        <?= $this->element('table/table_wrapper', [
            'target' => 'allBookings',
            'hasSearch' => false,
            'hasDateFilter' => true,
            'tableElement' => 'table/entity_tables/bookings_all_table',
            'filterConfig' => [
                'paramName' => 'status',
                'target' => 'allBookings',
                'options' => [
                    '' => 'All',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'declined' => 'Declined',
                ],
            ],
        ]) ?>
    </div>

</div>
