<?php
/**
 * @var \App\View\AppView $this
 * @var $clinicians
 */

$this->setLayout($identity->role);
$this->assign('title', 'Manage Clinicians');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Manage Clinicians',
        'description' => 'View, add, and manage clinician profiles and associations.',
        'actionLabel' => __('New Clinician'),
        'actionUrl' => ['controller' => 'Users', 'action' => 'add'],
    ]) ?>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/clinicians_table',
    ]) ?>

</div>
