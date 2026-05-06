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

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/clinician_dashboard_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
