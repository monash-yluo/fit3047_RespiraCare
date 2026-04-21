<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 * @var $identity
 */

$this->setLayout($identity->role);
$this->assign('title', 'Reminder Details');

// Breadcrumb
$breadcrumbs = [
    ['title' => 'Contact Messages', 'url' => ['controller' => 'Reminders', 'action' => 'index']],
    ['title' => $reminder->id, 'url' => null],
];

// Authorization Check
$isStaff = in_array($identity->role, ['admin', 'clinician']);
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Reminder Details',
        'description' => 'Viewing system communication record.',
        'showBack' => true,
    ]) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 h-full">
                <div class="flex items-center justify-between mb-4 border-b pb-4 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Message Content</h3>
                    <span class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">
                        ID: #<?= h($reminder->id) ?>
                    </span>
                </div>
                <div class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed italic">
                    “<?= $this->Text->autoParagraph(h($reminder->message)); ?>”
                </div>
            </div>
        </div>

        <div class="xl:col-span-1 space-y-4">

            <?php if ($isStaff): ?>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Management</h3>
                    <div class="flex flex-col space-y-3">
                        <?= $this->element('button/blue_button', [
                            'label' => 'Edit Message',
                            'url' => ['action' => 'edit', $reminder->id],
                            'iconType' => 'edit'
                        ]) ?>

                        <?= $this->element('button/red_button', [
                            'label' => 'Delete Record',
                            'url' => ['action' => 'delete', $reminder->id],
                            'confirm' => __('Are you sure you want to delete this reminder?'),
                            'iconType' => 'delete'
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Participants
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Recipient</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            <?= $reminder->hasValue('receiver') ? $this->Html->link(h($reminder->receiver->full_name ?? $reminder->receiver->first_name), ['controller' => 'Users', 'action' => 'view', $reminder->receiver->id], ['class' => 'text-primary-600 hover:underline']) : 'N/A' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Sender</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            <?= $reminder->hasValue('sender') ? h($reminder->sender->first_name . ' ' . $reminder->sender->last_name) : '<span class="text-gray-400 italic">System</span>' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Timeline
                </h3>
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Created</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium"><?= $this->Time->format($reminder->created, 'dd MMM, YYYY HH:mm') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Last Updated</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium"><?= $this->Time->format($reminder->modified, 'dd MMM, YYYY HH:mm') ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
