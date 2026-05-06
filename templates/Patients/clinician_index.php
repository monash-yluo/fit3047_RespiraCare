<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Patient> $myPatients
 * @var iterable<\App\Model\Entity\Patient> $allPatients
 * @var $identity
 */

$this->setLayout($identity->role);
$this->assign('title', 'Manage Patients');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Manage Patients',
        'description' => 'View your assigned patients and all patients in the system.',
    ]) ?>

    <div class="ajax-table-content">
        <?= $this->element('table/entity_tables/clinician_combined_tables') ?>
    </div>

</div>
