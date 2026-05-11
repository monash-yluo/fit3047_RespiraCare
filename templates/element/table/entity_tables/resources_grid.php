<?php

/**
 * @var iterable<\App\Model\Entity\Resource> $resources
 */

?>


<!-- Grid Container -->
<?php if (count($resources) === 0) : ?>
    <div class="py-8 text-center">
        <?= $this->element('table/table_empty_state', [
            'colspan' => 1,
            'title' => 'No resources found',
            'message' => 'There are currently no resource records in the system.',
        ]) ?>
    </div>
<?php else : ?>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
        <?php foreach ($resources as $resource) : ?>
            <!-- Individual Resource Card -->
            <div class="flex flex-col bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 hover:shadow-md transition-shadow duration-200">

                <!-- Card Body (flex-1 pushes footer to the bottom) -->
                <div class="p-5 flex-1 flex flex-col">

                    <!-- Header & Badges -->
                    <div class="flex justify-between items-start mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                <?= h($resource->type) ?>
                            </span>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-mono">
                                #<?= $this->Number->format($resource->id) ?>
                            </span>
                    </div>

                    <h3 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white line-clamp-2 mb-3" title="<?= h($resource->title) ?>">
                        <?= h($resource->title) ?>
                    </h3>

                    <!-- Status Badge -->
                    <div class="mb-4">
                        <?php
                        $statusClass = strtolower($resource->status) === 'active' || strtolower($resource->status) === 'published'
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                        ?>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded <?= $statusClass ?>">
                                <?= h($resource->status) ?>
                            </span>
                    </div>

                    <!-- Details (Dates & Links) -->
                    <div class="mt-auto space-y-2 text-sm text-gray-500 dark:text-gray-400">
                        <!-- Published Date -->
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            <?= $resource->published_date ? $this->Time->format($resource->published_date, 'MMM d, yyyy') : 'No date' ?>
                        </div>

                        <!-- URL Link -->
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path></svg>
                            <?php if (!empty($resource->url_link)) : ?>
                                <a href="<?= h($resource->url_link) ?>" target="_blank" class="text-primary-600 hover:underline dark:text-primary-400 truncate w-48">
                                    <?= h($resource->url_link) ?>
                                </a>
                            <?php else : ?>
                                <span class="italic text-gray-400">No URL</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 rounded-b-lg flex justify-end space-x-2">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'view', $resource->id],
                        [
                            'escape' => false,
                            'title' => __('View'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                        ],
                    ) ?>
                    <?php if($identity->role === 'admin' || $identity->role === 'clinician'): ?>
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>',
                        ['action' => 'edit', $resource->id],
                        [
                            'escape' => false,
                            'title' => __('Edit'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800',
                        ],
                    ) ?>

                    <?= $this->Form->postLink(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'delete', $resource->id],
                        [
                            'escape' => false,
                            'title' => __('Delete'),
                            'confirm' => __('Are you sure you want to delete the resource: {0}?', $resource->title),
                            'class' => 'temp-disable-button inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900',
                        ],
                    ) ?>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
