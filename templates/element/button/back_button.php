<?php
/**
 * Advanced Session-Based Back Button
 * Detects A -> B -> A loops and leapfrogs backward.
 *
 * @var string $label Button label/text (optional, default: 'Back')
 * @var string $class Custom CSS classes (optional)
 * @var array|string|null $url Hard override URL for Edit/Add pages (optional)
 */

$label = $label ?? 'Back';
$class = 'text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 ' . ($class ?? '');

// 1. Check for Hard Override (e.g., from an Edit/Add template)
if (!empty($url)) {
    echo $this->Html->link(__($label), $url, ['class' => $class]);
    return;
}

// 2. Setup Dashboard Fallback
$identity = $this->getRequest()->getAttribute('identity');
$role = $identity?->role;

$dashboardRoutes = [
    'admin' => ['controller' => 'Admins', 'action' => 'dashboard'],
    'clinician' => ['controller' => 'Clinicians', 'action' => 'dashboard'],
    'patient' => ['controller' => 'Patients', 'action' => 'dashboard'],
];
$fallback = $this->Url->build($dashboardRoutes[$role] ?? '/');

// 3. Read the Session History
$history = $this->request->getSession()->read('User.History', []);
$count = count($history);

$targetUrl = $fallback;

if ($count >= 3) {
    // Array indexing: $count - 1 is the Current Page
    $currentPage = $history[$count - 1];
    $previousPage = $history[$count - 2];
    $twoPagesAgo = $history[$count - 3];

    // THE LOOP CHECK: Is 2 pages ago the same as the current page? (A -> B -> A)
    if ($currentPage === $twoPagesAgo) {
        // We are in a loop! Leapfrog to 3 pages ago (if it exists)
        if ($count >= 4) {
            $targetUrl = $history[$count - 4];
        } else {
            $targetUrl = $fallback;
        }
    } else {
        // Normal navigation, go back 1 page
        $targetUrl = $previousPage;
    }
} elseif ($count === 2) {
    // We only have 2 pages of history, just go to the first one
    $targetUrl = $history[0];
}

?>

<?= $this->Html->link(
    __($label),
    $targetUrl,
    ['class' => $class]
) ?>
