<?php
/** @var \App\Model\Entity\User $identity */

$adminMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Admins', 'action' => 'dashboard']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    ['label' => 'Settings', 'url' => ['controller' => 'Users', 'action' => 'edit', $identity->id]],
];

$searchableMenu = [
    ['label' => 'Dashboard', 'url' => ['controller' => 'Admins', 'action' => 'dashboard']],
    ['label' => 'Users', 'url' => ['controller' => 'Users', 'action' => 'index']],
    ['label' => 'Clinicians', 'url' => ['controller' => 'Clinicians', 'action' => 'index']],
    ['label' => 'Patients', 'url' => ['controller' => 'Patients', 'action' => 'index']],
    ['label' => 'Reminders', 'url' => ['controller' => 'Reminders', 'action' => 'index']],
    ['label' => 'Resources', 'url' => /*['controller' => 'Resources', 'action' => 'index']*/ ['controller' => 'Admins', 'action' => 'dashboard']],
    ['label' => 'Contact Messages', 'url' => ['controller' => 'ContactMessages', 'action' => 'index']],
    ['label' => 'My Profile', 'url' => ['controller' => 'Users', 'action' => 'view', $identity->id]],
    ['label' => 'Settings', 'url' => ['controller' => 'Users', 'action' => 'edit', $identity->id]],
    ['label' => 'Logout', 'url' => ['controller' => 'Users', 'action' => 'logout']],
];

echo $this->element('base/navbar', ['menuItems' => $adminMenu, 'searchableLinks' => $searchableMenu]);
