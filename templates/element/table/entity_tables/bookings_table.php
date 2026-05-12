<?php
/**
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */

$statusColors = [
    'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
    'declined' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
];
?>
<table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 border border-b-0 border-gray-200 dark:border-gray-700">
    <thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('id', 'ID') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('patient_id', 'Patient') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('clinician_id', 'Clinician') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('scheduled_date', 'Scheduled Date') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= $this->Paginator->sort('status', 'Status') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden md:table-cell">
            <?= $this->Paginator->sort('created', 'Created') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 hidden lg:table-cell">
            <?= $this->Paginator->sort('modified', 'Modified') ?>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= __('Actions') ?>
        </th>
    </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    <?php if ($bookings->isEmpty()) : ?>
        <?= $this->element('table/table_empty_state', [
            'title' => 'No bookings found',
            'message' => 'There are currently no bookings in the system.',
        ]) ?>
    <?php else : ?>
        <?php foreach ($bookings as $booking) : ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <?= $this->Number->format($booking->id) ?>
                </td>

                <td class="p-4 text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
                    <?= $booking->hasValue('patient') ? $this->Html->link(h($booking->patient->user->full_name), ['controller' => 'Users', 'action' => 'view', $booking->patient->id]) : '-' ?>
                </td>

                <td class="p-4 text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
                    <?= $booking->hasValue('clinician') ? $this->Html->link(h($booking->clinician->user->full_name), ['controller' => 'Users', 'action' => 'view', $booking->clinician->id]) : '-' ?>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        <?= $this->Time->format($booking->scheduled_date, 'dd MMM, YYYY') ?>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                        <?= $this->Time->format($booking->scheduled_date, 'HH:mm') ?>
                    </div>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded <?= $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300' ?>">
                            <?= h($booking->status) ?>
                        </span>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white hidden md:table-cell">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        <?= $this->Time->format($booking->created, 'dd MMM, YYYY') ?>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                        <?= $this->Time->format($booking->created, 'HH:mm') ?>
                    </div>
                </td>

                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white hidden lg:table-cell">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        <?= $this->Time->format($booking->modified, 'dd MMM, YYYY') ?>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                        <?= $this->Time->format($booking->modified, 'HH:mm') ?>
                    </div>
                </td>

                <td class="p-4 flex flex-col md:flex-row gap-2 items-center">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'view', $booking->id],
                        [
                            'escape' => false,
                            'title' => __('View'),
                            'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
                        ],
                    ) ?>

                    <?= $this->Form->postLink(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'delete', $booking->id],
                        [
                            'escape' => false,
                            'title' => __('Delete'),
                            'confirm' => __('Are you sure you want to delete booking # {0}?', $booking->id),
                            'class' => 'temp-disable-button inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900',
                        ],
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
