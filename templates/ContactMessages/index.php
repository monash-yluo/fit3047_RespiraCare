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

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/contact_messages_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
