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
        'title' => $identity->role === 'admin' ? 'Manage Resources' : 'Resources',
        'description' => $identity->role === 'admin' ? 'View, add, and manage educational resources.' : 'View available educational resources.',
        'actionLabel' => __('New Resource'),
        'actionUrl' => $identity->role === 'admin' ? ['action' => 'add'] : null,
    ]) ?>

    <div class="flex flex-row gap-3 mb-1 items-center">
        <!-- Filter by Type -->
        <div class="w-48">
            <?= $this->element('table/filter_dropdown', [
                'paramName' => 'type',
                'options' => [
                    '' => 'All Types',
                    'Article' => 'Articles',
                    'Video' => 'Videos',
                    'PDF' => 'PDFs',
                    'External Link' => 'Links',
                    'Guide' => 'Guides'
                ]
            ]) ?>
        </div>

        <?php if ($identity->role === 'admin') : ?>
            <div class="w-48">
                <?= $this->element('table/filter_dropdown', [
                    'paramName' => 'status',
                    'options' => [
                        '' => 'All Status',
                        'active' => 'Active',
                        'draft' => 'Draft',
                        'archived' => 'Archived',
                    ]
                ]) ?>
            </div>
        <?php endif; ?>

        <div class="w-48">
            <?= $this->element('table/date_filter', ['class' => "p-2.5 bg-white"]); ?>
        </div>
    </div>

    <!-- Sorting Controls -->
    <div class="flex flex-col md:flex-row justify-between space-y-3 items-center py-4" id="resources-filter-panel">
        <?= $this->element('table/search', ['class' => 'bg-white']) ?>

        <div class="flex justify-end items-center space-x-3 text-sm">
            <span class="text-gray-500 dark:text-gray-400 font-medium">Sort by:</span>
            <?= $this->Paginator->sort('title', 'Title', ['class' => 'font-semibold transition-colors']) ?>
            <span class="text-gray-300">|</span>
            <?= $this->Paginator->sort('published_date', 'Date', ['class' => 'font-semibold transition-colors']) ?>
            <span class="text-gray-300">|</span>
            <?= $this->Paginator->sort('type', 'Type', ['class' => 'font-semibold transition-colors']) ?>
        </div>
    </div>

    <div id="grid-container">
        <?= $this->element('table/entity_tables/resources_grid') ?>
    </div>

    <?= $this->element('table/pagination_footer') ?>
</div>
