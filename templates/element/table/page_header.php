<?php
/**
 * Page Header Element with Action Button
 *
 * @var string $title The main H1 title.
 * @var string $description The subtitle text.
 * @var string|array $actionUrl The URL for the button.
 * @var string $actionLabel The text on the button.
 */
?>
<div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"><?= h($title) ?></h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?= h($description) ?></p>
    </div>

    <?php if (!empty($actionUrl) && !empty($actionLabel)): ?>
        <div>
            <?= $this->Html->link(
                $actionLabel,
                $actionUrl,
                ['class' => 'inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700 transition-colors']
            ) ?>
        </div>
    <?php endif; ?>
</div>
