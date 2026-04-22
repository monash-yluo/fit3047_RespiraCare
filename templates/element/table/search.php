<?php

$currentQuery = $this->request->getQueryParams();
unset($currentQuery['search']);

?>

<div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900 border border-b-0 border-gray-200 dark:border-gray-700">
    <div class="w-full md:w-1/3">
        <?= $this->Form->create(null, [
            'type' => 'get',
            'class' => 'flex items-center',
            'valueSources' => ['query'],
            'id' => 'search-form',
        ]) ?>
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>

            <?= $this->Form->control('search', [
                'type' => 'text',
                'id' => 'simple-search',
                'label' => false,
                'autocomplete' => 'off',
                'value' => $this->request->getQuery('search'),
                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 pr-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                'placeholder' => 'Search by patient name or phone...'
            ]) ?>

            <?php if ($this->request->getQuery('search')): ?>
                <?= $this->Html->link(
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    ['?' => $currentQuery],
                    [
                        'escape' => false,
                        'title' => __('Clear search'),
                        'class' => 'absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors'
                    ]
                ) ?>
            <?php endif; ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
