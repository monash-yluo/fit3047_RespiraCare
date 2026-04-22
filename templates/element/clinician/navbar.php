<?php

$clinicianMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Clinicians', 'action' => 'dashboard']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    // ['label' => 'Settings', 'url' => ['controller' => 'Users', 'action' => 'edit', $identity->id]],
];

echo $this->element('base/navbar', ['menuItems' => $clinicianMenu]);
