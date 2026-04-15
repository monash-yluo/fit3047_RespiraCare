<?php
/**
 * Reusable Table Layout Wrapper
 *
 * This element ensures all data tables across the system have consistent
 * shadows, borders, and responsive scrolling.
 *
 * @var \App\View\AppView $this
 */
?>
<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 border border-b-0 border-gray-200">

                    <?= $this->fetch('table_content') ?>

                </table>
            </div>
        </div>
    </div>
</div>
