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

                <?php if ($hasSearch) : ?>
                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900 border border-b-0 border-gray-200 dark:border-gray-700">
                        <?= $this->element('table/search', ['target' => $target]) ?>
                    </div>
                <?php endif; ?>

                <div class="ajax-table-content">
                    <?= $this->element($tableElement) ?>
                </div>
            </div>
        </div>
    </div>
</div>

