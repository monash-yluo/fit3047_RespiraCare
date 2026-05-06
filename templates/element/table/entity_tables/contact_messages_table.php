<?php
/**
 * @var iterable<\App\Model\Entity\contactMessage> $contactMessages
 */

/**
 * Status Badge Logic
 */
$getStatusClass = function ($status) {
    return match (strtolower($status)) {
        'new',
        'pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'replied', 'resolved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    };
};

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
            <?= $this->Paginator->sort('first_name', 'Sender') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('email', 'Email') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden lg:table-cell">
            <?= $this->Paginator->sort('category', 'Category') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('status', 'Status') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden xl:table-cell">
            <?= $this->Paginator->sort('created', 'Received') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= __('Actions') ?>
        </th>
    </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    <?php if ($contactMessages->items()->isEmpty()) : ?>
        <?= $this->element('table/table_empty_state', [
            'title' => 'No messages found',
            'message' => 'Incoming inquiries will appear here.',
        ]) ?>
    <?php else : ?>
        <?php foreach ($contactMessages as $contactMessage) : ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="w-4 p-4">
                    <input id="checkbox-<?= $contactMessage->id ?>" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?= $this->Number->format($contactMessage->id) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                    <?= h($contactMessage->first_name . ' ' . $contactMessage->last_name) ?>
                    <?php if ($contactMessage->hasValue('patient')) : ?>
                        <span class="block text-xs text-primary-600 dark:text-primary-400 italic">Patient ID: <?= $contactMessage->patient->id ?></span>
                    <?php endif; ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]">
                    <?= h($contactMessage->email) ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white hidden lg:table-cell">
                    <?= h($contactMessage->category) ?>
                </td>

                <td class="p-4 text-sm">
                            <span class="px-2.5 py-0.5 rounded text-xs font-medium border <?= $getStatusClass($contactMessage->status) ?>">
                                <?= h($contactMessage->status) ?>
                            </span>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white hidden xl:table-cell">
                    <?= $this->Time->format($contactMessage->created, 'MMM d, yyyy') ?>
                </td>

                <td class="p-4 space-x-2 whitespace-nowrap">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'view', $contactMessage->id],
                        [
                            'escape' => false,
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700',
                        ],
                    ) ?>

                    <?= $this->Form->postLink(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'delete', $contactMessage->id],
                        [
                            'escape' => false,
                            'confirm' => __('Delete message from {0}?', $contactMessage->first_name),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800',
                        ],
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
