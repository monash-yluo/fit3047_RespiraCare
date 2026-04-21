<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 */

$this->setLayout($identity->role);
$this->assign('title', 'Reminder Details');
?>

<div class="px-4 pt-6">
    <?= $this->element('table/page_header', [
        'title' => 'Reminder Details',
        'description' => 'Viewing information and message content for this reminder.',
        'showBack' => true,
    ]) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2 space-y-4">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Message Content</h3>
                <div class="text-base text-gray-900 dark:text-white prose dark:prose-invert max-w-none">
                    <?= $this->Text->autoParagraph(h($reminder->message)); ?>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Reminder ID</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">#<?= $this->Number->format($reminder->id) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Status</p>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Active</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Created</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= $this->Time->format($reminder->created, 'dd MMM, YYYY HH:mm') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Last Modified</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mt-1"><?= $this->Time->format($reminder->modified, 'dd MMM, YYYY HH:mm') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1 space-y-4">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Participants</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Recipient</p>
                        <div class="flex items-center mt-2">
                            <div class="flex-shrink-0 w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                <?= $reminder->hasValue('receiver') ? $this->Html->link(h($reminder->receiver->first_name . ' ' . $reminder->receiver->last_name), ['controller' => 'Users', 'action' => 'view', $reminder->receiver->id], ['class' => 'hover:underline text-primary-600 dark:text-primary-500']) : 'N/A' ?>
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-normal">Sender</p>
                        <div class="flex items-center mt-2">
                            <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3 dark:bg-gray-700">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                <?= $reminder->hasValue('sender') ? $this->Html->link(h($reminder->sender->first_name . ' ' . $reminder->sender->last_name), ['controller' => 'Users', 'action' => 'view', $reminder->sender->id], ['class' => 'hover:underline']) : '<span class="text-gray-400 font-normal italic">System Generated</span>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-4">Management</h3>
                <div class="flex flex-col space-y-3">
                    <?= $this->element('button/blue_button', [
                        'label' => 'Edit Reminder',
                        'url' => ['action' => 'edit', $reminder->id],
                        'iconType' => 'edit'
                    ]) ?>

                    <?= $this->element('button/red_button', [
                        'label' => 'Delete Reminder',
                        'url' => ['action' => 'delete', $reminder->id],
                        'confirm' => __('Are you sure you want to delete this reminder?'),
                        'iconType' => 'delete'
                    ]) ?>

                    <?= $this->element('button/red_button', [
                        'label' => 'Back to List',
                        'url' => ['action' => 'index']
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
