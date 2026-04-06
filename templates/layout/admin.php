<?php
$this->extend('base');

$this->assign('title', $this->fetch('title') . ' | RespiraCare Admin');

$this->assign('navbar', $this->element('admin/navbar'));

$this->assign('sidebar', $this->element('admin/sidebar'));

echo $this->fetch('content');
