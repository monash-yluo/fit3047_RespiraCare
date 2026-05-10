<?php
/**
 * Patient Portal Dashboard
 * @var \Cake\View\View $this
 * @var \Cake\Datasource\EntityInterface $identity
 * @var int $completedCount
 * @var array $timeSlots
 */

$this->setLayout($identity->role);
$this->assign('title', 'Dashboard Overview');

// Total Timeline
$totalRequired = 4;

// Display Fields
$dailySchedule = [
    'morning' => ['title' => 'Morning Reading', 'time' => '8:00 AM - 11:59 AM', 'desc' => 'Before breakfast'],
    'midday' => ['title' => 'Midday Reading', 'time' => '12:00 PM - 3:59 PM', 'desc' => 'Before lunch'],
    'afternoon' => ['title' => 'Afternoon Reading', 'time' => '4:00 PM - 7:59 PM', 'desc' => 'Mid-afternoon check'],
    'evening' => ['title' => 'Evening Reading', 'time' => '8:00 PM - 11:59 PM', 'desc' => 'Before bed'],
];

$nextSlotKey = null;
foreach ($dailySchedule as $key => $slot) {
    if (!$timeSlots[$key]) {
        $nextSlotKey = $key;
        break;
    }
}
?>

<div class="px-4 pt-6">

    <!-- Welcome Header -->
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
            Hi <?= h($identity->first_name) ?> <?= h($identity->last_name) ?>!
        </h1>
    </div>

    <!-- Timeline Vitals Tracker Card -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Daily Vitals Tracker</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Stay on track with your recovery schedule.</p>
            </div>
            <!-- Progress Badge -->
            <div class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                <?= $completedCount ?> / <?= $totalRequired ?> Completed
            </div>
        </div>

        <!-- Vertical Timeline -->
        <ol class="relative ml-4 border-l-2 border-gray-200 dark:border-gray-700">
            <?php foreach ($dailySchedule as $key => $slot): ?>
                <?php
                $isCompleted = $timeSlots[$key];
                $isNext = ($key === $nextSlotKey);
                ?>

                <li class="mb-8 ml-8">
                    <!-- The Dot / Icon -->
                    <span class="absolute flex items-center justify-center w-8 h-8 -left-4 rounded-full ring-4 ring-white dark:ring-gray-800
                        <?= $isCompleted ? 'bg-green-100 dark:bg-green-900' : ($isNext ? 'bg-primary-100 dark:bg-primary-900' : 'bg-gray-100 dark:bg-gray-700') ?>">

                        <?php if ($isCompleted): ?>
                            <!-- Green Checkmark for completed -->
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <?php elseif ($isNext): ?>
                            <!-- Blue Pulse for "Up Next" -->
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <?php else: ?>
                            <!-- Gray Lock/Clock for pending -->
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <?php endif; ?>
                    </span>

                    <!-- Content -->
                    <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                        <?= $slot['title'] ?>

                        <!-- Status Badges -->
                        <?php if ($isCompleted): ?>
                            <span class="px-2.5 py-0.5 ml-3 text-xs font-medium text-green-800 bg-green-100 rounded dark:bg-green-900 dark:text-green-300">Done</span>
                        <?php elseif ($isNext): ?>
                            <span class="px-2.5 py-0.5 ml-3 text-xs font-medium text-primary-800 bg-primary-100 rounded dark:bg-primary-900 dark:text-primary-300">Action Required</span>
                        <?php endif; ?>
                    </h3>

                    <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                        <?= $slot['time'] ?> <span class="mx-1">&bull;</span> <?= $slot['desc'] ?>
                    </time>

                    <?php if ($isNext): ?>
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="<?= $this->Url->build(['controller' => 'PatientMeasurements', 'action' => 'add']) ?>"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                Log <?= $slot['title'] ?>
                            </a>

                            <?= $this->Form->postLink(
                                'Skip',
                                ['controller' => 'PatientMeasurements', 'action' => 'skip', $key],
                                [
                                    'escape' => false,
                                    'confirm' => __('Are you sure you want to skip your {0}? You cannot undo this.', $slot['title']),
                                    'class' => 'temp-disable-button inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-500 transition-colors',
                                ]
                            ) ?>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>

        <!-- Final state when all are done -->
        <?php if ($completedCount >= $totalRequired): ?>
            <div class="p-4 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Excellent work!</span> You have completed all your required readings for today.
            </div>
        <?php endif; ?>

    </div>

    <!-- Data Table Section -->
    <?= $this->element('table/table_wrapper', [
        'hasSearch' => false,
        'tableElement' => 'table/entity_tables/patient_dashboard_table',
    ]) ?>

    <?= $this->element('table/pagination_footer') ?>

</div>
