<?php
/**
 * @var iterable<\App\Model\Entity\Reminder> $reminders
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
            <?= $this->Paginator->sort('receiver_id', 'Receiver') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('sender_id', 'Sender') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 ">
            <?= $this->Paginator->sort('message', 'Message') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden lg:table-cell">
            <?= $this->Paginator->sort('modified', 'Time') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= __('Actions') ?>
        </th>
    </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    <?php if ($reminders->items()->isEmpty()) : ?>
        <?= $this->element('table/table_empty_state', [
            'title' => 'No reminders found',
            'message' => 'Automated reminders have not been scheduled yet.',
        ]) ?>
    <?php else : ?>
        <?php foreach ($reminders as $reminder) : ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-<?= $reminder->id ?>" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-<?= $reminder->id ?>" class="sr-only">checkbox</label>
                    </div>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?= $this->Number->format($reminder->id) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                    <?php if ($reminder->hasValue('receiver')) : ?>
                        <?php if ($identity->role === 'patient') : ?>
                            <?= h($reminder->receiver->full_name) ?>
                        <?php else : ?>
                            <?= $this->Html->link(
                                h($reminder->receiver->full_name),
                                ['controller' => 'Users', 'action' => 'view', $reminder->receiver->id],
                                ['class' => 'text-primary-600 hover:underline dark:text-primary-500'],
                            ) ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <span class="text-gray-400 italic">No Receiver</span>
                    <?php endif; ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                    <?php if ($reminder->hasValue('sender')) : ?>
                        <?php if ($identity->role === 'patient') : ?>
                            <?= h($reminder->sender->full_name) ?>
                        <?php else : ?>
                            <?= $this->Html->link(
                                h($reminder->sender->full_name),
                                ['controller' => 'Users', 'action' => 'view', $reminder->sender->id],
                                ['class' => 'text-primary-600 hover:underline dark:text-primary-500'],
                            ) ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <span class="text-gray-400 italic">No Sender</span>
                    <?php endif; ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[100px] md:max-w-[300px]">
                    <?= h($reminder->message) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white hidden lg:table-cell">
                    <?= $this->Time->format($reminder->modified, 'MMM d, yyyy') ?>
                </td>

                <td class="p-4 flex flex-col md:flex-row gap-2 items-center">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'view', $reminder->id],
                        [
                            'escape' => false,
                            'title' => __('View'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                        ],
                    ) ?>

                    <?= $this->Form->postLink(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'delete', $reminder->id],
                        [
                            'escape' => false,
                            'title' => __('Delete'),
                            'confirm' => __('Are you sure you want to delete reminder #{0}?', $reminder->id),
                            'class' => 'temp-disable-button inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900',
                        ],
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
