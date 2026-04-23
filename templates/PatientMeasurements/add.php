<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PatientMeasurement $patientMeasurement
 * @var $identity
 */

$breadcrumbs = [
    ['title' => 'Dashboard', 'url' => $identity->role == 'patient' ? ['controller' => 'Patients', 'action' => 'dashboard'] : $this->request->referer()],
    ['title' => 'Add Measurement', 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Add New Measurement');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Record Daily Health Data',
        'description' => 'Please fill in the following health data accurately to help the doctor understand your health status.',
        'showBack' => true,
    ]) ?>

    <?= $this->Form->create($patientMeasurement) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Basic Health Data</h3>
                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="measured_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Measurement Time (24h)</label>
                        <?= $this->Form->control('measured_at', [
                            'type' => 'datetime-local',
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'default' => date('Y-m-d\TH:i'),
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Temperature (°C)</label>
                        <?= $this->Form->control('temperature', [
                            'label' => false,
                            'container' => false,
                            'type' => 'number',
                            'step' => '0.1',
                            'placeholder' => '36.6',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Heart Rate (BPM)</label>
                        <?= $this->Form->control('heart_rate', [
                            'label' => false,
                            'container' => false,
                            'type' => 'number',
                            'placeholder' => '75',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Respiratory Rate (BPM)</label>
                        <?= $this->Form->control('respiratory_rate', [
                            'type' => 'number',
                            'label' => false,
                            'container' => false,
                            'placeholder' => '18',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blood Pressure (mmHg)</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <?= $this->Form->control('blood_pressure_systolic', [
                                    'type' => 'number',
                                    'label' => false,
                                    'container' => false,
                                    'placeholder' => 'Systolic (High)',
                                    'class' => 'w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                                ]) ?>
                            </div>
                            <span class="text-gray-900">/</span>
                            <div class="flex-1 min-w-0">
                                <?= $this->Form->control('blood_pressure_diastolic', [
                                    'type' => 'number',
                                    'label' => false,
                                    'container' => false,
                                    'placeholder' => 'Diastolic (Low)',
                                    'class' => 'w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Oxygen Saturation (SpO2 %)</label>
                        <?= $this->Form->control('spo2', [
                            'type' => 'number',
                            'label' => false,
                            'container' => false,
                            'placeholder' => '98',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peak Flow (L/min)</label>
                        <?= $this->Form->control('peak_flow', [
                            'type' => 'number',
                            'label' => false,
                            'container' => false,
                            'step' => '1',
                            'placeholder' => '400',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Additional Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                        <?= $this->Form->textarea('notes', [
                            'rows' => 5,
                            'placeholder' => 'Add any notes or special instructions...',
                            'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                        ]) ?>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 my-4">

            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="space-y-4">
                    <div class="flex flex-col space-y-4">
                        <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Submit Measurement Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>