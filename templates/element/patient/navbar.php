<?php

$patientMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'PatientPortals', 'action' => 'dashboard']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    ['label' => 'Settings', 'url' => ['controller' => 'Users', 'action' => 'edit', $identity->id]],
];

echo $this->element('base/navbar', ['menuItems' => $patientMenu]);
