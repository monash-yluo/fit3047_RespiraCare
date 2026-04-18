<?php
/**
 * Red Button Element (for delete/danger operations)
 * 
 * @var string $label Button label/text
 * @var string $url URL for postLink (required for delete operations)
 * @var string $confirm Confirmation message (optional)
 * @var array $options Additional HTML options (optional)
 */

$label = $label ?? 'Delete';
$url = $url ?? null;
$confirm = $confirm ?? __('Are you sure?');
$options = $options ?? [];

if ($url) {
    // Render as postLink for delete operations
    echo $this->Form->postLink(
        $label,
        $url,
        array_merge([
            'confirm' => $confirm,
            'class' => 'py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:z-10 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 dark:bg-red-600 dark:text-white dark:border-red-600 dark:hover:text-white dark:hover:bg-red-700 text-center'
        ], $options)
    );
} else {
    // Render as regular button
    ?>
    <button type="button" <?php echo isset($options['class']) ? 'class="' . $options['class'] . '"' : 'class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:z-10 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 dark:bg-red-600 dark:text-white dark:border-red-600 dark:hover:text-white dark:hover:bg-red-700"'; ?>>
        <?= $label ?>
    </button>
    <?php
}
?>
