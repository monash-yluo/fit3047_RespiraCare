<?php
/**
 * Table Empty State Element
 *
 * @var int $colspan The number of columns the empty state should span across.
 * @var string $title The main heading for the empty state.
 * @var string $message The sub-text explaining the empty state.
 */
$title = $title ?? __('No records found');
$message = $message ?? __('There is no data to display.');
?>
<tr>
    <td colspan="10" class="p-10 text-center text-gray-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-800">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 .586 13H4"></path>
        </svg>
        <p class="text-lg font-medium text-gray-900 dark:text-white"><?= h($title) ?></p>
        <p class="text-sm"><?= h($message) ?></p>
    </td>
</tr>
