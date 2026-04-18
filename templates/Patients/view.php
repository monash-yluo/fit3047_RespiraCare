<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */

$this->setLayout($identity->role);
$this->assign('title', 'Patient Profile');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Patient Profile',
        'description' => 'View patient information, health measurements, and symptom history.',
    ]) ?>

    <!-- Patient Information Card -->
    <div class="grid grid-cols-1 gap-4 mb-6 xl:grid-cols-2 2xl:grid-cols-3">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <?php if ($patient->hasValue('user')) : ?>
                            <?= h($patient->user->first_name . ' ' . $patient->user->last_name) ?>
                        <?php else : ?>
                            <span class="text-gray-400">Unknown Patient</span>
                        <?php endif; ?>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Patient ID: <?= $this->Number->format($patient->id) ?></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Date of Birth</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= $this->Time->format($patient->dob, 'dd MMM, YYYY') ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Gender</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($patient->sex) ?></p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Contact Information</h3>
            <div class="space-y-3">
                <?php if ($patient->hasValue('user')) : ?>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Email</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($patient->user->email) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Phone</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($patient->user->phone) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Care Team</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Assigned Clinician</p>
                    <?php if ($patient->hasValue('clinician')) : ?>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                            <?= $this->Html->link(
                                h($patient->clinician->user->first_name . ' ' . $patient->clinician->user->last_name),
                                ['controller' => 'Clinicians', 'action' => 'view', $patient->clinician->id],
                                ['class' => 'text-primary-600 hover:underline dark:text-primary-500']
                            ) ?>
                        </p>
                    <?php else : ?>
                        <p class="text-sm text-gray-400 italic mt-1">Not assigned</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Notes -->
    <?php if (!empty($patient->notes)) : ?>
    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Clinical Notes</h3>
        <div class="text-sm text-gray-700 dark:text-gray-300">
            <?= $this->Text->autoParagraph(h($patient->notes)); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Health Measurements Section -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Health Measurements</h2>
        
        <?php $this->start('table_content'); ?>
        <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Measurement Time
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Temperature C
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Heart Rate
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Respiratory Rate
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Blood Pressure
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                SPO2
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden xl:table-cell">
                Peak Flow L/min
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= __('Actions') ?>
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

        <?php if (empty($patient->patient_measurements)) : ?>
            <?= $this->element('table/table_empty_state', [
                'title' => 'No measurements found',
                'message' => 'No health measurements have been recorded yet.',
            ]) ?>
        <?php else : ?>
            <?php foreach ($patient->patient_measurements as $measurement) : ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            <?= $this->Time->format($measurement->measured_at, 'dd MMM, YYYY') ?>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                            <?= $this->Time->format($measurement->measured_at, 'HH:mm') ?>
                        </div>
                    </td>

                    <td class="p-4 text-base font-semibold text-gray-900 dark:text-white">
                        <?php if ($measurement->temperature !== null) : ?>
                            <?= h($measurement->temperature) ?>
                            <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">°C</span>
                        <?php else : ?>
                            <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 text-base font-semibold text-gray-900 dark:text-white">
                        <?php if ($measurement->heart_rate !== null) : ?>
                            <?= h($measurement->heart_rate) ?>
                            <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">bpm</span>
                        <?php else : ?>
                            <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 text-base font-semibold text-gray-900 dark:text-white">
                        <?php if ($measurement->respiratory_rate !== null) : ?>
                            <?= h($measurement->respiratory_rate) ?>
                            <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">bpm</span>
                        <?php else : ?>
                            <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 text-base font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                        <?php if ($measurement->blood_pressure_systolic !== null && $measurement->blood_pressure_diastolic !== null) : ?>
                            <?= h($measurement->blood_pressure_systolic) ?>
                            <span class="mx-0.5 text-gray-400 font-normal">/</span>
                            <?= h($measurement->blood_pressure_diastolic) ?>
                            <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">mmHg</span>
                        <?php else : ?>
                            <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 text-base font-semibold text-gray-900 dark:text-white">
                        <?php if ($measurement->spo2 !== null) : ?>
                            <?= h($measurement->spo2) ?>
                            <span class="ml-0.5 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">%</span>
                        <?php else : ?>
                            <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 text-base font-semibold text-gray-900 dark:text-white hidden xl:table-cell">
                        <?php if ($measurement->peak_flow !== null) : ?>
                            <?= h($measurement->peak_flow) ?>
                            <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">L/min</span>
                        <?php else : ?>
                            <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 space-x-2 whitespace-nowrap">
                        <?= $this->Html->link(
                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                            ['controller' => 'PatientMeasurements', 'action' => 'view', $measurement->id],
                            ['escape' => false, 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700'],
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
        <?php $this->end(); ?>

        <?= $this->element('table/table_wrapper') ?>
    </div>

    <!-- Symptom Logs Section -->
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Symptom History</h2>
        
        <?php $this->start('table_content'); ?>
        <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Log Time
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Symptom Categories
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                Severity
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Description
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Actions
            </th>
        </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
        <?php if (empty($patient->symptom_logs)): ?>
            <?= $this->element('table/table_empty_state', [
                'title' => 'No records found',
                'message' => 'No symptoms have been recorded yet.'
            ]) ?>
        <?php else: ?>
            <?php foreach ($patient->symptom_logs as $log): ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            <?= $this->Time->format($log->logged_at, 'dd MMM, YYYY') ?>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                            <?= $this->Time->format($log->logged_at, 'HH:mm') ?>
                        </div>
                    </td>

                    <td class="p-4">
                        <div class="flex flex-wrap gap-1.5">
                            <?php if (!empty($log->symptom_types)): ?>
                                <?php foreach ($log->symptom_types as $type): ?>
                                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        <?= h($type->name) ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-gray-300 text-xs italic">—</span>
                            <?php endif; ?>
                        </div>
                    </td>

                    <td class="p-4 text-center">
                        <?php
                        $getSeverityProps = function($severity) {
                            return match((int)$severity) {
                                1 => ['label' => 'Very Mild', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'],
                                2 => ['label' => 'Mild', 'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'],
                                3 => ['label' => 'Moderate', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'],
                                4 => ['label' => 'Severe', 'class' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'],
                                5 => ['label' => 'Very Severe', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'],
                                default => ['label' => 'Unknown', 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'],
                            };
                        };
                        $props = $getSeverityProps($log->severity);
                        ?>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider <?= $props['class'] ?>">
                            <?= $props['label'] ?>
                        </span>
                    </td>

                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400 max-w-[200px] truncate">
                        <?= !empty($log->description) ? h($log->description) : '<span class="text-gray-300">—</span>' ?>
                    </td>

                    <td class="p-4">
                        <?= $this->Html->link(
                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                            ['controller' => 'SymptomLogs', 'action' => 'view', $log->id],
                            ['escape' => false, 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
        <?php $this->end(); ?>

        <?= $this->element('table/table_wrapper') ?>
    </div>

</div>