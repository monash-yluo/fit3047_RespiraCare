<?php
/**
 * Blue Button Element
 * 
 * @var string $label Button label/text
 * @var string $url URL for link buttons (optional, if not provided renders as submit button)
 * @var array $options Additional HTML options (optional)
 */

$label = $label ?? 'Button';
$options = $options ?? [];
$url = $url ?? null;

if ($url) {
    // Render as link
    echo $this->Html->link(
        $label,
        $url,
        array_merge([
            'class' => 'py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:z-10 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-700 dark:bg-blue-600 dark:text-white dark:border-blue-600 dark:hover:text-white dark:hover:bg-blue-700 text-center'
        ], $options)
    );
} else {
    // Render as submit button
    ?>
    <button type="submit" <?php echo isset($options['class']) ? 'class="' . $options['class'] . '"' : 'class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"'; ?>>
        <?= $label ?>
    </button>
    <?php
}
?>
