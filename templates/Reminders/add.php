<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 * @var \Cake\Collection\CollectionInterface|string[] $receivers
 * @var $identity
 */

$breadcrumbs = [
    ['title' => 'Reminders', 'url' => ['action' => 'index']],
    ['title' => 'Add Reminder', 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Add Reminder');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Add Reminder',
        'description' => 'Create a new reminder for a specific recipient.',
        'showBack' => true,
    ]) ?>

    <?= $this->Form->create($reminder) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Reminder Information</h3>

                <div class="grid grid-cols-1 gap-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Recipient</label>
                        <?= $this->Form->control('receiver_id', [
                            'options' => $receivers,
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'required' => true,
                            'empty' => '-- Select Recipient --'
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
                        <?= $this->Form->textarea('message', [
                            'placeholder' => 'Enter the reminder message content...',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'rows' => 6,
                            'required' => true
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Actions</h3>
                <div class="space-y-4">
                    <div class="flex flex-col space-y-4">
                        <?= $this->element('button/blue_button', [
                            'label' => 'Save Reminder',
                            'iconType' => 'add',
                            'options' => ['type' => 'submit']
                        ]) ?>

                        <?= $this->element('button/red_button', [
                            'label' => 'Cancel',
                            'url' => ['action' => 'index']
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
