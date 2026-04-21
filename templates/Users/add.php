<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->setLayout($identity->role);
$this->assign('title', 'Add New User');
?>

<div class="px-4 pt-6">
    <?= $this->element('table/page_header', [
        'title' => 'Add New User',
        'description' => 'Create a new user account by filling out the form below.',
        'actionLabel' => 'Back',
        'actionUrl' => ['action' => 'index'],
    ]) ?>

    <?= $this->Form->create($user, ['type' => 'file']) ?>

    <div class="grid grid-cols-1 gap-4">
        <div class="col-span-1">
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
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <?= $this->Form->password('password', [
                            'placeholder' => 'Enter password',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'required' => true
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
                        <?= $this->Form->control('role', [
                            'type' => 'select',
                            'options' => [
                                'admin' => 'Administrator',
                                'clinician' => 'Clinician',
                                'patient' => 'Patient'
                            ],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'label' => false,
                            'required' => true,
                            'id' => 'roleSelect'
                        ]) ?>
                    </div>

                    <!-- Patient Additional Information Section -->
                    <div id="patientSection" class="sm:col-span-2 hidden">
                        <h4 class="mb-4 text-md font-semibold dark:text-white border-t pt-4">Patient Information</h4>

                        <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth</label>
                                <?= $this->Form->date('patient_dob', [
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
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400'
                                ]) ?>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assigned Clinician</label>
                                <?= $this->Form->select('patient_clinician_id', $clinicians, [
                                    'empty' => '-- No Clinician Assigned --',
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400'
                                ]) ?>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                <?= $this->Form->textarea('patient_notes', [
                                    'placeholder' => 'Enter any additional notes about the patient',
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                                    'rows' => 4
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold dark:text-white">Actions</h3>
                    <div class="space-y-4">
                        <div class="flex flex-col space-y-4">
                            <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                Create User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('roleSelect');
            const patientSection = document.getElementById('patientSection');

            // Show/hide patient section based on role selection
            function togglePatientSection() {
                if (roleSelect.value === 'patient') {
                    patientSection.classList.remove('hidden');
                } else {
                    patientSection.classList.add('hidden');
                }
            }

            // Initial check
            togglePatientSection();

            // Listen for changes
            roleSelect.addEventListener('change', togglePatientSection);
        });
    </script>
