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
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('last_name', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'placeholder' => 'Enter last name',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('email', [
                            'type' => 'email',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Email Address'],
                            'placeholder' => 'Enter email address',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'escape' => false, 'text' => 'Password <span class="text-gray-500 font-normal">(optional)</span>'],
                            'placeholder' => 'Leave blank to keep current password',
                            'value' => '', // Always clear password field on edit load
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('phone', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'placeholder' => '04XX XXX XXX',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('image_path', [
                            'type' => 'file',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Avatar Image'],
                            'accept' => 'image/*',
                            'class' => 'block w-full text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400',
                        ]) ?>
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
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                    ]) ?>
                                </div>
                                <div>
                                    <?= $this->Form->control('patient.sex', [
                                        'type' => 'select',
                                        'options' => ['Male' => 'Male', 'Female' => 'Female'],
                                        'empty' => '-- Select Gender --',
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Gender'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                    ]) ?>
                                </div>
                                <div class="sm:col-span-2">
                                    <?= $this->Form->control('patient.clinician_id', [
                                        'type' => 'select',
                                        'options' => $clinicians,
                                        'empty' => '-- No Clinician Assigned --',
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Assigned Clinician'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                    ]) ?>
                                </div>
                                <div class="sm:col-span-2">
                                    <?= $this->Form->control('patient.notes', [
                                        'type' => 'textarea',
                                        'rows' => 4,
                                        'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Notes'],
                                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
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
                    <?= $this->element('button/red_button', [
                        'label' => 'Delete',
                        'url' => ['action' => 'delete', $user->id],
                        'confirm' => __('Are you sure you want to delete {0}?', $user->full_name),
                        'iconType' => 'delete'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
