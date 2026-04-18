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
    <div class="grid w-full grid-cols-1 gap-4 mb-6 xl:grid-cols-2 2xl:grid-cols-3">
        <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Patients</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    <?= $patientCount ?? 0 ?>
                </span>
                <p class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400 mt-2">
                    <span class="text-sm text-gray-400">Patients assigned to you</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <?php $this->start('table_content'); ?>
    <thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th scope="col" class="p-4 w-4">
            <div class="flex items-center">
                <input id="checkbox-all" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox-all" class="sr-only">checkbox</label>
            </div>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('id', 'ID') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('user_id', 'Patient Name') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden lg:table-cell">
            <?= $this->Paginator->sort('dob', 'DOB') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden lg:table-cell">
            <?= $this->Paginator->sort('sex', 'Sex') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('phone', 'Phone') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= __('Actions') ?>
        </th>
    </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    <?php if (isset($patients) && $patients->items()->isEmpty()) : ?>
        <?= $this->element('table/table_empty_state', [
            'colspan' => 7,
            'title' => 'No patients found',
            'message' => 'You do not have any patients assigned yet.',
        ]) ?>
    <?php elseif (isset($patients)) : ?>
        <?php foreach ($patients as $patient) : ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-<?= $patient->id ?>" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-<?= $patient->id ?>" class="sr-only">checkbox</label>
                    </div>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?= $this->Number->format($patient->id) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                    <?php if ($patient->hasValue('user')) : ?>
                        <?= $this->Html->link(
                            h($patient->user->first_name . ' ' . $patient->user->last_name),
                            ['controller' => 'Patients', 'action' => 'view', $patient->id],
                            ['class' => 'text-primary-600 hover:underline dark:text-primary-500'],
                        ) ?>
                    <?php else : ?>
                        <span class="text-gray-400 italic">No User</span>
                    <?php endif; ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white hidden lg:table-cell">
                    <div class="text-sm text-gray-900 dark:text-white">
                        <?= $this->Time->format($patient->dob, 'dd MMM, YYYY') ?>
                    </div>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white hidden lg:table-cell">
                    <?= h($patient->sex) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[120px]">
                    <?= h($patient->phone) ?>
                </td>

                <td class="p-4 space-x-2 whitespace-nowrap">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['controller' => 'Patients', 'action' => 'view', $patient->id],
                        [
                            'escape' => false,
                            'title' => __('View'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                        ],
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
    <?php $this->end(); ?>

    <?= $this->element('table/table_wrapper') ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
