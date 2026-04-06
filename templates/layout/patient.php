<?php
$this->extend('base');

$this->assign('title', $this->fetch('title') . ' | RespiraCare Patient');

$this->assign('navbar', $this->element('patient/navbar'));

$this->assign('sidebar', $this->element('patient/sidebar'));

echo $this->fetch('content');
