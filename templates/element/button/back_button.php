<?php
/**
 * Smart Back Button Element
 * Uses browser history with fallback to dashboard if no history
 * 
 * @var string $label Button label/text (optional, default: 'Back')
 * @var string $class Custom CSS classes (optional)
 */

$label = $label ?? 'Back';
$class = $class ?? 'text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800';

// Get dashboard URL as fallback
$identity = $this->getRequest()->getAttribute('identity');
$role = $identity?->role;

$dashboardRoutes = [
    'admin' => ['controller' => 'Admins', 'action' => 'dashboard'],
    'clinician' => ['controller' => 'ClinicianPortals', 'action' => 'dashboard'],
    'patient' => ['controller' => 'PatientPortals', 'action' => 'dashboard'],
];

$dashboardUrl = $dashboardRoutes[$role] ?? '/';
if (is_array($dashboardUrl)) {
    $dashboardUrl = $this->Url->build($dashboardUrl);
}
?>

<button type="button" onclick="smartBackButton('<?= htmlspecialchars($dashboardUrl) ?>')" class="<?= $class ?>">
    <?= $label ?>
</button>

<script>
function smartBackButton(dashboardUrl) {
    if (window.history.length <= 1) {
        window.location.href = dashboardUrl;
    } else {
        window.history.back();
    }
}
</script>
