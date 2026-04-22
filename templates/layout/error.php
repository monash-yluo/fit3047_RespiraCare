<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // Inline script to prevent theme flickering
        if (localStorage.getItem('color-theme') === 'dark' || (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('admin-app') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

<div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 dark:bg-gray-900">
    <main>
        <?= $this->fetch('content') ?>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<?= $this->Html->script(['dark-mode.js']) ?>
<?= $this->fetch('script') ?>
</body>
</html>
