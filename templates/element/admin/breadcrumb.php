<?php

$breadcrumbs = $breadcrumbs ?? [];

?>

<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
        <?php foreach ($breadcrumbs as $index => $crumb) : ?>
            <?php
            $isFirst = ($index === 0);
            $isLast = ($index === array_key_last($breadcrumbs));
            ?>

            <?php if ($isFirst) : ?>
                <li class="inline-flex items-center">
                    <?= $this->Html->link(
                        h($crumb['title']),
                        $crumb['url'],
                        [
                            'escape' => false,
                            'class' => 'inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white'
                        ],
                    ) ?>
                </li>
            <?php elseif (!$isLast) : ?>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <?= $this->Html->link(
                            h($crumb['title']),
                            $crumb['url'],
                            ['class' => 'ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white'],
                        ) ?>
                    </div>
                </li>
            <?php else : ?>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page"><?= h($crumb['title']) ?></span>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
