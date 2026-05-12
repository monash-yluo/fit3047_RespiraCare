<?php

/**
 * Patient Portal Dashboard
 * @var \Cake\View\View $this
 * @var \Cake\Datasource\EntityInterface $identity
 * @var iterable<Patient> $patients
 * @var int $patientCount
 */

$this->setLayout($identity->role);
$this->assign('title', 'Dashboard Overview');

?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Hi, ' . h($identity->first_name) . ' ' . h($identity->last_name) . '!',
        'description' => 'View your assigned patients and patient health data.',
    ]) ?>

    <!-- KPI Cards -->
    <div class="grid w-full grid-cols-1 gap-4 mb-6 sm:grid-cols-2 2xl:grid-cols-3">

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Patients</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    <?= $patientCount ?? 0 ?>
                </span>
                <p class="mt-2 text-sm text-gray-400">Patients assigned to you</p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Notifications</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    <?= $reminderCount ?? 0 ?>
                </span>
                <p class="mt-2 text-sm text-gray-400">Total reminders received</p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Urgent Attention</h3>
                <span class="text-2xl font-bold leading-none text-red-600 sm:text-3xl dark:text-red-500">
                    <?= $urgentPatientCount ?? 0 ?>
                </span>
                <p class="mt-2 text-sm text-gray-400">Patients with high-risk readings</p>
            </div>
        </div>

    </div>

    <!-- Today's Schedule Widget -->
    <div class="p-4 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Today's Appointments</h3>
            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'patientClinicianIndex']) ?>" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
                View full calendar
            </a>
        </div>

        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">

                <?php if ($todaysBookings->isEmpty()): ?>
                    <li class="py-6 text-center text-gray-500 dark:text-gray-400">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p>No appointments scheduled for today.</p>
                    </li>
                <?php else: ?>

                    <?php foreach ($todaysBookings as $booking): ?>
                        <li class="py-3 sm:py-">
                            <div class="flex items-center space-x-4">
                                <!-- Time Badge -->
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full dark:bg-blue-900">
                                        <span class="font-medium text-blue-600 dark:text-blue-300">
                                            <?= h($booking->scheduled_date->format('H:i')) ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Patient Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        <?= h($booking->patient->user->first_name . ' ' . $booking->patient->user->last_name) ?>
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400 capitalize">
                                        <?= h($booking->status) ?> • <?= h($booking->duration ?? 30) ?> min
                                    </p>
                                </div>

                                <!-- Action Button -->
                                <div class="inline-flex items-center">
                                    <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'view', $booking->id]) ?>" class="px-3 py-1.5 text-xs font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>

                <?php endif; ?>

            </ul>
        </div>
    </div>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/clinician_dashboard_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
