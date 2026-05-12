<?php
$paramName = $paramName ?? 'filter';
$options = $options ?? [];
$class = $class ?? '';
$target = $target ?? null;

$currentValue = $this->request->getQuery($paramName);
?>

<div class="mb-4 inline-flex flex-col sm:flex-row sm:items-center sm:justify-start space-y-3 sm:space-y-0 gap-2 p-1 bg-gray-100 rounded-xl dark:bg-gray-700 <?= $class ?>" role="group">
    <?php foreach ($options as $value => $label) : ?>
        <?php
        $isActive = (string)$currentValue === (string)$value;
        ?>
        <button type="button"
                data-ajax-filter="true"
                data-filter-param="<?= h($paramName) ?>"
                data-filter-value="<?= h($value) ?>"
                data-target="<?= h($target) ?>"
                class="filter-btn px-6 py-2 text-sm font-medium rounded-xl transition-all duration-200 <?= $isActive ? 'active-filter bg-white text-gray-900 shadow dark:bg-gray-800 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-600' ?>">
            <?= h($label) ?>
        </button>
    <?php endforeach; ?>
</div>
