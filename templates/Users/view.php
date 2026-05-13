<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var $identity
 */

$breadcrumbs = [
    ['title' => 'Users', 'url' => ['action' => 'index']],
    ['title' => '#' . $user->id, 'url' => null],
];
if ($identity->role === 'patient') {
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => ['action' => 'dashboard', 'controller' => 'Patients']],
        ['title' => '#' . $user->id, 'url' => null]
    ];
}
if ($identity->role === 'clinician') {
    $breadcrumbs = [
        ['title' => 'Dashboard', 'url' => ['action' => 'dashboard', 'controller' => 'Clinicians']],
        ['title' => '#' . $user->id, 'url' => null]
    ];
}


$this->setLayout($identity->role);
$this->assign('title', 'User Profile');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'User Profile',
        'description' => 'View user account information and details.',
        'showBack' => true,
    ]) ?>

    <!-- User Information Card -->
    <div class="grid grid-cols-1 gap-4 mb-6 lg:grid-cols-2">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-shrink-0">
                    <?php if ($user->image_path): ?>
                        <div class="relative overflow-hidden bg-gray-100 rounded-full shadow-sm w-24 h-24 dark:bg-gray-800">

                            <div class="absolute inset-0 bg-gray-200 animate-pulse dark:bg-gray-700"></div>

                            <?= $this->Html->image('users/' . $user->image_path, [
                                'alt' => h($user->first_name . ' ' . $user->last_name),
                                'class' => 'absolute inset-0 z-10 object-cover w-full h-full transition-opacity duration-300 opacity-0',
                                'onload' => "this.previousElementSibling.classList.add('hidden'); this.classList.remove('opacity-0');",
                                'onerror' => "this.previousElementSibling.classList.add('hidden'); this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                            ]) ?>

                            <div class="absolute inset-0 z-0 hidden flex items-center justify-center font-medium text-gray-600 bg-gray-200 text-3xl dark:bg-gray-700 dark:text-gray-300">
                                <?= h(strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1))) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-start justify-between gap-4 mt-5">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <?= h($user->first_name . ' ' . $user->last_name) ?>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">User ID: <?= $this->Number->format($user->id) ?></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Role</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                        <?php
                        $roleLabel = match ($user->role) {
                            'admin' => 'Administrator',
                            'clinician' => 'Clinician',
                            'patient' => 'Patient',
                            default => ucfirst($user->role)
                        };
                        echo h($roleLabel);
                        ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Account Created</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= $this->Time->format($user->created, 'dd MMM, YYYY') ?></p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Contact Information</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Email</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= h($user->email) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Phone</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                        <?= !empty($user->phone) ? h($user->phone) : '<span class="text-gray-400">Not provided</span>' ?>
                    </p>
                </div>
            </div>
        </div>

        <?php if ($user->role === 'patient' && $user->hasValue('patient')) : ?>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Patient Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Date of Birth</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                            <?= !empty($user->patient->dob) ? $this->Time->format($user->patient->dob, 'dd MMM, YYYY') : '<span class="text-gray-400">Not provided</span>' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Gender</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                            <?= !empty($user->patient->sex) ? h($user->patient->sex) : '<span class="text-gray-400">Not provided</span>' ?>
                        </p>
                    </div>
                    <?php if (!empty($user->patient->notes)) : ?>
                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal mb-2">Clinical Notes</p>
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                <?= $this->Text->autoParagraph(h($user->patient->notes)); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($user->role === 'patient' && $user->hasValue('patient') && $user->patient->hasValue('clinician')) : ?>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Care Team</h3>
                <div class="space-y-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Assigned Clinician</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                            <?php
                            $clinicianName = h($user->patient->clinician->user->full_name);
                            // Check if role is admin or clinician
                            if (in_array($identity->role, ['admin', 'clinician'])): ?>
                                <?= $this->Html->link(
                                    $clinicianName,
                                    ['controller' => 'Users', 'action' => 'view', $user->patient->clinician->user->id],
                                    ['class' => 'text-primary-600 hover:underline dark:text-primary-500']
                                ) ?>
                            <?php else: ?>
                                <?= $clinicianName ?>
                            <?php endif; ?>
                        </p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($user->role === 'clinician' && $user->hasValue('clinician') && !empty($user->clinician->patients)) : ?>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Patients</h3>
                <div class="space-y-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Assigned Patients</p>
                    <?php foreach ($user->clinician->patients as $patient) : ?>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                <?= $this->Html->link(
                                    h($patient->user->full_name),
                                    ['controller' => 'Users', 'action' => 'view', $patient->user->id],
                                    ['class' => 'text-primary-600 hover:underline dark:text-primary-500']
                                ) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


    </div>

</div>
