<?php
/**
 * @var \App\View\AppView $this
 * @var $contactMessages
 */

$this->setLayout($identity->role);
$this->assign('title', 'Contact Messages');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Contact Messages',
        'description' => 'Monitor and manage inquiries from patients and external users.',
    ]) ?>

    <div class="flex flex-col md:flex-row gap-4 items-end">
        <!-- Dropdown Style for Category -->
        <div class="flex flex-row gap-3 mb-4 items-center">
            <!-- Category Dropdown -->
            <div class="w-48">
                <?= $this->element('table/filter_dropdown', [
                    'paramName' => 'category',
                    'options' => [
                        '' => 'All Categories',
                        'General Inquiry' => 'General Inquiry',
                        'Technical Support' => 'Technical Support',
                        'Billing' => 'Billing',
                        'Feedback' => 'Feedback',
                    ],
                ]) ?>
            </div>

            <!-- Status Dropdown (Admin Only) -->
            <?php if ($identity->role === 'admin') : ?>
                <div class="w-48">
                    <?= $this->element('table/filter_dropdown', [
                        'paramName' => 'status',
                        'options' => [
                            '' => 'All Status',
                            'new' => 'New',
                            'pending' => 'Pending',
                            'replied' => 'Replied',
                            'closed' => 'Closed',
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/contact_messages_table',
        'hasDateFilter' => true,
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
