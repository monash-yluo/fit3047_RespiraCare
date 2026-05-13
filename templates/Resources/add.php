<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
 * @var \App\Model\Entity\User $identity
 */

$this->setLayout($identity->role ?? 'default');
$this->assign('title', 'Add Resource');
?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />
<?php $this->end(); ?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Add New Resource',
        'description' => 'Create a new educational resource or link for the system.',
        'showBack' => true,
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
                            'placeholder' => 'Enter resource title',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 placeholder-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('url_link', [
                            'type' => 'url',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'URL Link'],
                            'placeholder' => 'https://...',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 placeholder-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
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
                                'active' => 'Active',
                                'draft' => 'Draft',
                                'archived' => 'Archived'
                            ],
                            'default' => 'active',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        ]) ?>
                    </div>

                    <div class="sm:col-span-2">
                        <?= $this->Form->control('content', [
                            'type' => 'textarea',
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'placeholder' => 'Enter resource content or description',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 placeholder-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 js-rich-text',
                            'rows' => 8,
                        ]) ?>
                    </div>

                    <div>
                        <?= $this->Form->control('published_date', [
                            'type' => 'date',
                            'empty' => true,
                            'default' => date('Y-m-d'),
                            'readonly' => true,
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
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
                    <button type="submit" class="temp-disable-button inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-colors">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Save Resource
                    </button>
                    <?= $this->Html->link(
                        'Cancel',
                        ['action' => 'index'],
                        ['class' => 'inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors']
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Underline,
        Link,
        List,
        BlockQuote,
        RemoveFormat,
        Code
    } from 'ckeditor5';

    document.querySelectorAll('.js-rich-text').forEach((element) => {
        ClassicEditor.create(element, {
            plugins: [
                Essentials,
                Paragraph,
                Bold,
                Italic,
                Underline,
                Link,
                List,
                BlockQuote,
                RemoveFormat,
                Code
            ],
            toolbar: [
                'undo', 'redo', '|',
                'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'blockQuote', '|',
                'removeFormat', 'code'
            ]
        }).catch((error) => {
            console.error(error);
        });
    });
</script>