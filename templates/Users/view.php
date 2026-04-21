<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->setLayout($identity->role);
$this->assign('title', 'User Profile');
?>

<div class="px-4 pt-6">
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
                        <img src="<?= h($user->image_path) ?>" alt="User Avatar" class="w-24 h-24 rounded-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center" style="display:none;">
                            <svg class="w-12 h-12 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
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
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Assigned Clinician</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                            <?= h($user->patient->clinician->user->first_name . ' ' . $user->patient->clinician->user->last_name) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
