<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomLog $symptomLog
 * @var $identity
 */

// Breadcrumb
$breadcrumbs = [
    ['title' => 'Patients', 'url' => $identity->role == 'admin' ? ['controller' => 'Patients', 'action' => 'index'] : ['controller' => 'Patients', 'action' => 'clinician-index']],
    ['title' => 'Symptom Logs', 'url' => $identity->role == 'patient' ? null : ['controller' => 'Patients', 'action' => 'view', $symptomLog->patient->id]],
    ['title' => '#' . $symptomLog->id, 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Symptom Details');

// 严重程度映射 (1-5 分级)
$getSeverityProps = function ($severity) {
    return match ((int)$severity) {
        1 => [
            'label' => 'Very Mild',
            'class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'bgLight' => 'border-green-200 bg-green-50 dark:bg-green-900/20'
        ],
        2 => [
            'label' => 'Mild',
            'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            'bgLight' => 'border-emerald-200 bg-emerald-50 dark:bg-emerald-900/20'
        ],
        3 => [
            'label' => 'Moderate',
            'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'bgLight' => 'border-yellow-200 bg-yellow-50 dark:bg-yellow-900/20'
        ],
        4 => [
            'label' => 'Severe',
            'class' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
            'bgLight' => 'border-orange-200 bg-orange-50 dark:bg-orange-900/20'
        ],
        5 => [
            'label' => 'Very Severe',
            'class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            'bgLight' => 'border-red-200 bg-red-50 dark:bg-red-900/20'
        ],
        default => [
            'label' => 'Unknown',
            'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            'bgLight' => 'border-gray-200 bg-gray-50 dark:bg-gray-800/20'
        ],
    };
};
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Symptom Details',
        'description' => 'Recorded on ' . $this->Time->format($symptomLog->logged_at, 'MMMM d, YYYY') . ' at ' . $this->Time->format($symptomLog->logged_at, 'HH:mm'),
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
                            <?= !empty($symptomLog->patient->user->first_name) ? h($symptomLog->patient->user->first_name) . ' ' . h($symptomLog->patient->user->last_name) : 'N/A' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Patient ID</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white font-mono">
                            #<?= h($symptomLog->patient->id) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Assigned Clinician</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            <?= !empty($symptomLog->patient->clinician->user->first_name) ? h($symptomLog->patient->clinician->user->first_name) . ' ' . h($symptomLog->patient->clinician->user->last_name) : 'N/A' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- 症状类别卡片 -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Symptom Categories</h3>

                <?php if (!empty($symptomLog->symptom_types)): ?>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($symptomLog->symptom_types as $type): ?>
                            <span class="px-4 py-2 rounded-lg text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <?= h($type->name) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-400 dark:text-gray-500 italic">No symptom categories recorded</p>
                <?php endif; ?>
            </div>

            <!-- 严重程度和描述卡片 -->
            <?php $props = $getSeverityProps($symptomLog->severity); ?>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Severity Assessment</h3>

                <div class="grid grid-cols-1 gap-6">
                    <!-- 严重程度显示 -->
                    <div class="p-4 rounded-xl border <?= $props['bgLight'] ?>">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Severity Level</p>
                        <div class="flex items-center gap-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider <?= $props['class'] ?>">
                                        <?= $props['label'] ?>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Level <?= h($symptomLog->severity) ?> of 5</p>
                            </div>
                            <!-- 严重程度进度条 -->
                            <div class="w-24">
                                <div class="flex gap-0.5">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <div class="h-2 flex-1 rounded-full <?= $i <= $symptomLog->severity ? match ($symptomLog->severity) {
                                                                                1, 2 => 'bg-green-400 dark:bg-green-500',
                                                                                3 => 'bg-yellow-400 dark:bg-yellow-500',
                                                                                4 => 'bg-orange-400 dark:bg-orange-500',
                                                                                5 => 'bg-red-500 dark:bg-red-600',
                                                                                default => 'bg-gray-300'
                                                                            } : 'bg-gray-200 dark:bg-gray-700' ?>"></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 描述文本 -->
                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Description</p>
                        <p class="text-base text-gray-900 dark:text-white leading-relaxed">
                            <?php if (!empty($symptomLog->description)): ?>
                                <?= nl2br(h($symptomLog->description)) ?>
                            <?php else: ?>
                                <span class="text-gray-400 italic">No description provided</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 右侧信息栏 -->
        <div class="xl:col-span-1 space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 h-full flex flex-col">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Notes</h3>
                <div class="prose dark:prose-invert italic text-gray-600 dark:text-gray-300 flex-grow">
                    <?php if (!empty($symptomLog->notes)): ?>
                        <?= nl2br(h($symptomLog->notes)) ?>
                    <?php else: ?>
                        <p class="text-gray-400">No additional notes recorded for this record.</p>
                    <?php endif; ?>
                </div>

                <hr class="my-6 border-gray-100 dark:border-gray-700">

                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Record ID</span>
                        <span class="font-mono text-gray-900 dark:text-white">#<?= h($symptomLog->id) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Created At</span>
                        <span class="text-gray-900 dark:text-white"><?= $this->Time->format($symptomLog->created, 'yyyy-MM-dd HH:mm') ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Last Modified</span>
                        <span class="text-gray-900 dark:text-white"><?= $this->Time->format($symptomLog->modified, 'yyyy-MM-dd HH:mm') ?></span>
                    </div>
                </div>

                <?php if ($identity->role === 'admin' || $identity->role === 'clinician'): ?>
                    <hr class="my-6 border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col space-y-3">
                        <?= $this->element('button/blue_button', ['label' => 'Edit', 'url' => ['action' => 'edit', $symptomLog->id], 'iconType' => 'edit']) ?>
                        <?= $this->element('button/red_button', ['label' => 'Delete', 'url' => ['action' => 'delete', $symptomLog->id], 'confirm' => __('Are you sure you want to delete this symptom log?'), 'iconType' => 'delete']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
