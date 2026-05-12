<?php
/**
 * @var \App\View\AppView $this
 * @var \ContentBlocks\Model\Entity\ContentBlock $contentBlock
 */
$this->setLayout($identity->role);

$this->assign('title', 'Edit Content Block - Content Blocks');
?>

<style>
    .ck-editor__editable_inline {
        min-height: 25rem; /* CKEditor field minimal height */
    }
</style>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Edit Content Block',
        'description' => 'Update the content for this block.',
    ]) ?>

    <div class="mb-6">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                <?= $contentBlock->label ?>
            </h3>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                <?= $contentBlock->description ?>
            </p>

            <?= $this->Form->create($contentBlock, ['type' => 'file']) ?>

            <div class="mb-6">
                <?php
                if ($contentBlock->type === 'text') {
                    echo $this->Form->control('value', [
                        'type' => 'textarea',
                        'value' => html_entity_decode($contentBlock->value),
                        'label' => __('Content'),
                        'class' => 'block w-full min-h-[300px] px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        'templates' => [
                            'inputContainer' => '<div class="{{required}}">{{content}}</div>',
                            'label' => '<label{{attrs}} class="block text-sm font-medium text-gray-900 dark:text-white mb-2">{{text}}</label>',
                        ],
                    ]);
                } else if ($contentBlock->type === 'html') {
                    echo $this->Form->control('value', [
                        'type' => 'textarea',
                        'label' => __('HTML Content'),
                        'value' => $contentBlock->value,
                        'class' => 'block w-full min-h-[300px] px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 font-mono text-sm',
                        'templates' => [
                            'inputContainer' => '<div class="{{required}}">{{content}}</div>',
                            'label' => '<label{{attrs}} class="block text-sm font-medium text-gray-900 dark:text-white mb-2">{{text}}</label>',
                        ],
                    ]);
                } else if ($contentBlock->type === 'image') {

                    if ($contentBlock->value) {
                        ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2"><?= __('Current Image') ?></label>
                            <div class="w-auto rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                <?= $this->Html->image($contentBlock->value, [
                                    'class' => 'w-full h-full object-cover',
                                ]) ?>
                            </div>
                        </div>
                        <?php
                    }

                    echo $this->Form->control('value', [
                        'type' => 'file',
                        'accept' => 'image/*',
                        'label' => __('Upload New Image'),
                        'class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        'templates' => [
                            'inputContainer' => '<div class="{{required}}">{{content}}</div>',
                            'label' => '<label{{attrs}} class="block text-sm font-medium text-gray-900 dark:text-white mb-2">{{text}}</label>',
                        ],
                    ]);
                }

                ?>
            </div>

            <div class="flex gap-3">
                <?= $this->Form->button(__('Save'), [
                    'class' => 'temp-disable-button inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-colors',
                ]) ?>
                <?= $this->Html->link(
                    __('Cancel'),
                    ['action' => 'index'],
                    [
                        'class' => 'temp-disable-button inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-colors',
                    ]
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>

</div>

