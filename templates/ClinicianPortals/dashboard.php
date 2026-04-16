<?php
/**
 * Patient Portal Dashboard
 * @var \Cake\View\View $this
 * @var \Cake\Datasource\EntityInterface $identity
 */

$this->setLayout($identity->role);
$this->assign('title', 'Dashboard Overview');

?>
