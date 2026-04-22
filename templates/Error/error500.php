<?php
/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var string $url
 * @var \Error $error
 */
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->setLayout('error');

if (Configure::read('debug')) :
    $this->setLayout('dev_error');

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.php');

    $this->start('file');
    ?>
    <?php if (isset($error) && $error instanceof Error) : ?>
    <?php $file = $error->getFile() ?>
    <?php $line = $error->getLine() ?>
    <strong>Error in: </strong>
    <?= $this->Html->link(sprintf('%s, line %s', Debugger::trimPath($file), $line), Debugger::editorUrl($file, $line)); ?>
<?php endif; ?>
    <?php
    echo $this->element('auto_table_warning');
    $this->end();
endif;
?>

<div class="flex flex-col justify-center items-center px-6 mx-auto h-screen xl:px-0 dark:bg-gray-900">
    <div class="block md:max-w-lg">
        <?= $this->Html->image('500.svg', [
            'alt' => 'Internal Server Error',
            'class' => 'w-full mb-6'
        ]) ?>
    </div>
    <div class="text-center xl:max-w-4xl">
        <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">
            <?= __d('cake', 'Something has gone seriously wrong') ?>
        </h1>
        <p class="mb-5 text-base font-normal text-gray-500 md:text-lg dark:text-gray-400">
            <?= __d('cake', "It's always time for a coffee break. We should be back by the time you finish your coffee.") ?>
        </p>

        <?php if (Configure::read('debug')): ?>
            <p class="mb-5 font-mono text-xs text-red-500 bg-red-50 dark:bg-red-900/30 p-2 rounded">
                <strong>Debug Message:</strong> <?= h($message) ?>
            </p>
        <?php endif; ?>

        <?= $this->Html->link(
            '<svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' . __('Go back home'),
            '/',
            [
                'class' => 'text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                'escape' => false
            ]
        ) ?>
    </div>
</div>
