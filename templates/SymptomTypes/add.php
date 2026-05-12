<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SymptomType $symptomType
 * @var $identity
 */

// Breadcrumb
$breadcrumbs = [
    ['title' => 'Content Management', 'url' => ['controller' => 'AdminContentBlocks', 'action' => 'index']],
    ['title' => 'Add Symptom Category', 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Add Symptom Category');
?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Add Symptom Category',
        'description' => 'Create a new symptom type that patients can select when logging their daily health status.',
        'showBack' => true,
    ]) ?>

    <?= $this->Form->create($symptomType) ?>

    <div class="grid grid-cols-1 gap-4">
        <div class="col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Category Information</h3>
                <div class="grid grid-cols-1 gap-x-4 gap-y-6">

                    <div>
                        <?= $this->Form->control('name', [
                            'label' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white', 'text' => 'Symptom Name'],
                            'placeholder' => 'e.g., Shortness of Breath, Chest Tightness',
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            'templates' => [
                                'error' => '<div class="mt-2 text-sm text-red-600 dark:text-red-500 font-medium">{{content}}</div>'
                            ]
                        ]) ?>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            This name will be visible to patients in their mobile and web logging forms.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <?= $this->Html->link(
                            'Cancel',
                            ['controller' => 'AdminContentBlocks', 'action' => 'index'],
                            ['class' => 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700']
                        ) ?>
                        <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Save Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
