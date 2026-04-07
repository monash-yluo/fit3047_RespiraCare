<?php
$this->extend('base');

$this->assign('title', $this->fetch('title') . ' | RespiraCare Clinician');

$this->assign('navbar', $this->element('clinician/navbar'));

$this->assign('sidebar', $this->element('clinician/sidebar'));

echo $this->fetch('content');
