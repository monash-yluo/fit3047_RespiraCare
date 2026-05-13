<?php
/**
 * @var \App\View\AppView $this
 * @var $identity
 */

$this->setLayout($identity->role ?? 'default');
$this->assign('title', 'Help & FAQ');

// Example FAQ Data
$faqs = [
    [
        'question' => 'How do I request a new appointment?',
        'answer' => 'Navigate to the <strong>Bookings</strong> tab in the sidebar and click "Request New Booking". Select your clinician from the dropdown menu, pick an available date and time from the calendar, and click confirm. Your clinician will review and confirm the request.'
    ],
    [
        'question' => 'How do I reschedule an appointment?',
        'answer' => 'Currently, you must contact the clinic directly to reschedule a confirmed appointment. Please call us at least 24 hours in advance to avoid cancellation fees.'
    ],
    [
        'question' => 'Where can I find the videos and articles my clinician mentioned?',
        'answer' => 'Go to the <strong>Resources</strong> section in your dashboard. Here you will find all the articles, PDF guides, and video links that your clinician has made available to you.'
    ],
    [
        'question' => 'Is my personal and medical information secure?',
        'answer' => 'Yes. We use industry-standard encryption to protect your data. Only you and your authorized healthcare providers can access your records.'
    ],
    [
        'question' => 'What should I do in a medical emergency?',
        'answer' => '<strong>Do not use this portal for emergencies.</strong> If you are experiencing a medical emergency, please call 000 immediately or go to your nearest hospital emergency department.'
    ],
];
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Help & FAQ',
        'description' => 'Browse our frequently asked questions or contact support if you need further assistance.',
    ]) ?>

    <div class="flex flex-col space-y-6 mt-6">

        <!-- Main FAQ Accordion -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <h2 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">Frequently Asked Questions</h2>

            <div class="space-y-4">
                <?php foreach ($faqs as $faq): ?>
                    <details class="p-4 bg-gray-50 border border-gray-200 rounded-lg group dark:bg-gray-700/50 dark:border-gray-600 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between font-medium cursor-pointer text-gray-900 dark:text-white">
                            <span><?= h($faq['question']) ?></span>
                            <span class="transition-transform duration-200 group-open:-rotate-180">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </summary>
                        <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            <?= $faq['answer'] ?>
                        </p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="inline-flex items-center justify-center w-12 h-12 mb-4 bg-primary-100 rounded-full dark:bg-primary-900/30">
                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Still need help?</h3>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                If you couldn't find the answer to your question, our support team is here to assist you.
            </p>

            <?= $this->Html->link(
                "Contact Support",
                ['controller' => 'contactMessages', 'action' => 'contact'],
                ['class' => 'inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900 transition-colors']
            ) ?>

        </div>
    </div>
</div>
