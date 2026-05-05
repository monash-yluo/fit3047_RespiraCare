<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\ContentBlocks\Model\Entity\ContentBlock> $contentBlocksGrouped
 */
$this->setLayout($identity->role);

$this->assign('title', 'Content Blocks');

$slugify = function ($text) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
}

?>
<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Content Blocks',
        'description' => 'Manage and edit content blocks used across the application.',
    ]) ?>

    <div class="mb-6">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="flex flex-wrap gap-2">
                <?php foreach (array_keys($contentBlocksGrouped) as $parent) { ?>
                    <a href="#<?= $slugify($parent) ?>" class="px-3 py-1.5 text-sm font-medium text-primary-700 bg-primary-100 rounded-lg hover:bg-primary-200 dark:bg-primary-900 dark:text-primary-300 dark:hover:bg-primary-800 transition-colors">
                        <?= $parent ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php foreach ($contentBlocksGrouped as $parent => $contentBlocks) { ?>

        <div class="mb-8">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <a href="#<?= $slugify($parent) ?>" id="<?= $slugify($parent) ?>" class="hover:text-primary-700 dark:hover:text-primary-400 transition-colors">
                    <?= $parent ?>
                </a>
                <a href="#<?= $slugify($parent) ?>" class="ml-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">#</a>
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($contentBlocks as $contentBlock) { ?>
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 hover:shadow-md dark:hover:shadow-lg transition-shadow flex flex-col">
                        <div class="flex-1 mb-4">
                            <h5 class="text-base font-semibold text-gray-900 dark:text-white mb-2">
                                <?= $contentBlock['label'] ?>
                            </h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                <?= $contentBlock['description'] ?>
                            </p>
                            <div class="text-xs bg-gray-50 dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 max-h-[100px] overflow-y-auto">
                                <?php if ($contentBlock['type'] === 'image'): ?>

                                    <?php if (!empty($contentBlock['value'])): ?>
                                        <div class="w-24 rounded overflow-hidden dark:bg-gray-800 border border-gray-200 dark:border-gray-600">
                                            <?= $this->Html->image($contentBlock['value'], [
                                                'class' => 'w-full h-full object-cover',
                                                'alt' => h($contentBlock['label']),
                                            ]) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-900 dark:text-gray-100 text-sm font-bold">
                                            No image now
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <div class="text-gray-700 dark:text-gray-300 font-mono whitespace-normal break-words">
                                        <?= h(substr($contentBlock['value'], 0, 200)) ?>
                                        <?php if (strlen($contentBlock['value']) > 200): ?>
                                            ...
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <?= $this->Html->link(
                                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>',
                                ['action' => 'edit', $contentBlock->id],
                                [
                                    'escape' => false,
                                    'title' => __('Edit'),
                                    'class' => 'inline-flex items-center justify-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800 transition-colors',
                                ],
                            ) ?>
                            <?php if (!empty($contentBlock['previous_value'])) { ?>
                                <?= $this->Form->postLink(
                                    '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3M3.22302 14C4.13247 18.008 7.71683 21 12 21c4.9706 0 9-4.0294 9-9 0-4.97056-4.0294-9-9-9-3.72916 0-6.92858 2.26806-8.29409 5.5M7 9H3V5"/></svg>',
                                    ['action' => 'restore', $contentBlock->id],
                                    [
                                        'escape' => false,
                                        'title' => __('Restore Previous Version'),
                                        'confirm' => __("Are you sure you want to restore the previous version for this item?\n{0}/{1}\nNote: You cannot cancel this action!", $contentBlock['parent'], $contentBlock['slug']),
                                        'class' => 'inline-flex items-center justify-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-500 dark:hover:bg-primary-600 dark:focus:ring-primary-800 transition-colors',
                                    ],
                                ) ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php } ?>

</div>