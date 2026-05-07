<?php
/**
 * Red Button Element (for delete/danger operations)
 */
$label = $label ?? 'Delete';
$url = $url ?? null;
$confirm = $confirm ?? __('Are you sure?');
$options = $options ?? [];
$iconType = $iconType ?? null;

// Icon definitions
$icons = [
    'edit' => '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
    'delete' => '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
    'add' => '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>',
    'view' => '<svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>'
];

$icon = $icons[$iconType] ?? '';
$buttonContent = $icon . h($label);
$defaultClass = 'inline-flex items-center justify-center py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:z-10 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 dark:bg-red-600 dark:text-white dark:border-red-600 dark:hover:text-white dark:hover:bg-red-700';

if ($url) {
    // Render as postLink for delete operations
    echo $this->Form->postLink(
        $buttonContent,
        $url,
        array_merge([
            'escape' => false,
            'confirm' => $confirm,
            'class' => $defaultClass
        ], $options)
    );
} else {
    // Render as regular button
    echo $this->Form->button($buttonContent, array_merge([
        'type' => 'button',
        'escapeTitle' => false,
        'class' => $defaultClass,
        'onclick' => 'setTimeout(() => { this.disabled=true; }, 100);',
    ], $options));
}
