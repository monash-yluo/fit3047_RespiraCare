<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $identity
 * @var iterable<\App\Model\Entity\PatientMeasurement> $patientMeasurements
 */
$this->setLayout($identity->role);
$this->assign('title', 'Vitals & Measurements');

?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Vitals & Measurements',
        'description' => 'Keep track of your blood pressure, oxygen levels, and other vital signs.',
        'actionLabel' => __('Log New Measurement'),
        'actionUrl' => ['action' => 'add']
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'hasSearch' => false,
        'tableElement' => 'table/entity_tables/measurements_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
