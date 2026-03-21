<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PatientMeasurement $patientMeasurement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Patient Measurement'), ['action' => 'edit', $patientMeasurement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Patient Measurement'), ['action' => 'delete', $patientMeasurement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientMeasurement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Patient Measurements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Patient Measurement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="patientMeasurements view content">
            <h3><?= h($patientMeasurement->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $patientMeasurement->hasValue('patient') ? $this->Html->link($patientMeasurement->patient->id, ['controller' => 'Patients', 'action' => 'view', $patientMeasurement->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($patientMeasurement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Spo2') ?></th>
                    <td><?= $patientMeasurement->spo2 === null ? '' : $this->Number->format($patientMeasurement->spo2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Heart Rate') ?></th>
                    <td><?= $patientMeasurement->heart_rate === null ? '' : $this->Number->format($patientMeasurement->heart_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Temperature') ?></th>
                    <td><?= $patientMeasurement->temperature === null ? '' : $this->Number->format($patientMeasurement->temperature) ?></td>
                </tr>
                <tr>
                    <th><?= __('Respiratory Rate') ?></th>
                    <td><?= $patientMeasurement->respiratory_rate === null ? '' : $this->Number->format($patientMeasurement->respiratory_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Peak Flow') ?></th>
                    <td><?= $patientMeasurement->peak_flow === null ? '' : $this->Number->format($patientMeasurement->peak_flow) ?></td>
                </tr>
                <tr>
                    <th><?= __('Blood Pressure Systolic') ?></th>
                    <td><?= $patientMeasurement->blood_pressure_systolic === null ? '' : $this->Number->format($patientMeasurement->blood_pressure_systolic) ?></td>
                </tr>
                <tr>
                    <th><?= __('Blood Pressure Diastolic') ?></th>
                    <td><?= $patientMeasurement->blood_pressure_diastolic === null ? '' : $this->Number->format($patientMeasurement->blood_pressure_diastolic) ?></td>
                </tr>
                <tr>
                    <th><?= __('Measured At') ?></th>
                    <td><?= h($patientMeasurement->measured_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($patientMeasurement->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($patientMeasurement->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($patientMeasurement->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>