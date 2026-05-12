<?php

/**
 * @var \App\View\AppView $this
 * @var $patients
 */

$this->setLayout($identity->role);
$this->assign('title', 'Manage Patients');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Manage Patients',
        'description' => 'View, add, and manage patient records and clinician assignments.',
        'actionLabel' => __('New Patient'),
        'actionUrl' => ['controller' => 'Users', 'action' => 'add'],
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/patients_table',
    ]) ?>

</div>
