<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>

    <?= $this->Html->css('admin-app') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

<?= $this->fetch('navbar') ?>

<div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

    <?= $this->fetch('sidebar') ?>

    <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
        <main>
            <?php if ($this->getRequest()->getSession()->check('Flash.flash')) : ?>
                <div class="px-4 pt-4">
                    <?= $this->Flash->render() ?>
                </div>
            <?php endif; ?>

            <?= $this->fetch('content') ?>
        </main>

        <?= $this->element('admin/footer') ?>
    </div>

</div>

<!-- Preloader -->
<div id="preloader"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<?= $this->Html->script([
    'dark-mode.js',
    'sidebar.js',
]) ?>

<?= $this->fetch('script') ?>
</body>
</html>
