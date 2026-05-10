<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var $identity
 */

// Breadcrumb
$breadcrumbs = [
    ['title' => 'Users', 'url' => ['action' => 'index']],
    ['title' => 'Add User', 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Add New User');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Add New User',
        'description' => 'Create a new user account by filling out the form below.',
        'actionLabel' => 'Back',
        'actionUrl' => ['action' => 'index'],
    ]) ?>

    <?= $this->Form->create($user, ['type' => 'file', 'novalidate' => true]) ?>

    <div class="grid grid-cols-1 gap-4">
        <div class="col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Personal Information</h3>
                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">

                    <div>
                        <?= $this->Form->control('first_name', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'First Name'],
                            'placeholder' => 'Enter first name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('last_name', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Last Name'],
                            'placeholder' => 'Enter last name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('email', [
                            'type' => 'email',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Email Address'],
                            'placeholder' => 'Enter email address',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Password'],
                            'placeholder' => 'Enter password',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('phone', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Phone Number'],
                            'placeholder' => '04XX XXX XXX',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('image_path', [
                            'type' => 'file',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Avatar Image'],
                            'accept' => 'image/*',
                            'class' => 'block w-full text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('role', [
                            'type' => 'select',
                            'options' => [
                                'admin' => 'Administrator',
                                'clinician' => 'Clinician',
                                'patient' => 'Patient'
                            ],
                            'id' => 'roleSelect',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Role'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                        ]) ?>
                    </div>

                    <div id="patientSection" class="sm:col-span-2 hidden">
                        <h4 class="mb-4 text-md font-semibold dark:text-white border-t pt-4">Patient Information</h4>

                        <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <?= $this->Form->control('patient_dob', [
                                    'type' => 'date',
                                    'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Date of Birth'],
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                                    'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>'],
                                    'max' => date('Y-m-d'),
                                    'min' => date('Y-m-d', strtotime('-120 years'))
                                ]) ?>
                            </div>

                            <div>
                                <?= $this->Form->control('patient_sex', [
                                    'type' => 'select',
                                    'options' => ['Male' => 'Male', 'Female' => 'Female'],
                                    'empty' => '-- Select Gender --',
                                    'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Gender'],
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                                    'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                                ]) ?>
                            </div>

                            <div class="sm:col-span-2">
                                <?= $this->Form->control('patient_clinician_id', [
                                    'type' => 'select',
                                    'options' => $clinicians,
                                    'empty' => '-- No Clinician Assigned --',
                                    'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Assigned Clinician'],
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                                    'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                                ]) ?>
                            </div>

                            <div class="sm:col-span-2">
                                <?= $this->Form->control('patient_notes', [
                                    'type' => 'textarea',
                                    'rows' => 4,
                                    'placeholder' => 'Enter additional notes...',
                                    'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Notes'],
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                                    'templates' => ['error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>']
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <button type="submit" class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Create User
                    </button>
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
