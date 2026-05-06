<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\ContactMessage> $contactMessages
 */

$this->setLayout($identity->role);
$this->assign('title', 'Dashboard Overview');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Admin Dashboard',
        'description' => 'Manage incoming contact messages.',
    ]) ?>

    <div class="grid w-full grid-cols-1 gap-4 mb-6 sm:grid-cols-2 2xl:grid-cols-3">

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Inbound Messages') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                <?= $totalMessages ?? 0 ?>
            </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Contact form submissions') ?></p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Total Clinicians') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                <?= $totalClinicians ?? 0 ?>
            </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Registered medical staff') ?></p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Total Patients') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                <?= $totalPatients ?? 0 ?>
            </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Active patient profiles') ?></p>
            </div>
        </div>

    </div>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/admin_dashboard_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>


