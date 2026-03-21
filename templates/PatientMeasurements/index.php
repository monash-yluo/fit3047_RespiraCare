<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PatientMeasurement> $patientMeasurements
 */
?>
<div class="patientMeasurements index content">
    <?= $this->Html->link(__('New Patient Measurement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Patient Measurements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('measured_at') ?></th>
                    <th><?= $this->Paginator->sort('spo2') ?></th>
                    <th><?= $this->Paginator->sort('heart_rate') ?></th>
                    <th><?= $this->Paginator->sort('temperature') ?></th>
                    <th><?= $this->Paginator->sort('respiratory_rate') ?></th>
                    <th><?= $this->Paginator->sort('peak_flow') ?></th>
                    <th><?= $this->Paginator->sort('blood_pressure_systolic') ?></th>
                    <th><?= $this->Paginator->sort('blood_pressure_diastolic') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patientMeasurements as $patientMeasurement): ?>
                <tr>
                    <td><?= $this->Number->format($patientMeasurement->id) ?></td>
                    <td><?= $patientMeasurement->hasValue('patient') ? $this->Html->link($patientMeasurement->patient->id, ['controller' => 'Patients', 'action' => 'view', $patientMeasurement->patient->id]) : '' ?></td>
                    <td><?= h($patientMeasurement->measured_at) ?></td>
                    <td><?= $patientMeasurement->spo2 === null ? '' : $this->Number->format($patientMeasurement->spo2) ?></td>
                    <td><?= $patientMeasurement->heart_rate === null ? '' : $this->Number->format($patientMeasurement->heart_rate) ?></td>
                    <td><?= $patientMeasurement->temperature === null ? '' : $this->Number->format($patientMeasurement->temperature) ?></td>
                    <td><?= $patientMeasurement->respiratory_rate === null ? '' : $this->Number->format($patientMeasurement->respiratory_rate) ?></td>
                    <td><?= $patientMeasurement->peak_flow === null ? '' : $this->Number->format($patientMeasurement->peak_flow) ?></td>
                    <td><?= $patientMeasurement->blood_pressure_systolic === null ? '' : $this->Number->format($patientMeasurement->blood_pressure_systolic) ?></td>
                    <td><?= $patientMeasurement->blood_pressure_diastolic === null ? '' : $this->Number->format($patientMeasurement->blood_pressure_diastolic) ?></td>
                    <td><?= h($patientMeasurement->created) ?></td>
                    <td><?= h($patientMeasurement->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $patientMeasurement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $patientMeasurement->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $patientMeasurement->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $patientMeasurement->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>