<?php
/**
 * Pagination Footer Element
 * * Reusable sticky footer for paginated tables.
 * @var \App\View\AppView $this
 */
?>
<div
    class="rounded-b-lg sticky bottom-0 right-0 items-center w-full p-4 bg-white border border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center mb-4 sm:mb-0">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            <?= $this->Paginator->counter(__('Showing {{start}}-{{end}} of {{count}}')) ?>
        </span>
    </div>
    <div class="flex items-center space-x-3">
        <ul class="pagination flex space-x-2">
            <?= $this->Paginator->prev('< Previous') ?>
            <?= $this->Paginator->next('Next >') ?>
        </ul>
    </div>
</div>
