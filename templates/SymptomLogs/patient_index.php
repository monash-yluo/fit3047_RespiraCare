<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $symptomLogs
 */
$this->setLayout('patient');
$this->assign('title', 'Symptom History');

// 严重程度映射 (1-5 分级)
$getSeverityProps = function($severity) {
    return match((int)$severity) {
        1 => [
            'label' => 'Very Mild',
            'class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
        ],
        2 => [
            'label' => 'Mild',
            'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'
        ],
        3 => [
            'label' => 'Moderate',
            'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'
        ],
        4 => [
            'label' => 'Severe',
            'class' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
        ],
        5 => [
            'label' => 'Very Severe',
            'class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
        ],
        default => [
            'label' => 'Unknown',
            'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
        ],
    };
};
?>

<div class="px-4 pt-6">
    <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
        <div class="mb-4 md:mb-0">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Symptom History</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Keep track of your respiratory health and symptoms.</p>
        </div>
        <div>
            <?= $this->Html->link(
                __('Log New Symptom'),
                ['action' => 'patientAdd'],
                ['class' => 'inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700 transition-colors']
            ) ?>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4 w-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= $this->Paginator->sort('logged_at', 'Log Time') ?>
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Symptom Categories
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 text-center">
                                <?= $this->Paginator->sort('severity', 'Severity') ?>
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
                        <?php if ($symptomLogs->isEmpty()): ?>
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">No records found</p>
                                    <p class="text-sm">You haven't recorded any symptoms yet.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($symptomLogs as $log): ?>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-<?= $log->id ?>" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        </div>
                                    </td>

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
                                        <?php $props = $getSeverityProps($log->severity); ?>
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider <?= $props['class'] ?>">
                                            <?= $props['label'] ?>
                                        </span>
                                    </td>

                                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400 max-w-[200px] truncate">
                                        <?= !empty($log->description) ? h($log->description) : '<span class="text-gray-300">—</span>' ?>
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <?= $this->Html->link(
                                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                                            ['action' => 'patient_view', $log->id],
                                            ['escape' => false, 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                                            ['action' => 'delete', $log->id],
                                            ['escape' => false, 'confirm' => __('Delete this record?'), 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800']
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200
        sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">

        <div class="flex items-center mb-4 sm:mb-0">
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <?= $this->Paginator->counter(__('Showing {{start}}-{{end}} of {{count}}')) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <ul class="pagination">
                <?= $this->Paginator->prev('< Previous') ?>
                <?= $this->Paginator->next('Next >') ?>
            </ul>
        </div>
    </div>
</div>
