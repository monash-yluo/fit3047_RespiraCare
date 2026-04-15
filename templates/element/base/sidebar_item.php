<?php
/**
 * @var string $link The URL for the navigation item.
 * @var string $svg The raw SVG icon markup.
 * @var string $title The text to display next to the icon.
 */
?>

<li>
    <a href="<?= $link ?>"
       class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group
       dark:text-gray-200 dark:hover:bg-gray-700">

        <?= $svg ?>

        <span class="ml-3"><?= h($title) ?></span>
    </a>
</li>
