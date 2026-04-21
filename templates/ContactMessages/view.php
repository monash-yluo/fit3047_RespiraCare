<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactMessage $contactMessage
 * @var $identity
 */

$breadcrumbs = [
    ['title' => 'Contact Messages', 'url' => ['controller' => 'ContactMessages', 'action' => 'index']],
    ['title' => $contactMessage->id, 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Contact Messages');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <div class="mb-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                Message from
                <?php if ($contactMessage->patient_id) : ?>
                    <?= $this->Html->link(
                        $contactMessage->full_name,
                        ['controller' => 'Patients', 'action' => 'view', $contactMessage->patient_id],
                        ['class' => 'text-primary-600 hover:underline dark:text-primary-500'],
                    ) ?>
                <?php else : ?>
                    <?= h($contactMessage->full_name) ?>
                <?php endif; ?>
            </h1>
            <div class="flex space-x-2">
                <?= $this->element('button/back_button') ?>

                <?= $this->Form->button(__('Save Changes'), [
                    'class' => 'text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800',
                    'type' => 'submit',
                    'form' => 'main-edit-form',
                ]) ?>

                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contactMessage->id], [
                    'confirm' => __('Are you sure you want to delete this message?'),
                    'class' => 'text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900',
                ]) ?>
            </div>
        </div>
    </div>

    <?= $this->Form->create($contactMessage, [
        'url' => ['action' => 'changeStatus', $contactMessage->id],
        'id' => 'main-edit-form',
    ]) ?>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-3 items-stretch">
            <div class="xl:col-span-1">
                <div class="h-full p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold dark:text-white">Details</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Status</dt>
                            <dd>
                                <?= $this->Form->control('status', [
                                    'value' => $contactMessage->status,
                                    'type' => 'select',
                                    'label' => false,
                                    'options' => [
                                        'new' => 'New',
                                        'pending' => 'Pending',
                                        'replied' => 'Replied',
                                        'closed' => 'Closed',
                                    ],
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                                ]) ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?= h($contactMessage->category) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <a href="mailto:<?= h($contactMessage->email) ?>" class="text-primary-600 hover:underline dark:text-primary-500">
                                    <?= h($contactMessage->email) ?>
                                </a>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="xl:col-span-2 flex flex-col space-y-4">

                <?= $this->element('card', [
                    'title' => 'Message Body',
                    'body' => '<div class="p-4 bg-gray-50 rounded-lg border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                                   <p class="text-base font-normal text-gray-700 dark:text-gray-300 leading-relaxed">' . $this->Text->autoParagraph(h($contactMessage->message)) . '</p>
                               </div>'
                ]) ?>

                <?= $this->element('card', [
                    'title' => 'Notes',
                    'body' => $this->Form->control('notes', [
                        'type' => 'textarea',
                        'label' => false,
                        'placeholder' => 'Add staff notes here...',
                        'rows' => 4,
                        'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
                    ])
                ]) ?>

            </div>
        </div>

    <?= $this->Form->end() ?>
</div>
