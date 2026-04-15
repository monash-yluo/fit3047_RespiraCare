<?php

$navItems = [
    [
        'title' => 'Dashboard',
        'link' => $this->Url->build(['controller' => 'ClinicianPortals', 'action' => 'dashboard']),
        'svg' => '<svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>',
    ],
    [
        'title' => 'Resources',
        'link' => $this->Url->build(['controller' => 'Resources', 'action' => 'index']),
        'svg' => '<svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/></svg>',
    ],
    [
        'title' => 'Reminders',
        'link' => $this->Url->build(['controller' => 'Reminders', 'action' => 'index']),
        'svg' => '<svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>',
    ],
];
?>

<?php $this->start('sidebar_items'); ?>

    <?php foreach ($navItems as $item) : ?>
        <?= $this->element('base/sidebar_item', $item) ?>
    <?php endforeach; ?>

<?php $this->end(); ?>
<?= $this->element('base/sidebar');
