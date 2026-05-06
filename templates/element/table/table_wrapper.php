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
$useContainer = $useContainer ?? true;

if (empty($tableElement)) {
    throw new NotFoundException('table_wrapper requires a $tableElement to be passed.');
}

?>
<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">

                <?php if ($hasSearch) : ?>
                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900 border border-b-0 border-gray-200 dark:border-gray-700">
                        <?= $this->element('table/search') ?>
                    </div>
                <?php endif; ?>

                <div class="<?= $useContainer ? 'ajax-table-content' : null; ?>">
                    <?= $this->element($tableElement) ?>
                </div>
            </div>
        </div>
    </div>
</div>

