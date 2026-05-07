<?php
/** @var \App\Model\Entity\User $identity */

$clinicianMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Clinicians', 'action' => 'dashboard']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    // ['label' => 'Settings', 'url' => ['controller' => 'Users', 'action' => 'edit', $identity->id]],
];

$searchableMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Clinicians', 'action' => 'dashboard']],
    ['label' => 'Patients', 'url' => ['controller' => 'Patients', 'action' => 'clinicianIndex']],
    ['label' => 'Resources', 'url' => ['controller' => 'Resources', 'action' => 'index']],
    ['label' => 'Bookings', 'url' => ['controller' => 'Bookings', 'action' => 'patient-clinician-index']],
    ['label' => 'Reminders', 'url' => ['controller' => 'Reminders', 'action' => 'index']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    ['label' => 'Logout', 'url' => ['controller' => 'Users', 'action' => 'logout']],
];

echo $this->element('base/navbar', ['menuItems' => $clinicianMenu, 'searchableLinks' => $searchableMenu]);
