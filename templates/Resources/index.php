<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Resource> $resources
 * @var \App\Model\Entity\User $identity
 */

$this->setLayout($identity->role ?? 'default');
$this->assign('title', 'Manage Resources');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Manage Resources',
        'description' => 'View, add, and manage educational resources and links.',
        'actionLabel' => __('New Resource'),
        'actionUrl' => ['action' => 'add'],
    ]) ?>

    <!-- Sorting Controls -->
    <div class="flex flex-col md:flex-row justify-between space-y-3 items-center mx-4 py-4" id="resources-filter-panel">
        <?= $this->element('table/search') ?>

        <div class="flex justify-end items-center space-x-3 text-sm">
            <span class="text-gray-500 dark:text-gray-400 font-medium">Sort by:</span>
            <?= $this->Paginator->sort('title', 'Title', ['class' => 'text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-semibold transition-colors']) ?>
            <span class="text-gray-300 dark:text-gray-600">|</span>
            <?= $this->Paginator->sort('published_date', 'Date', ['class' => 'text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-semibold transition-colors']) ?>
            <span class="text-gray-300 dark:text-gray-600">|</span>
            <?= $this->Paginator->sort('type', 'Type', ['class' => 'text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 font-semibold transition-colors']) ?>
        </div>
    </div>

    <div class="px-4 pt-6">
        <!-- Resources Grid -->
        <div id="grid-container" class="text-center">
            <?= $this->element('table/entity_tables/resources_grid') ?>
        </div>
    </div>

    <!-- Same pagination element works perfectly below a grid -->
    <?= $this->element('table/pagination_footer') ?>

</div>
