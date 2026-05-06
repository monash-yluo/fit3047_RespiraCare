<?php
/**
 * @var iterable<\App\Model\Entity\clinician> $clinicians
 */
?>
<table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 border border-b-0 border-gray-200 dark:border-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th scope="col" class="p-4 w-4">
            <div class="flex items-center">
                <input id="checkbox-all" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox-all" class="sr-only">checkbox</label>
            </div>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('id', 'ID') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('user_id', 'Name') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('phone', 'Phone') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden md:table-cell">
            <?= $this->Paginator->sort('created', 'Created') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden md:table-cell">
            <?= $this->Paginator->sort('modified', 'Modified') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= __('Actions') ?>
        </th>
    </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    <?php if ($clinicians->items()->isEmpty()) : ?>
        <?= $this->element('table/table_empty_state', [
            'title' => 'No clinicians found',
            'message' => 'There are currently no clinician profiles in the system.',
        ]) ?>
    <?php else : ?>
        <?php foreach ($clinicians as $clinician) : ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-<?= $clinician->id ?>" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-<?= $clinician->id ?>" class="sr-only">checkbox</label>
                    </div>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?= $this->Number->format($clinician->id) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?php if ($clinician->hasValue('user')) : ?>
                        <?= $this->Html->link(
                            h($clinician->user->first_name . ' ' . $clinician->user->last_name),
                            ['controller' => 'Users', 'action' => 'view', $clinician->user->id],
                            ['class' => 'text-primary-600 hover:underline dark:text-primary-500'],
                        ) ?>
                    <?php else : ?>
                        <span class="text-gray-400 italic">No User Assigned</span>
                    <?php endif; ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?php if ($clinician->hasValue('user')) : ?>
                        <?= h($clinician->user->phone) ?>
                    <?php else : ?>
                        <span class="text-gray-400 italic">-</span>
                    <?php endif; ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white hidden md:table-cell">
                    <?= $this->Time->format($clinician->created, 'MMM d, yyyy') ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white hidden md:table-cell">
                    <?= $this->Time->format($clinician->modified, 'MMM d, yyyy') ?>
                </td>

                <td class="p-4 space-x-2 whitespace-nowrap">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['controller' => 'Users', 'action' => 'view', $clinician->user->id],
                        [
                            'escape' => false,
                            'title' => __('View'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                        ],
                    ) ?>

                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>',
                        ['controller' => 'Users', 'action' => 'edit', $clinician->user->id],
                        [
                            'escape' => false,
                            'title' => __('Edit'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800',
                        ],
                    ) ?>

                    <?= $this->Form->postLink(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                        ['controller' => 'Users', 'action' => 'delete', $clinician->user->id],
                        [
                            'escape' => false,
                            'title' => __('Delete'),
                            'confirm' => __('Are you sure you want to delete clinician profile #{0}?', $clinician->id),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900',
                        ],
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
