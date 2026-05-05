<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
 * @var \App\Model\Entity\User $identity
 */

$this->setLayout($identity->role ?? 'default');
$this->assign('title', 'Edit Resource');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Edit Resource',
        'description' => 'Modify the details of this educational resource.',
        'showBack' => true,
        'backUrl' => ['action' => 'index']
    ]) ?>

    <?= $this->Form->create($resource) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <!-- Main Form Column -->
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Resource Information</h3>

                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <?= $this->Form->control('title', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('url_link', [
                            'type' => 'url',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'URL Link'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('type', [
                            'type' => 'select',
                            'options' => [
                                'Article' => 'Article',
                                'Video' => 'Video',
                                'PDF Document' => 'PDF Document',
                                'External Link' => 'External Link',
                                'Guide' => 'Guide'
                            ],
                            'empty' => '-- Select Type --',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('status', [
                            'type' => 'select',
                            'options' => [
                                'Active' => 'Active',
                                'Draft' => 'Draft',
                                'Archived' => 'Archived'
                            ],
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('published_date', [
                            'type' => 'date',
                            'empty' => true,
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions Column -->
        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Actions</h3>
                <div class="flex flex-col space-y-4">
                    <button type="submit" class="inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-colors">
                        Update Resource
                    </button>

                    <?= $this->Form->postLink(
                        '<svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>' . __('Delete Resource'),
                        ['action' => 'delete', $resource->id],
                        [
                            'escape' => false,
                            'confirm' => __('Are you sure you want to delete the resource: {0}?', $resource->title),
                            'class' => 'inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 transition-colors',
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
