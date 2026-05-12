<?php
/**
 * @var \App\View\AppView $this
 * @var $reminders
 * @var $identity
 */

$this->setLayout($identity->role);
$canCreate = in_array($identity->role, ['admin', 'clinician']);
$this->assign('title', 'System Reminders');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'System Reminders',
        'description' => 'View and manage automated health data reminders and communications.',
        'actionLabel' => $canCreate ? __('New Reminder') : null,
        'actionUrl' => $canCreate ? ['action' => 'add'] : null,
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/reminders_table',
        'hasDateFilter' => true,
        'filterConfig' => [
            'paramName' => 'is_read',
            'options' => [
                '' => 'All',
                'unread' => 'Unread',
                'read' => 'Read',
            ],
        ],
    ]) ?>

</div>
