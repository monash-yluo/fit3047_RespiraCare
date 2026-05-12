<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var $identity
 */

$this->setLayout($identity->role);

// Status color mapping
$statusColors = [
    'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
    'declined' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
];
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Booking Details',
        'description' => 'Scheduled for ' . $this->Time->format($booking->scheduled_date, 'MMMM d, YYYY') . ' at ' . $this->Time->format($booking->scheduled_date, 'HH:mm'),
        'showBack' => true
    ]) ?>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 space-y-6">
            <!-- Patient Information Card -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Patient Information</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Patient Name</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            <?= !empty($booking->patient->user->first_name) ? h($booking->patient->user->first_name) . ' ' . h($booking->patient->user->last_name) : 'N/A' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Patient ID</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white font-mono">
                            #<?= h($booking->patient->id) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Assigned Clinician</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            <?= !empty($booking->patient->clinician->user->first_name) ? h($booking->patient->clinician->user->first_name) . ' ' . h($booking->patient->clinician->user->last_name) : 'N/A' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Booking Details Card -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Booking Information</h3>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Scheduled Date & Time</p>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">
                            <?= $this->Time->format($booking->scheduled_date, 'MMMM d, YYYY') ?>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 font-mono">
                            <?= $this->Time->format($booking->scheduled_date, 'HH:mm') ?>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Status</p>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium <?= $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' ?>">
                            <?= h($booking->status) ?>
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Booking Clinician</p>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">
                            <?= !empty($booking->clinician->user) ? h($booking->clinician->user->full_name) : 'N/A' ?>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 font-mono">
                            Clinician #<?= h($booking->clinician->id) ?>
                        </p>
                    </div>
                </div>
            </div>


        </div>

        <!-- Right Sidebar -->
        <div class="xl:col-span-1 space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 h-full flex flex-col">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Notes</h3>
                <div class="prose dark:prose-invert italic text-gray-600 dark:text-gray-300 flex-grow">
                    <?php if (!empty($booking->notes)): ?>
                        <?= nl2br(h($booking->notes)) ?>
                    <?php else: ?>
                        <p class="text-gray-400">No additional notes recorded for this record.</p>
                    <?php endif; ?>
                </div>

                <hr class="my-6 border-gray-100 dark:border-gray-700">

                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Booking ID</span>
                        <span class="font-mono text-gray-900 dark:text-white">#<?= h($booking->id) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Created At</span>
                        <span class="text-gray-900 dark:text-white"><?= $this->Time->format($booking->created, 'yyyy-MM-dd HH:mm') ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Last Modified</span>
                        <span class="text-gray-900 dark:text-white"><?= $this->Time->format($booking->modified, 'yyyy-MM-dd HH:mm') ?></span>
                    </div>
                </div>

                <hr class="my-6 border-gray-100 dark:border-gray-700">

                <div class="flex flex-col gap-2">
                    <?php if ($identity->role === 'admin' || $identity->role === 'clinician') : ?>
                        <?php if ($booking->status !== 'confirmed'): ?>
                            <?= $this->Form->postLink(
                                '<i class="w-4 h-4" data-lucide="circle-check"></i> Confirm appointment',
                                ['action' => 'changeStatus', $booking->id, 'confirmed'],
                                [
                                    'escape' => false,
                                    'class' => 'w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium rounded-lg
                            text-gray-700 border border-gray-200 bg-white
                            hover:bg-green-50 hover:text-green-800 hover:border-green-300
                            dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700
                            dark:hover:bg-green-950 dark:hover:text-green-300 dark:hover:border-green-700
                            transition-all'
                                ]
                            ) ?>
                        <?php endif; ?>

                        <?php if ($booking->status !== 'declined'): ?>
                            <?= $this->Form->postLink(
                                '<i class="w-4 h-4" data-lucide="circle-x"></i> Decline request',
                                ['action' => 'changeStatus', $booking->id, 'declined'],
                                [
                                    'escape' => false,
                                    'confirm' => __('Are you sure to decline this booking?'),
                                    'class' => 'w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium rounded-lg
                            text-gray-700 border border-gray-200 bg-white
                            hover:bg-red-50 hover:text-red-800 hover:border-red-300
                            dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700
                            dark:hover:bg-red-950 dark:hover:text-red-300 dark:hover:border-red-700
                            transition-all'
                                ]
                            ) ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($identity->role === 'admin'): ?>
                        <hr class="border-gray-100 dark:border-gray-700 my-1">
                        <?= $this->Form->postLink(
                            '<i class="w-4 h-4" data-lucide="trash-2"></i> Delete record',
                            ['action' => 'delete', $booking->id],
                            [
                                'escape' => false,
                                'confirm' => __('Permanently delete this booking?'),
                                'class' => 'w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium rounded-lg
                            text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 transition-all'
                            ]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
