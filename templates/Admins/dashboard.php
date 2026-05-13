<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\ContactMessage> $contactMessages
 */

$this->setLayout($identity->role);
$this->assign('title', 'Dashboard Overview');
?>

<div class="px-4 pt-6">

    <?= $this->element('table/page_header', [
        'title' => 'Admin Dashboard',
        'description' => 'Manage incoming contact messages.',
    ]) ?>

    <div class="grid w-full grid-cols-1 gap-4 mb-6 sm:grid-cols-2 2xl:grid-cols-3">

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Inbound Messages') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                <?= $totalMessages ?? 0 ?>
            </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Contact form submissions') ?></p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Total Clinicians') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                <?= $totalClinicians ?? 0 ?>
            </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Registered medical staff') ?></p>
            </div>
        </div>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="w-full">
                <h3 class="text-base font-normal text-gray-500 dark:text-gray-400"><?= __('Total Patients') ?></h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                <?= $totalPatients ?? 0 ?>
            </span>
                <p class="mt-2 text-sm text-gray-400"><?= __('Active patient profiles') ?></p>
            </div>
        </div>

    </div>

    <div class="grid w-full grid-cols-1 gap-4 mb-6 xl:grid-cols-2">
        <!-- Messages Trend Chart -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Contact Messages Trend</h3>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Past 6 Months</span>
            </div>
            <div id="messages-chart" class="w-full h-64"></div>
        </div>

        <!-- Patients Growth Chart -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4 relative">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Patient Registrations</h3>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Past 6 Months</span>
            </div>
            <div id="patients-chart" class="w-full h-64"></div>
        </div>
    </div>

    <?= $this->element('table/table_wrapper', [
        'tableElement' => 'table/entity_tables/admin_dashboard_table',
        'hasDateFilter' => true,
        'target' => 'contactMessages'
    ]) ?>
</div>

<?php $this->append('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartLabels = <?= json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) ?>;
        const messagesData = <?= json_encode($messagesChartData ?? [0, 0, 0, 0, 0, 0]) ?>;
        const patientsData = <?= json_encode($patientsChartData ?? [0, 0, 0, 0, 0, 0]) ?>;

        const commonOptions = {
            chart: {
                height: 250,
                type: 'area',
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },

            xaxis: {
                categories: chartLabels,
                labels: { style: { colors: '#6B7280', fontFamily: 'Inter, sans-serif' } },
                tooltip: { enabled: false }
            },
            yaxis: {
                labels: { style: { colors: '#6B7280', fontFamily: 'Inter, sans-serif' } },
            },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
            },
        };

        // Initialise Messages Chart
        const messagesOptions = {
            ...commonOptions,
            series: [{ name: 'Messages', data: messagesData.map(Number) }],
            colors: ['#3b82f6'],
        };
        if (document.getElementById("messages-chart")) {
            new ApexCharts(document.getElementById("messages-chart"), messagesOptions).render();
        }

        // Initialise Patients Chart
        const patientsOptions = {
            ...commonOptions,
            series: [{ name: 'New Patients', data: patientsData.map(Number) }],
            colors: ['#10b981'],
        };
        if (document.getElementById("patients-chart")) {
            new ApexCharts(document.getElementById("patients-chart"), patientsOptions).render();
        }
    });
</script>
<?php $this->end(); ?>

