<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">My Patients</h2>

    <?= $this->element('table/table_wrapper', [
        'hasSearch' => false,
        'useContainer' => false,
        'tableElement' => 'table/entity_tables/clinician_patients_table',
    ]) ?>

    <?= $this->element('table/pagination_footer', ['scope' => 'myPatients']) ?>
</div>

<!-- All Patients Section -->
<div>
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">All Patients</h2>

    <?= $this->element('table/table_wrapper', [
        'useContainer' => false,
        'tableElement' => 'table/entity_tables/clinician_allpatients_table',
    ]) ?>

    <?= $this->element('table/pagination_footer', ['scope' => 'allPatients']) ?>
</div>
