<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 * @var $identity
 */

$this->setLayout($identity->role);
$this->assign('title', 'Patient Profile');

$back_url = ['controller' => 'Patients', 'action' => 'index'];
if ($identity->role === 'admin') {
    $back_url = ['controller' => 'Patients', 'action' => 'index'];
} elseif ($identity->role === 'clinician') {
    $back_url = ['controller' => 'Patients', 'action' => 'clinicianIndex'];
}

$breadcrumbs = [
    ['title' => 'Patients', 'url' => $back_url],
    ['title' => '#' . $patient->id, 'url' => null],
];
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Patient Profile',
        'description' => 'View patient information, health measurements, and symptom history.',
        'showBack' => true,
    ]) ?>

    <!-- Patient Information Card -->
    <div class="grid grid-cols-1 gap-4 mb-6 xl:grid-cols-2 2xl:grid-cols-3">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <?php if ($patient->hasValue('user')) : ?>
                            <?= h($patient->user->full_name) ?>
                        <?php else : ?>
                            <span class="text-gray-400">Unknown Patient</span>
                        <?php endif; ?>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Patient ID: <?= $this->Number->format($patient->id) ?></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Date of Birth</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= $this->Time->format($patient->dob, 'dd MMM, YYYY') ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Gender</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($patient->sex) ?></p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Contact Information</h3>
            <div class="space-y-3">
                <?php if ($patient->hasValue('user')) : ?>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Email</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($patient->user->email) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Phone</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($patient->user->phone) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Care Team</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Assigned Clinician</p>
                    <?php if ($patient->hasValue('clinician')) : ?>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                            <?=  h($patient->clinician->user->full_name)
                            /* $this->Html->link(
                                h($patient->clinician->user->first_name . ' ' . $patient->clinician->user->last_name),
                                ['controller' => 'Clinicians', 'action' => 'view', $patient->clinician->id],
                                ['class' => 'text-primary-600 hover:underline dark:text-primary-500']
                            ) */ ?>
                        </p>
                    <?php else : ?>
                        <p class="text-sm text-gray-400 italic mt-1">Not assigned</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Notes -->
    <?php if (!empty($patient->notes)) : ?>
        <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Clinical Notes</h3>
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <?= $this->Text->autoParagraph(h($patient->notes)); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Health Measurements Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Health Measurements</h2>
            <?php if ($identity->role === 'admin') : ?>
                <?= $this->Html->link(
                    '<svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Add Measurement',
                    ['controller' => 'PatientMeasurements', 'action' => 'add', $patient->id],
                    ['escape' => false, 'class' => 'inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                ) ?>
            <?php endif; ?>
        </div>

        <?= $this->element('table/table_wrapper', [
            'hasSearch' => false,
            'tableElement' => 'table/entity_tables/patient_measurements_table',
        ]) ?>
    </div>

    <!-- Symptom Logs Section -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Symptom History</h2>
            <?php if ($identity->role === 'admin') : ?>
                <?= $this->Html->link(
                    '<svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Add Symptom',
                    ['controller' => 'SymptomLogs', 'action' => 'add', $patient->id],
                    ['escape' => false, 'class' => 'inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                ) ?>
            <?php endif; ?>
        </div>

        <?= $this->element('table/table_wrapper', [
            'hasSearch' => false,
            'tableElement' => 'table/entity_tables/patient_symptoms_table',
        ]) ?>
    </div>

</div>
