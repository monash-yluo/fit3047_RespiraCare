<?php
/**
 * Grey Button Element (for secondary actions)
 * 
 * @var string $label Button label/text
 * @var string $url URL for link button (optional)
 * @var bool $smartBack Use smart back button (browser history with dashboard fallback) (optional)
 * @var array $options Additional HTML options (optional)
 */

$label = $label ?? 'Button';
$url = $url ?? null;
$smartBack = $smartBack ?? false;
$options = $options ?? [];

$defaultClass = 'py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-gray-100 rounded-lg border border-gray-200 hover:bg-gray-200 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 text-center';

if ($smartBack) {
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
    <button type="button" onclick="smartBackButton('<?= htmlspecialchars($dashboardUrl) ?>')" class="<?= isset($options['class']) ? $options['class'] : $defaultClass ?>">
        <?= $label ?>
    </button>

    <script>
    if (typeof smartBackButton === 'undefined') {
        function smartBackButton(dashboardUrl) {
            if (window.history.length <= 1) {
                window.location.href = dashboardUrl;
            } else {
                window.history.back();
            }
        }
    }
    </script>
    <?php
} elseif ($url) {
    // Render as link
    echo $this->Html->link(
        $label,
        $url,
        array_merge([
            'class' => $defaultClass
        ], $options)
    );
} else {
    // Render as regular button
    ?>
    <button type="button" <?php echo isset($options['class']) ? 'class="' . $options['class'] . '"' : 'class="' . $defaultClass . '"'; ?>>
        <?= $label ?>
    </button>
    <?php
}
?>
