<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PatientMeasurement $patientMeasurement
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Patient Measurements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="patientMeasurements form content">
            <?= $this->Form->create($patientMeasurement) ?>
            <fieldset>
                <legend><?= __('Add Patient Measurement') ?></legend>
                <?php
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('measured_at');
                    echo $this->Form->control('spo2');
                    echo $this->Form->control('heart_rate');
                    echo $this->Form->control('temperature');
                    echo $this->Form->control('respiratory_rate');
                    echo $this->Form->control('peak_flow');
                    echo $this->Form->control('blood_pressure_systolic');
                    echo $this->Form->control('blood_pressure_diastolic');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
