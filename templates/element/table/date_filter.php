<?php
// Get current value from the URL (e.g., ?date_preset=7)
$currentPreset = $this->request->getQuery('date_preset');
$urlTarget = $this->request->getQuery('target');
$target = $target ?? null;
$class = $class ?? null;

$selectedValue = $urlTarget === $target || empty($urlTarget) ? $currentPreset : '';

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
        'value' => $selectedValue,
        'data-target' => !empty($target) ? $target : null,
        'class' => trim(($class ?? '') . ' date-preset-filter-js bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white'),
    ],
) ?>

<?php $this->append('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const presetSelects = document.querySelectorAll('.date-preset-filter-js');

        presetSelects.forEach(select => {
            select.addEventListener('change', function() {
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

                const paramsToDelete = [];
                url.searchParams.forEach((value, key) => {
                    if (key === 'page' || key.includes('[page]')) {
                        paramsToDelete.push(key);
                    }
                });
                paramsToDelete.forEach(key => url.searchParams.delete(key));
                const targetUrl = url.toString();

                const tableWrapper = this.closest('.data-table');
                let targetContainer = tableWrapper ? tableWrapper.querySelector('.ajax-table-content') : null;

                if (!targetContainer) {
                    targetContainer = document.getElementById('grid-container');
                }

                if (targetContainer) {
                    targetContainer.classList.add('opacity-50', 'pointer-events-none');

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
        });
    });
</script>
<?php $this->end(); ?>
