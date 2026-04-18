<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->setLayout($identity->role);
$this->assign('title', 'Edit User');
?>

<div class="px-4 pt-6">
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                Edit User
            </h1>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">Update the user account information below.</p>
        </div>
    </div>

    <?= $this->Form->create($user, ['type' => 'file']) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Personal Information</h3>
                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <?= $this->Form->text('first_name', [
                            'placeholder' => 'Enter first name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'required' => true
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                        <?= $this->Form->text('last_name', [
                            'placeholder' => 'Enter last name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'required' => true
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Address</label>
                        <?= $this->Form->email('email', [
                            'placeholder' => 'Enter email address',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'required' => true
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password <span class="text-gray-500">(optional)</span></label>
                        <?= $this->Form->password('password', [
                            'placeholder' => 'Leave blank to keep current password',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400'
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                        <?= $this->Form->text('phone', [
                            'placeholder' => 'Enter phone number',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400'
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Avatar Image</label>
                        <?= $this->Form->file('image_path', [
                            'accept' => 'image/*',
                            'class' => 'block w-full text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 dark:placeholder-gray-400'
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <?php
                            $roleLabels = [
                                'admin' => 'Administrator',
                                'clinician' => 'Clinician',
                                'patient' => 'Patient'
                            ];
                            echo $roleLabels[$user->role] ?? $user->role;
                            ?>
                        </div>
                        <?= $this->Form->hidden('role') ?>
                    </div>

                    <!-- Patient Additional Information Section -->
                    <?php if ($user->role === 'patient'): ?>
                        <div class="sm:col-span-2">
                            <h4 class="mb-4 text-md font-semibold dark:text-white border-t pt-4">Patient Information</h4>

                            <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth</label>
                                    <?= $this->Form->date('patient_dob', [
                                        'value' => isset($user->patient) ? $user->patient->dob : null,
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400'
                                    ]) ?>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                    <?= $this->Form->select('patient_sex', [
                                        '' => '-- Select Gender --',
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                    ], [
                                        'value' => isset($user->patient) ? $user->patient->sex : '',
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400'
                                    ]) ?>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assigned Clinician</label>
                                    <?= $this->Form->select('patient_clinician_id', $clinicians, [
                                        'empty' => '-- No Clinician Assigned --',
                                        'value' => isset($user->patient) ? $user->patient->clinician_id : '',
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400'
                                    ]) ?>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                    <?= $this->Form->textarea('patient_notes', [
                                        'value' => isset($user->patient) ? $user->patient->notes : '',
                                        'placeholder' => 'Enter any additional notes about the patient',
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                                        'rows' => 4
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Actions</h3>
                <div class="space-y-4">
                    <div class="flex flex-col space-y-4">
                        <?= $this->element('button/blue_button', ['label' => 'Update User', 'iconType' => 'edit']) ?>
                        <?= $this->element('button/red_button', ['label' => 'Delete', 'url' => ['action' => 'delete', $user->id], 'confirm' => __('Are you sure you want to delete this user?'), 'iconType' => 'delete']) ?>
                        <?= $this->element('button/grey_button', ['label' => 'Back to List', 'smartBack' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>