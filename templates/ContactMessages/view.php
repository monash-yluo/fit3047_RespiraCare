<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactMessage $contactMessage
 */

$this->setLayout('admin');
$this->assign('title', 'Contact Messages');
//$this->Breadcrumbs->add('Contact Messages', ['action' => 'index']);
//$this->Breadcrumbs->add('Message Details');

/**
 * THIS HEAVILY REQUIRED REFINEMENT, THIS IS INITIAL TEMPLATE.
 */
?>

<div class="px-4 pt-6">
    <div class="mb-4">
        <?php /* $this->element('Admin/breadcrumbs') */ ?>
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                Message from <?= h($contactMessage->first_name . ' ' . $contactMessage->last_name) ?>
            </h1>
            <div class="flex space-x-2">
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contactMessage->id], [
                    'class' => 'text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800'
                ]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contactMessage->id], [
                    'confirm' => __('Are you sure you want to delete this message?'),
                    'class' => 'text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900'
                ]) ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Details</h3>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                             <span class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300 uppercase">
                                <?= h($contactMessage->status) ?>
                             </span>
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
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Received On</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            <?= $contactMessage->created->format('F d, Y \a\t h:i A') ?>
                        </dd>
                    </div>
                    <?php if ($contactMessage->hasValue('patient')): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Linked Patient</dt>
                            <dd class="mt-1">
                                <?= $this->Html->link(__('View Patient Profile'),
                                    ['controller' => 'Patients', 'action' => 'view', $contactMessage->patient->id],
                                    ['class' => 'text-sm font-medium text-primary-600 hover:underline dark:text-primary-500']
                                ) ?>
                            </dd>
                        </div>
                    <?php endif; ?>
                </dl>
            </div>
        </div>

        <div class="xl:col-span-2 flex flex-col">
            <div class="flex-1 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Message Body</h3>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 dark:bg-gray-700 dark:border-gray-600">
                    <p class="text-base font-normal text-gray-700 dark:text-gray-300 leading-relaxed">
                        <?= $this->Text->autoParagraph(h($contactMessage->message)); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
