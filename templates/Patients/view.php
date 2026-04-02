<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Patient'), ['action' => 'edit', $patient->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Patient'), ['action' => 'delete', $patient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patient->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Patients'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Patient'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="patients view content">
            <h3><?= h($patient->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $patient->hasValue('user') ? $this->Html->link($patient->user->first_name, ['controller' => 'Users', 'action' => 'view', $patient->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinician') ?></th>
                    <td><?= $patient->hasValue('clinician') ? $this->Html->link($patient->clinician->id, ['controller' => 'Clinicians', 'action' => 'view', $patient->clinician->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Sex') ?></th>
                    <td><?= h($patient->sex) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($patient->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($patient->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dob') ?></th>
                    <td><?= h($patient->dob) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($patient->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($patient->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($patient->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Ai Insights') ?></h4>
                <?php if (!empty($patient->ai_insights)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Risk Level') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->ai_insights as $aiInsight) : ?>
                        <tr>
                            <td><?= h($aiInsight->id) ?></td>
                            <td><?= h($aiInsight->description) ?></td>
                            <td><?= h($aiInsight->risk_level) ?></td>
                            <td><?= h($aiInsight->created) ?></td>
                            <td><?= h($aiInsight->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AiInsights', 'action' => 'view', $aiInsight->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AiInsights', 'action' => 'edit', $aiInsight->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'AiInsights', 'action' => 'delete', $aiInsight->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $aiInsight->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Bookings') ?></h4>
                <?php if (!empty($patient->bookings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Clinician Id') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Scheduled Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->bookings as $booking) : ?>
                        <tr>
                            <td><?= h($booking->id) ?></td>
                            <td><?= h($booking->clinician_id) ?></td>
                            <td><?= h($booking->notes) ?></td>
                            <td><?= h($booking->scheduled_date) ?></td>
                            <td><?= h($booking->status) ?></td>
                            <td><?= h($booking->created) ?></td>
                            <td><?= h($booking->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Bookings', 'action' => 'view', $booking->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Bookings', 'action' => 'edit', $booking->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Bookings', 'action' => 'delete', $booking->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $booking->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Contact Messages') ?></h4>
                <?php if (!empty($patient->contact_messages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Category') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->contact_messages as $contactMessage) : ?>
                        <tr>
                            <td><?= h($contactMessage->id) ?></td>
                            <td><?= h($contactMessage->first_name) ?></td>
                            <td><?= h($contactMessage->last_name) ?></td>
                            <td><?= h($contactMessage->email) ?></td>
                            <td><?= h($contactMessage->category) ?></td>
                            <td><?= h($contactMessage->status) ?></td>
                            <td><?= h($contactMessage->message) ?></td>
                            <td><?= h($contactMessage->created) ?></td>
                            <td><?= h($contactMessage->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ContactMessages', 'action' => 'view', $contactMessage->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ContactMessages', 'action' => 'edit', $contactMessage->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ContactMessages', 'action' => 'delete', $contactMessage->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $contactMessage->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient Measurements') ?></h4>
                <?php if (!empty($patient->patient_measurements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Measured At') ?></th>
                            <th><?= __('Spo2') ?></th>
                            <th><?= __('Heart Rate') ?></th>
                            <th><?= __('Temperature') ?></th>
                            <th><?= __('Respiratory Rate') ?></th>
                            <th><?= __('Peak Flow') ?></th>
                            <th><?= __('Blood Pressure Systolic') ?></th>
                            <th><?= __('Blood Pressure Diastolic') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->patient_measurements as $patientMeasurement) : ?>
                        <tr>
                            <td><?= h($patientMeasurement->id) ?></td>
                            <td><?= h($patientMeasurement->measured_at) ?></td>
                            <td><?= h($patientMeasurement->spo2) ?></td>
                            <td><?= h($patientMeasurement->heart_rate) ?></td>
                            <td><?= h($patientMeasurement->temperature) ?></td>
                            <td><?= h($patientMeasurement->respiratory_rate) ?></td>
                            <td><?= h($patientMeasurement->peak_flow) ?></td>
                            <td><?= h($patientMeasurement->blood_pressure_systolic) ?></td>
                            <td><?= h($patientMeasurement->blood_pressure_diastolic) ?></td>
                            <td><?= h($patientMeasurement->notes) ?></td>
                            <td><?= h($patientMeasurement->created) ?></td>
                            <td><?= h($patientMeasurement->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientMeasurements', 'action' => 'view', $patientMeasurement->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientMeasurements', 'action' => 'edit', $patientMeasurement->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'PatientMeasurements', 'action' => 'delete', $patientMeasurement->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $patientMeasurement->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Reminders') ?></h4>
                <?php if (!empty($patient->reminders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Receiver Id') ?></th>
                            <th><?= __('Sender Id') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->reminders as $reminder) : ?>
                        <tr>
                            <td><?= h($reminder->id) ?></td>
                            <td><?= h($reminder->receiver_id) ?></td>
                            <td><?= h($reminder->sender_id) ?></td>
                            <td><?= h($reminder->message) ?></td>
                            <td><?= h($reminder->created) ?></td>
                            <td><?= h($reminder->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Reminders', 'action' => 'view', $reminder->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Reminders', 'action' => 'edit', $reminder->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Reminders', 'action' => 'delete', $reminder->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $reminder->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Symptom Logs') ?></h4>
                <?php if (!empty($patient->symptom_logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Logged At') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->symptom_logs as $symptomLog) : ?>
                        <tr>
                            <td><?= h($symptomLog->id) ?></td>
                            <td><?= h($symptomLog->description) ?></td>
                            <td><?= h($symptomLog->logged_at) ?></td>
                            <td><?= h($symptomLog->notes) ?></td>
                            <td><?= h($symptomLog->created) ?></td>
                            <td><?= h($symptomLog->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SymptomLogs', 'action' => 'view', $symptomLog->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SymptomLogs', 'action' => 'edit', $symptomLog->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'SymptomLogs', 'action' => 'delete', $symptomLog->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $symptomLog->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>