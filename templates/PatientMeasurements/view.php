<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PatientMeasurement $patientMeasurement
 * @var $identity
 */

$breadcrumbs = [
    ['title' => 'Dashboard', 'url' => $identity->role == 'admin' ? ['controller' => 'Admins', 'action' => 'dashboard'] : ['controller' => 'Clinicians', 'action' => 'dashboard']],
    ['title' => '#' . $patientMeasurement->id, 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Measurement Details');

// 定义正常值范围（医学参考值）
$ranges = [
    'temperature' => ['min' => 36.1, 'max' => 37.2],
    'heart_rate' => ['min' => 60, 'max' => 100],
    'spo2' => ['min' => 95, 'max' => 100],
    'respiratory_rate' => ['min' => 12, 'max' => 20],
    'peak_flow' => ['min' => 400, 'max' => 600], // 示例参考值
];

// 辅助函数：判断是否在正常范围内
$isNormal = function ($value, $rangeKey) use ($ranges) {
    if ($value === null || !isset($ranges[$rangeKey])) return true;
    return $value >= $ranges[$rangeKey]['min'] && $value <= $ranges[$rangeKey]['max'];
};
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Measurement Details',
        'description' => 'Recorded on ' . $this->Time->format($patientMeasurement->measured_at, 'MMMM d, YYYY') . ' at ' . $this->Time->format($patientMeasurement->measured_at, 'HH:mm'),
        'showBack' => true
    ]) ?>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 space-y-6">
            <!-- Patient Information Card -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Patient Information</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Patient Name</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            <?= !empty($patientMeasurement->patient->user->first_name) ? h($patientMeasurement->patient->user->first_name) . ' ' . h($patientMeasurement->patient->user->last_name) : 'N/A' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Patient ID</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white font-mono">
                            #<?= h($patientMeasurement->patient->id) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Assigned Clinician</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            <?= !empty($patientMeasurement->patient->clinician->user->first_name) ? h($patientMeasurement->patient->clinician->user->first_name) . ' ' . h($patientMeasurement->patient->clinician->user->last_name) : 'N/A' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Vitals & Biometrics</h3>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <?php $normal = $isNormal($patientMeasurement->temperature, 'temperature'); ?>
                    <div class="p-4 rounded-xl border <?= $normal ? 'border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30' : 'border-red-200 bg-red-50 dark:bg-red-900/20' ?>">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Temperature</p>
                        <div class="flex items-baseline justify-between">
                            <span class="text-3xl font-bold <?= $normal ? 'text-gray-900 dark:text-white' : 'text-red-600' ?>">
                                <?= $patientMeasurement->temperature !== null ? h($patientMeasurement->temperature) : 'N/A' ?><span class="ml-1 text-sm font-normal text-gray-500">°C</span>
                            </span>
                            <span class="text-xs text-gray-400">Ref: 36.1 - 37.2</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Heart Rate</p>
                        <div class="flex items-baseline justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                <?= $patientMeasurement->heart_rate !== null ? h($patientMeasurement->heart_rate) : 'N/A' ?><span class="ml-1 text-sm font-normal text-gray-500">bpm</span>
                            </span>
                            <span class="text-xs text-gray-400">Ref: 60 - 100</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Respiratory Rate</p>
                        <div class="flex items-baseline justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                <?= $patientMeasurement->respiratory_rate !== null ? h($patientMeasurement->respiratory_rate) : 'N/A' ?><span class="ml-1 text-sm font-normal text-gray-500">bpm</span>
                            </span>
                            <span class="text-xs text-gray-400">Ref: 12 - 20</span>
                        </div>
                    </div>

                    <div class="md:col-span-2 p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Blood Pressure</p>
                        <div class="flex items-baseline space-x-2">
                            <?php if ($patientMeasurement->blood_pressure_systolic !== null): ?>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white"><?= h($patientMeasurement->blood_pressure_systolic) ?></span>
                                <span class="text-2xl text-gray-300">/</span>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white"><?= h($patientMeasurement->blood_pressure_diastolic) ?></span>
                                <span class="text-sm font-normal text-gray-500 uppercase">mmHg</span>
                            <?php else: ?>
                                <span class="text-3xl font-bold text-gray-400 italic">N/A</span>
                            <?php endif; ?>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Ref: Normal ~ 120/80</p>
                    </div>

                    <?php $normal = $isNormal($patientMeasurement->spo2, 'spo2'); ?>
                    <div class="p-4 rounded-xl border <?= $normal ? 'border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30' : 'border-orange-200 bg-orange-50 dark:bg-orange-900/20' ?>">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Oxygen Saturation (SpO2)</p>
                        <div class="flex items-baseline justify-between">
                            <span class="text-3xl font-bold <?= $normal ? 'text-gray-900 dark:text-white' : 'text-orange-600' ?>">
                                <?= $patientMeasurement->spo2 !== null ? h($patientMeasurement->spo2) : 'N/A' ?><span class="ml-1 text-sm font-normal text-gray-500">%</span>
                            </span>
                            <span class="text-xs text-gray-400">Ref: > 95%</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Peak Flow</p>
                        <div class="flex items-baseline justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                <?= $patientMeasurement->peak_flow !== null ? h($patientMeasurement->peak_flow) : 'N/A' ?><span class="ml-1 text-sm font-normal text-gray-500">L/min</span>
                            </span>
                            <span class="text-xs text-gray-400">Ref: 400 - 600</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="xl:col-span-1 space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 h-full flex flex-col">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Patient Notes</h3>
                <div class="prose dark:prose-invert italic text-gray-600 dark:text-gray-300 flex-grow">
                    <?php if (!empty($patientMeasurement->notes)): ?>
                        <?= nl2br(h($patientMeasurement->notes)) ?>
                    <?php else: ?>
                        <p class="text-gray-400">No additional notes recorded for this measurement.</p>
                    <?php endif; ?>
                </div>

                <hr class="my-6 border-gray-100 dark:border-gray-700">

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Record ID</span>
                        <span class="font-mono text-gray-900 dark:text-white">#<?= h($patientMeasurement->id) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Created At</span>
                        <span class="text-gray-900 dark:text-white"><?= $this->Time->format($patientMeasurement->created, 'yyyy-MM-dd HH:mm') ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Last Modified</span>
                        <span class="text-gray-900 dark:text-white"><?= $this->Time->format($patientMeasurement->modified, 'yyyy-MM-dd HH:mm') ?></span>
                    </div>
                </div>

                <?php if ($identity->role === 'admin'): ?>
                    <hr class="my-6 border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col space-y-3">
                        <?= $this->element('button/blue_button', ['label' => 'Edit', 'url' => ['action' => 'edit', $patientMeasurement->id], 'iconType' => 'edit']) ?>
                        <?= $this->element('button/red_button', ['label' => 'Delete', 'url' => ['action' => 'delete', $patientMeasurement->id], 'confirm' => __('Are you sure you want to delete this measurement?'), 'iconType' => 'delete']) ?>
                    </div>
                <?php endif; ?>
