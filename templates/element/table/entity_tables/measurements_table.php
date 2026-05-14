<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PatientMeasurement> $patientMeasurements
 */
?>
<table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 border border-b-0 border-gray-200 dark:border-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('measured_at', 'Date & Time') ?>
            </th>
            <!--                            体温-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('temperature', 'Temperature C') ?>
            </th>
            <!--                            心跳-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('heart_rate', 'Heart Rate') ?>
            </th>
            <!--                            呼吸频率-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('respiratory_rate', 'Respiratory Rate') ?>
            </th>
            <!--                            血压-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('blood_pressure_systolic', 'Blood Pressure') ?>
            </th>
            <!--                            血氧-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('spo2', 'SPO2') ?>
            </th>
            <!--                            呼吸流量-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('peak_flow', 'Peak Flow L/min') ?>
            </th>
            <!--                            备注-->
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= $this->Paginator->sort('note', 'Note') ?>
            </th>
            <th
                scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                <?= __('Actions') ?>
            </th>
        </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
        <?php if ($patientMeasurements->isEmpty()) : ?>
            <?= $this->element('table/table_empty_state', [
                'title' => 'No measurements found',
                'message' => 'There are currently no patient measurements logged.',
            ]) ?>
        <?php else : ?>
            <?php foreach ($patientMeasurements as $measurement): ?>
                <?php
                // Logic to determine if the record was skipped
                $isSkipped = empty($measurement->spo2) &&
                    empty($measurement->heart_rate) &&
                    empty($measurement->blood_pressure_systolic) &&
                    empty($measurement->blood_pressure_diastolic) &&
                    empty($measurement->temperature) &&
                    empty($measurement->respiratory_rate) &&
                    empty($measurement->peak_flow);
                ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <td class="p-4 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap border-r">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            <?= $this->Time->format($measurement->measured_at, 'dd MMM, YYYY') ?>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                            <?= $this->Time->format($measurement->measured_at, 'HH:mm') ?>
                        </div>
                    </td>

                    <?php if ($isSkipped): ?>
                        <td colspan="7" class="p-4 text-center bg-gray-50/50 dark:bg-gray-700/30">
                            <div class="flex items-center justify-center space-x-2">
                                <?php if ($measurement->notes): ?>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 italic">
                                        &mdash; <?= h($measurement->notes) ?> &mdash;
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-gray-500 italic">-- Measurement skipped --</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php else: ?>

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

                        <td class="p-4 text-base font-semibold text-gray-900 dark:text-white">
                            <?php if ($measurement->peak_flow !== null) : ?>
                                <?= h($measurement->peak_flow) ?>
                                <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400 uppercase">L/min</span>
                            <?php else : ?>
                                <span class="text-gray-400 font-normal italic text-sm">N/A</span>
                            <?php endif; ?>
                        </td>

                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400 max-w-[120px] truncate">
                            <?= !empty($measurement->notes) ? h($measurement->notes) : '<span class="text-gray-300">—</span>' ?>
                        </td>
                    <?php endif; ?>

                    <td class="p-4 flex flex-col md:flex-row gap-2 items-center">
                        <?= $this->Html->link(
                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                            ['action' => 'view', $measurement->id],
                            ['escape' => false, 'title' => __('View'), 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800']
                        ) ?>

                        <?= $this->Html->link(
                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>',
                            ['action' => 'edit', $measurement->id],
                            ['escape' => false, 'title' => __('Edit'), 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800']
                        ) ?>

                        <?= $this->Form->postLink(
                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                            ['action' => 'delete', $measurement->id],
                            ['escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete this measurement?'), 'class' => 'temp-disable-button inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->element('table/pagination_footer') ?>