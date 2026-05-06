<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\SymptomLog> $symptomLogs
 */
$this->setLayout($identity->role);
$this->assign('title', 'Symptom History');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Symptom History',
        'description' => 'Keep track of your respiratory health and symptoms.',
        'actionLabel' => __('Log New Symptom'),
        'actionUrl' => ['action' => 'add']
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'hasSearch' => false,
        'tableElement' => 'table/entity_tables/symptoms_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
