<?php

/**
 * @var \App\View\AppView $this
 * @var $users
 */

$this->setLayout($identity->role);
$this->assign('title', 'Manage Users');

$buildUrl = function($role) {
    $params = array_merge($this->request->getQueryParams(), ['role' => $role === 'all' ? null : $role]);
    return $this->Url->build(['?' => $params]);
};
$currentRole = $this->request->getQuery('role', 'all');

?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Manage Users',
        'description' => 'View, add, and manage all system users.',
        'actionLabel' => __('New User'),
        'actionUrl' => ['action' => 'add'],
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/users_table',
        'filterConfig' => [
            'paramName' => 'role',
            'options' => [
                '' => 'All',
                'admin' => 'Admins',
                'patient' => 'Patients',
                'clinician' => 'Clinicians',
            ],
        ],
    ]) ?>
</div>
