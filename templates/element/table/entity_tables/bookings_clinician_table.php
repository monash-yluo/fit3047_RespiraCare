<?php
/**
 * @var iterable<\App\Model\Entity\Booking> $upcomingBookings
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
            Patient
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            Clinician
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            Date & Time
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            Status
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            Created
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <?= __('Actions') ?>
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

    <?php
    $filteredBookings = array_filter($upcomingBookings->toArray(), function ($booking) {
        return in_array($booking->status, ['pending', 'declined', 'confirmed']);
    });
    ?>

    <?php if (count($filteredBookings) === 0): ?>
        <?= $this->element('table/table_empty_state', [
            'title' => 'No upcoming appointments',
            'message' => 'You have no upcoming bookings scheduled.',
        ]) ?>
    <?php else: ?>
        <?php foreach ($filteredBookings as $booking): ?>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">
                    <?= ($booking->hasValue('patient') && $booking->patient && $booking->patient->hasValue('user') && $booking->patient->user) ? h($booking->patient->user->first_name . ' ' . $booking->patient->user->last_name) : '-' ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">
                    <?= ($booking->hasValue('clinician') && $booking->clinician && $booking->clinician->hasValue('user') && $booking->clinician->user) ? h($booking->clinician->user->first_name . ' ' . $booking->clinician->user->last_name) : '-' ?>
                </td>
                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        <?= $this->Time->format($booking->scheduled_date, 'dd MMM, YYYY') ?>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                        <?= $this->Time->format($booking->scheduled_date, 'HH:mm') ?>
                    </div>
                </td>
                <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$booking->status] ?? '' ?>">
                                <?= h($booking->status) ?>
                            </span>
                </td>
                <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        <?= $this->Time->format($booking->created, 'dd MMM, YYYY') ?>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                        <?= $this->Time->format($booking->created, 'HH:mm') ?>
                    </div>
                </td>
                <td class="p-4 space-x-2 whitespace-nowrap">
                    <?= $this->Html->link(
                        '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>',
                        ['action' => 'view', $booking->id],
                        ['escape' => false, 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 dark:bg-primary-600 dark:hover:bg-primary-700']
                    ) ?>
                    <?php if ($identity->role === 'patient'): ?> <!-- Only patients can delete their own pending bookings -->
                        <?= $this->Form->postLink(
                            '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                            ['action' => 'delete', $booking->id],
                            ['escape' => false, 'confirm' => __('Delete this booking?'), 'class' => 'inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800']
                        ) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
