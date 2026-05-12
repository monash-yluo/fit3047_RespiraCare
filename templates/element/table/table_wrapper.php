<?php
/**
 * Reusable Table Layout Wrapper
 *
 * This element ensures all data tables across the system have consistent
 * shadows, borders, and responsive scrolling.
 *
 * @var \App\View\AppView $this
 */

use Cake\Http\Exception\NotFoundException;

$hasSearch = $hasSearch ?? true;
$hasDateFilter = $hasDateFilter ?? false;
$tableElement = $tableElement ?? false;
$target = $target ?? true;

$filterConfig = $filterConfig ?? false;

if (empty($tableElement)) {
    throw new NotFoundException('table_wrapper requires a $tableElement to be passed.');
}

?>
<div class="data-table flex flex-col">

    <?php if (!empty($filterConfig)) : ?>
        <?= $this->element('table/filter_tabs', $filterConfig) ?>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="table_wrapper overflow-hidden shadow">

                <?php if ($hasSearch || $hasDateFilter) : ?>
                    <div class="p-4 bg-white dark:bg-gray-900 border border-b-0 border-gray-200 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row gap-3 w-full">

                            <!-- Search Bar -->
                            <?php if ($hasSearch) : ?>
                                <div class="flex-1">
                                    <?= $this->element('table/search', ['target' => $target]) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Date Filter Dropdown -->
                            <?php if ($hasDateFilter) : ?>
                                <div class="w-full sm:w-48 flex-shrink-0">
                                    <?= $this->element('table/date_filter', ['target' => $target]) ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="ajax-table-content">
                    <?= $this->element($tableElement) ?>
                </div>
            </div>
        </div>
    </div>
</div>

