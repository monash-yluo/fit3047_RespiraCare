<div class="<?= ($class ?? '') . 'p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800' ?>">

    <?php if (!empty($title)) : ?>
        <h3 class="mb-4 text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">
            <?= h($title) ?>
        </h3>
    <?php endif; ?>

    <?php if (!empty($body)) : ?>
        <?= $body ?>
    <?php else : ?>
        <?= $this->fetch('content') ?>
    <?php endif; ?>
</div>
