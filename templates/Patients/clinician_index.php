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

    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">My Patients</h2>

        <?= $this->element('table/table_wrapper', [
            'target' => 'my_patients',
            'tableElement' => 'table/entity_tables/clinician_patients_table',
        ]) ?>
    </div>

    <!-- All Patients Section -->
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">All Patients</h2>

        <?= $this->element('table/table_wrapper', [
            'target' => 'all_patients',
            'tableElement' => 'table/entity_tables/clinician_allpatients_table',
        ]) ?>
    </div>


</div>
