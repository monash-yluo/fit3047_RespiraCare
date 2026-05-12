<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
 * @var \App\Model\Entity\User $identity
 */

$this->setLayout($identity->role ?? 'default');
$this->assign('title', 'View Resource');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Resource Details',
        'description' => 'Viewing detailed information for this educational resource.',
        'showBack' => true,
        'backUrl' => ['action' => 'index']
    ]) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <!-- Main Content Details -->
        <?php if($identity->role === 'admin' || $identity->role === 'clinician'): ?>
        <div class="xl:col-span-2">
        <?php else: ?>
        <div class="xl:col-span-3">
        <?php endif; ?>
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold dark:text-white"><?= h($resource->title) ?></h3>

                    <?php
                    $statusClass = strtolower($resource->status) === 'active' || strtolower($resource->status) === 'published'
                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                        : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                    ?>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded <?= $statusClass ?>">
                        <?= h($resource->status) ?>
                    </span>
                </div>

                <div class="flow-root">
                    <?php if ($resource->type === 'Video' && !empty($resource->url_link)) : ?>
                        <div class="video-container p-5">
                            <iframe
                                width="100%"
                                height="500"
                                src=<?= $resource->url_link; ?>
                                title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                            class="rounded-lg shadow-sm">
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <dl class="-my-3 divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-900 dark:text-white">
                        <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Resource ID</dt>
                            <dd class="sm:col-span-2">#<?= $this->Number->format($resource->id) ?></dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Type</dt>
                            <dd class="sm:col-span-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    <?= h($resource->type) ?>
                                </span>
                            </dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">URL Link</dt>
                            <dd class="sm:col-span-2">
                                <?php if (!empty($resource->url_link)): ?>
                                    <a href="<?= h($resource->url_link) ?>" target="_blank" rel="noopener noreferrer" <?= $resource->type == "PDF" ? "download" : null ?> class="text-primary-600 hover:underline dark:text-primary-500 break-all flex items-center">
                                        <?= h($resource->url_link) ?>
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                                    </a>
                                <?php else: ?>
                                    <span class="italic text-gray-400">No URL provided</span>
                                <?php endif; ?>
                            </dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Published Date</dt>
                            <dd class="sm:col-span-2">
                                <?= $resource->published_date ? $this->Time->format($resource->published_date, 'MMMM d, yyyy') : '<span class="text-gray-400 italic">Not set</span>' ?>
                            </dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">System Created</dt>
                            <dd class="sm:col-span-2"><?= $this->Time->format($resource->created, 'MMM d, yyyy HH:mm') ?></dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Last Modified</dt>
                            <dd class="sm:col-span-2"><?= $this->Time->format($resource->modified, 'MMM d, yyyy HH:mm') ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions Column -->
        <?php if($identity->role === 'admin' || $identity->role === 'clinician'): ?>
        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Actions</h3>
                <div class="flex flex-col space-y-4">
                    <?= $this->Html->link(
                        '<svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>' . __('Edit Resource'),
                        ['action' => 'edit', $resource->id],
                        ['escape' => false, 'class' => 'inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-colors']
                    ) ?>

                    <?= $this->Form->postLink(
                        '<svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>' . __('Delete Resource'),
                        ['action' => 'delete', $resource->id],
                        [
                            'escape' => false,
                            'confirm' => __('Are you sure you want to delete the resource: {0}?', $resource->title),
                            'class' => 'temp-disable-button inline-flex items-center justify-center w-full px-5 py-2.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 transition-colors',
                        ]
                    ) ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
