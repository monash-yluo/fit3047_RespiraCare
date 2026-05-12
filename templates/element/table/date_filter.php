<?php
// Get current value from the URL (e.g., ?date_preset=7)
$currentPreset = $this->request->getQuery('date_preset');
$target = $target ?? null;
$class = $class ?? null;

?>

<?= $this->Form->select(
    'date_preset',
    [
        '' => 'All Time',
        'today' => 'Today',
        '7' => 'Past 7 Days',
        '30' => 'Past 30 Days',
        '90' => 'Past 3 Months',
    ],
    [
        'id' => 'date-preset-filter',
        'value' => $currentPreset,
        'data-target' => !empty($target) ? $target : null,
        'class' => trim(($class ?? '') . ' bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white')
    ]
) ?>

<?php $this->append('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const presetSelect = document.getElementById('date-preset-filter');

        if (presetSelect) {
            presetSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);

                const targetValue = this.dataset.target;
                if (targetValue) {
                    url.searchParams.set('target', targetValue);
                }

                if (this.value) {
                    url.searchParams.set('date_preset', this.value);
                } else {
                    url.searchParams.delete('date_preset');
                }
                url.searchParams.delete('page');

                const targetUrl = url.toString();

                const tableWrapper = this.closest('.data-table');
                let targetContainer = tableWrapper ? tableWrapper.querySelector('.ajax-table-content') : null;

                // If no table was found, check for the grid layout
                if (!targetContainer) {
                    targetContainer = document.getElementById('grid-container');
                }

                if (targetContainer) {
                    targetContainer.classList.add('opacity-50', 'pointer-events-none');

                    // Perform the AJAX request
                    fetch(targetUrl, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(response => response.text())
                        .then(html => {
                            targetContainer.innerHTML = html;
                            targetContainer.classList.remove('opacity-50', 'pointer-events-none');

                            window.history.pushState(null, '', targetUrl);
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            targetContainer.classList.remove('opacity-50', 'pointer-events-none');
                        });

                } else {
                    window.location.href = targetUrl;
                }
            });
        }
    });
</script>
<?php $this->end(); ?>
