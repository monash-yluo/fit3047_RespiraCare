<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomLog $symptomLog
 * @var \Cake\Collection\CollectionInterface|string[] $symptomTypes
 * @var $identity
 */

// Breadcrumb
$breadcrumbs = [
    ['title' => 'Symptom Logs', 'url' => $identity->role == 'patient' ? ['action' => 'patient-index'] : ['action' => 'index']],
    ['title' => 'Edit #' . $symptomLog->id, 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Edit Symptom');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Edit Respiratory Symptoms',
        'description' => 'Update your symptom information and severity to help us track your health trends accurately.',
        'showBack' => true,
        ]) ?>

    <?= $this->Form->create($symptomLog) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Symptom Details</h3>

                <div class="grid grid-cols-1 gap-x-4 gap-y-6">
                    <div>
                        <label for="logged_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time of Symptom</label>
                        <?= $this->Form->control('logged_at', [
                            'type' => 'datetime-local',
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400',
                            'value' => $symptomLog->logged_at ? $symptomLog->logged_at->format('Y-m-d\TH:i') : ''
                        ]) ?>
                    </div>

                    <div>
                        <label class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">What symptoms are you experiencing?</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <?= $this->Form->control('symptom_types._ids', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $symptomTypes,
                                'label' => false,
                                'templates' => [
                                    'checkboxWrapper' => '<div class="flex items-center">{{label}}</div>',
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}} class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">',
                                    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}} class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{text}}</label>',
                                ]
                            ]) ?>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">Severity Level (1-5)</label>
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <span class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">Mild</span>
                            <div class="flex space-x-4 sm:space-x-8">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <div class="flex flex-col items-center">
                                        <input type="radio" name="severity" value="<?= $i ?>" id="severity-<?= $i ?>" <?= $i == 1 ? 'checked' : '' ?> class="w-5 h-5 text-primary-600 bg-white border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="severity-<?= $i ?>" class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?= $i ?></label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <span class="text-xs font-semibold text-red-600 dark:text-red-500 uppercase">Severe</span>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <?= $this->Form->textarea('description', [
                            'rows' => 3,
                            'placeholder' => 'Describe how you feel (e.g., Shortness of breath during exercise...)',
                            'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Additional Information</h3>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                    <?= $this->Form->textarea('notes', [
                        'rows' => 6,
                        'placeholder' => 'Any additional context or triggers...',
                        'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400'
                    ]) ?>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 my-4">

            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex flex-col space-y-4">
                    <?= $this->element('button/blue_button', [
                        'type' => 'submit',
                        'label' => __('Update Symptom Log'),
                        'iconType' => 'edit'
                    ]) ?>

                    <?= $this->element('button/red_button', [
                        'label' => __('Delete'),
                        'url' => ['action' => 'delete', $symptomLog->id],
                        'iconType' => 'delete',
                        'confirm' => __('Are you sure you want to delete this symptom log?')
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
