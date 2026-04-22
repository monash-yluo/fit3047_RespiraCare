<?php
/** @var \App\Model\Entity\User $identity */

$patientMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Patients', 'action' => 'dashboard']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    // ['label' => 'Settings', 'url' => ['controller' => 'Users', 'action' => 'edit', $identity->id]],
];

$searchableMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Patients', 'action' => 'dashboard']],
    ['label' => 'Symptoms', 'url' => ['controller' => 'SymptomLogs', 'action' => 'patientIndex']],
    ['label' => 'Resources', 'url' => /* ['controller' => 'Resources', 'action' => 'index'] */ ['controller' => 'Patients', 'action' => 'dashboard']],
    ['label' => 'Booking', 'url' => /*['controller' => 'Bookings', 'action' => 'add']*/ ['controller' => 'Patients', 'action' => 'dashboard']],
    ['label' => 'Reminders', 'url' => ['controller' => 'Reminders', 'action' => 'index']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    ['label' => 'Logout', 'url' => ['controller' => 'Users', 'action' => 'logout']],
];

echo $this->element('base/navbar', ['menuItems' => $patientMenu, 'searchableMenu' => $searchableMenu]);
