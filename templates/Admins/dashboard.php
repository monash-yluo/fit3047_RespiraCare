<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\ContactMessage> $contactMessages
 */

$this->setLayout('admin');
$this->assign('title', 'Dashboard Overview');
?>

<div class="px-4 pt-6">

    <div class="mb-4">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Admin Dashboard</h1>
    </div>

    <div class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3 mb-4">

        <!--
        <?php for ($i = 0; $i < 3; $i++) : ?>
            <div
                class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm
                sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="w-full">
                    <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">[KPI -- TBC]</h3>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                        [Number -- TBC]
                    </span>
                    <p class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400">
                    <span class="flex items-center mr-1.5 text-sm text-green-500">
                        <svg
                            class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11
                                5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        [% -- TBC]
                    </span>
                        Since last month
                    </p>
                </div>
            </div>
        <?php endfor; ?>
        -->

    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input
                                        id="checkbox-all"
                                        type="checkbox"
                                        class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3
                                        focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800
                                        dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th>

                            <th
                                scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= $this->Paginator->sort('email', 'Sender Email') ?>
                            </th>
                            <th
                                scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= $this->Paginator->sort('name', 'Sender Name') ?>
                            </th>
                            <th
                                scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= $this->Paginator->sort('category', 'Category') ?>
                            </th>
                            <th
                                scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= $this->Paginator->sort('message', 'Message') ?>
                            </th>
                            <th
                                scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= $this->Paginator->sort('created', 'Date Received') ?>
                            </th>
                            <th
                                scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                <?= __('Actions') ?>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        <?php if ($contactMessages->isEmpty()) : ?>
                            <tr>
                                <td
                                    colspan="5"
                                    class="p-8 text-center text-gray-500 dark:text-gray-400
                                    bg-gray-50 dark:bg-gray-800">
                                    <svg
                                        class="w-12 h-12 mx-auto mb-3 text-gray-400 dark:text-gray-500"
                                        fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16
                                            0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414
                                            2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0
                                            .586 13H4"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">No messages yet</p>
                                    <p class="text-sm">When someone submits a contact form, it will appear here.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($contactMessages as $contactMessage) : ?>
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input
                                                id="checkbox-<?= $contactMessage->id ?>"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3
                                                focus:ring-primary-300 dark:focus:ring-primary-600
                                                dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label
                                                for="checkbox-<?= $contactMessage->id ?>"
                                                class="sr-only">checkbox</label>
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base font-medium text-gray-900
                                        dark:text-white max-w-xs truncate">
                                        <?= h($contactMessage->email) ?>
                                    </td>

                                    <td
                                        class="p-4 text-base font-medium text-gray-900
                                        dark:text-white max-w-xs truncate">
                                        <?= h($contactMessage->full_name) ?>
                                    </td>

                                    <td
                                        class="p-4 text-base font-medium text-gray-900
                                        dark:text-white max-w-xs truncate">
                                        <?= h($contactMessage->category) ?>
                                    </td>

                                    <td
                                        class="p-4 text-base font-medium text-gray-900
                                        dark:text-white max-w-xs truncate">
                                        <?= h($contactMessage->message) ?>
                                    </td>

                                    <td
                                        class="p-4 text-base font-medium text-gray-900
                                        whitespace-nowrap dark:text-white">
                                        <?= $this->Time->format($contactMessage->created, 'MMM d, yyyy') ?>
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <?= $this->Html->link(
                                            '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>' . __('View'),
                                            [
                                                'controller' => 'ContactMessages',
                                                'action' => 'view', $contactMessage->id,
                                            ],
                                            [
                                                'escape' => false,
                                                'class' => 'inline-flex items-center px-3 py-2 text-sm font-medium
                                                text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800
                                                focus:ring-4 focus:ring-primary-300 dark:bg-primary-600
                                                dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                                            ],
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>' . __('Delete'),
                                            [
                                                'controller' => 'ContactMessages',
                                                'action' => 'delete', $contactMessage->id,
                                            ],
                                            [
                                                'escape' => false,
                                                'confirm' => __(
                                                    'Are you sure you want to delete # {0}?',
                                                    $contactMessage->id,
                                                ),
                                                'class' => 'inline-flex items-center px-3 py-2 text-sm font-medium
                                                text-center text-white bg-red-700 rounded-lg hover:bg-red-800
                                                focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900',
                                            ],
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
                <?= $this->Paginator->prev('< Previous')?>
                <?= $this->Paginator->next('Next >') ?>
            </ul>
        </div>
    </div>

</div>
