<?php
/**
 * Patient Portal Dashboard
 * @var \Cake\View\View $this
 * @var \Cake\Datasource\EntityInterface $identity
 * @var iterable<\PatientMeasurement> $patientMeasurements
 */

$this->setLayout($identity->role);
$this->assign('title', 'Dashboard Overview');

?>

<div class="px-4 pt-6">

    <div class="mb-4">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
            Hi <?= h($identity->first_name) ?> <?= h($identity->last_name) ?>!
        </h1>
    </div>

    <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Daily Health Monitoring</h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400">
                    Upload your daily measurements to track your recovery progress.
                </span>
            </div>
            <div class="items-center sm:flex">
                <a href="<?= $this->Url->build(['controller' => 'PatientMeasurements', 'action' => 'add']) ?>"
                   class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Upload Measurements
                </a>
            </div>
        </div>
    </div>

    <?= $this->element('table/table_wrapper', [
        'hasSearch' => false,
        'tableElement' => 'table/entity_tables/patient_dashboard_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>



