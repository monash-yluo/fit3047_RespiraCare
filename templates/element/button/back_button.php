<?php
/**
 * Advanced Session-Based Back Button
 * Detects A -> B -> A loops and leapfrogs backward.
 *
 * @var string $label Button label/text (optional, default: 'Back')
 * @var string $class Custom CSS classes (optional)
 * @var array|string|null $url Hard override URL for Edit/Add pages (optional)
 */

$label = $label ?? 'Back';
$class = 'text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 ' . ($class ?? '');

// 1. Check for Hard Override (e.g., from an Edit/Add template)
if (!empty($url)) {
    echo $this->Html->link(__($label), $url, ['class' => $class]);
    return;
}
?>

<?= $this->Html->link(__($label), '/go-back', ['class' => $class]); ?>
