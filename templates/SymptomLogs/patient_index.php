<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $symptomLogs
 */
$this->setLayout('patient');
$this->assign('title', 'Symptom History');

// 严重程度映射 (根据 SQL 中的 severity int 类型)
// 假设 1-2 是 Mild, 3 是 Moderate, 4-5 是 Severe
$getSeverityProps = function($severity) {
    if ($severity <= 2) {
        return ['label' => 'Mild', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'];
    } elseif ($severity == 3) {
        return ['label' => 'Moderate', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'];
    } else {
        return ['label' => 'Severe', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'];
    }
};
?>

<div class="px-4 pt-6">
    <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
        <div class="mb-4 md:mb-0">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Symptom History</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your respiratory symptoms and their severity over time.</p>
        </div>
        <div>
            <?= $this->Html->link(
                __('Log New Symptom'),
                ['action' => 'add'],
                ['class' => 'inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
            ) ?>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 font-medium"><?= $this->Paginator->sort('logged_at', 'Date & Time') ?></th>
                    <th class="px-6 py-3 font-medium">Symptoms & Severity</th>
                    <th class="px-6 py-3 font-medium">Description</th>
                    <th class="px-6 py-3 font-medium text-center">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if ($symptomLogs->isEmpty()): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">No symptom logs found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($symptomLogs as $log): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    <?= $this->Time->format($log->logged_at, 'dd MMM, YYYY') ?>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    <?= $this->Time->format($log->logged_at, 'HH:mm') ?>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <?php if (!empty($log->symptom_types)): ?>
                                        <?php foreach ($log->symptom_types as $type): ?>
                                            <?php
                                            // 获取中间表里的 severity
                                            $severityValue = $type->_joinData->severity ?? 0;
                                            $props = $getSeverityProps($severityValue);
                                            ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border <?= $props['class'] ?>">
                                                    <?= h($type->name) ?> (<?= $props['label'] ?>)
                                                </span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">Unspecified</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="max-w-xs truncate text-gray-600 dark:text-gray-300" title="<?= h($log->description) ?>">
                                    <?= h($log->description) ?>
                                </div>
                                <?php if($log->notes): ?>
                                    <div class="text-xs text-gray-400 mt-1 italic italic italic italic">Note: <?= h($log->notes) ?></div>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $log->id], ['class' => 'text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-primary-600 dark:hover:bg-primary-700']) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $log->id], ['confirm' => __('Are you sure?'), 'class' => 'text-red-600 hover:text-white hover:bg-red-600 border border-red-600 font-medium rounded-lg text-xs px-3 py-1.5 transition-colors']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="flex flex-col items-center sm:flex-row sm:justify-between">
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s)')) ?>
                </span>
                <div class="inline-flex mt-2 sm:mt-0 space-x-2">
                    <?= $this->Paginator->prev('← Previous', ['class' => 'px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600']) ?>
                    <?= $this->Paginator->next('Next →', ['class' => 'px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
