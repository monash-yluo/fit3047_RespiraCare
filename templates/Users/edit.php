<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $identity
 */

$breadcrumbs = [
    ['title' => 'Users', 'url' => ['action' => 'index']],
    ['title' => 'Edit #' . $user->id, 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Edit User');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Edit User',
        'description' => 'Modify user account information and details.',
        'showBack' => true,
    ]) ?>

    <?= $this->Form->create($user, ['type' => 'file', 'novalidate' => true]) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Personal Information</h3>
                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">

                    <div>
                        <?= $this->Form->control('first_name', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'placeholder' => 'Enter first name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('last_name', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'placeholder' => 'Enter last name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('email', [
                            'type' => 'email',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Email Address'],
                            'placeholder' => 'Enter email address',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'escape' => false, 'text' => 'Password <span class="text-gray-500 font-normal">(optional)</span>'],
                            'placeholder' => 'Leave blank to keep current password',
                            'value' => '', // Always clear password field on edit load
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500 ',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('phone', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'placeholder' => '04XX XXX XXX',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                        ]) ?>
                    </div>

                    <div class="flex flex-row items-end w-full space-x-3">
                        <?= $this->Form->control('image_path', [
                            'type' => 'file',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Avatar Image'],
                            'class' => 'block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 placeholder-gray-500',
                            'templates' => [
                                'fileContainer' => '<div class="input file flex-1">{{content}}</div>'
                            ]
                        ]) ?>

                        <?php if (!empty($user->image_path)): ?>
                            <div class="flex-shrink-0">
                                <input type="checkbox" name="delete_image" id="delete_image_checkbox" class="hidden peer">

                                <label for="delete_image_checkbox" class="inline-flex items-center px-4 py-2.5 text-xs font-medium text-center text-red-700 bg-white border border-red-700 rounded-lg cursor-pointer hover:bg-red-700 hover:text-white peer-checked:bg-red-700 peer-checked:text-white focus:ring-4 focus:ring-red-300 dark:bg-gray-800 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:peer-checked:bg-red-600 dark:peer-checked:text-white transition-all">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <div class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300 cursor-not-allowed">
                            <?php
                            $roleLabels = ['admin' => 'Administrator', 'clinician' => 'Clinician', 'patient' => 'Patient'];
                            echo $roleLabels[$user->role] ?? $user->role;
                            ?>
                        </div>
                        <?= $this->Form->hidden('role') ?>
                    </div>

                    <?php if ($user->role === 'patient'): ?>
                        <div class="sm:col-span-2">
                            <h4 class="mb-4 text-md font-semibold dark:text-white border-t pt-4">Patient Information</h4>
                            <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <?= $this->Form->control('patient.dob', [
                                        'type' => 'date',
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Date of Birth'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                                        'max' => date('Y-m-d'),
                                        'min' => date('Y-m-d', strtotime('-120 years'))
                                    ]) ?>
                                </div>
                                <div>
                                    <?= $this->Form->control('patient.sex', [
                                        'type' => 'select',
                                        'options' => ['Male' => 'Male', 'Female' => 'Female'],
                                        'empty' => '-- Select Gender --',
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Gender'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                                    ]) ?>
                                </div>
                                <div class="sm:col-span-2">
                                    <?= $this->Form->control('patient.clinician_id', [
                                        'type' => 'select',
                                        'options' => $clinicians,
                                        'empty' => '-- No Clinician Assigned --',
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Assigned Clinician'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
                                    ]) ?>
                                </div>
                                <div class="sm:col-span-2">
                                    <?= $this->Form->control('patient.notes', [
                                        'type' => 'textarea',
                                        'rows' => 4,
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Notes'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-500',
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
                <div class="flex flex-col space-y-4">
                    <?= $this->element('button/blue_button', ['label' => 'Update User', 'iconType' => 'edit', 'type' => 'submit']) ?>
                    <?= $this->Form->end() ?>
                    <?= $this->element('button/red_button', [
                        'label' => 'Delete User',
                        'iconType' => 'delete',
                        'url' => ['controller' => 'Users', 'action' => 'delete', $user->id],
                        'confirm' => __('Are you sure you want to delete user {0} {1}?', $user->first_name, $user->last_name),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
