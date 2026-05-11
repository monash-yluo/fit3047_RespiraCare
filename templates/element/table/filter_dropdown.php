<?php
/**
 *
 * @var string $paramName
 * @var array $options
 * @var string $label
 */
$paramName = $paramName ?? 'filter';
$options = $options ?? [];
$currentValue = $this->request->getQuery($paramName, '');
$target = $target ?? '.ajax-table-content';
?>

<div class="flex items-center space-x-2">
    <?php if (!empty($label)): ?>
        <label class="text-sm font-medium text-gray-700 dark:text-gray-300"><?= h($label) ?>:</label>
    <?php endif; ?>

    <select
        data-ajax-filter-select="true"
        data-filter-param="<?= h($paramName) ?>"
        data-target="<?= h($target) ?>"
        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
    >
        <?php foreach ($options as $value => $optionLabel): ?>
            <option value="<?= h($value) ?>" <?= (string)$currentValue === (string)$value ? 'selected' : '' ?>>
                <?= h($optionLabel) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
