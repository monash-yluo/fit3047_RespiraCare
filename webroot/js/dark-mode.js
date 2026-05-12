const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}

const themeToggleBtn = document.getElementById('theme-toggle');

let event = new Event('dark-mode');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }

    document.dispatchEvent(event);

});


/**
 * Preloader
 */
/*
const preloader = document.querySelector('#preloader');

if (preloader) {
    // Check if the user has already "entered" the admin panel in this session
    const hasLoaded = sessionStorage.getItem('admin_loaded');

    if (hasLoaded) {
        // If they have, remove the preloader immediately so they don't see the flash
        preloader.remove();
    } else {
        // If it's the first time, wait for the full load, then set the flag
        window.addEventListener('load', () => {
            preloader.remove();
            sessionStorage.setItem('admin_loaded', 'true');
        });
    }
}
*/

/**
 * Auto SearchingBar
 */
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInputs = document.querySelectorAll('.simple-search');

    if (searchInputs) {
        // Move cursor to the end of the text on load

        searchInputs.forEach((searchInput) => {
            const val = searchInput.value;
            searchInput.focus();
            searchInput.value = '';
            searchInput.value = val;

            // Listen for user typing
            searchInput.addEventListener('input', function() {

                const tableWrapper = searchInput.closest('.table_wrapper');
                const tableContainer = tableWrapper.querySelector('.ajax-table-content');

                // Return if Table Container not exist
                if (!tableContainer) return;

                // Clear the existing timer
                clearTimeout(searchTimeout);

                // Set a new timer for 0.3s
                searchTimeout = setTimeout(function() {
                    const searchValue = searchInput?.value || '';
                    const target = searchInput.getAttribute('data-target');
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', searchValue);
                    url.searchParams.set('target', target);

                    fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                        .then(response => response.text())
                        .then(html => {tableContainer.innerHTML = html; })
                        .catch(error => {console.error('Search failed:', error);});

                }, 300);
            });
        })
    }
});

/**
 * Global Search
 */
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('topbar-search');
    const dropdown = document.getElementById('search-dropdown');
    const searchItems = document.querySelectorAll('.search-item');

    const handleSearch = () => {
        const filter = searchInput.value.toLowerCase();
        let visibleCount = 0;


        if (filter.length <= 0) {
            dropdown.classList.add('hidden');
            return;
        }

        searchItems.forEach(item => {
            const label = item.getAttribute('data-label');
            if (label.includes(filter)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (visibleCount > 0) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    };


    searchInput.addEventListener('input', handleSearch);
    searchInput.addEventListener('focus', handleSearch);


    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });


    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !dropdown.classList.contains('hidden')) {

            const firstVisible = Array.from(searchItems).find(i => i.style.display !== 'none');
            if (firstVisible) {
                e.preventDefault();
                firstVisible.querySelector('a').click();
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('.message');

    messages.forEach(function(message) {
        setTimeout(function() {
            message.style.transition = "opacity 0.5s ease";
            message.style.opacity = "0";

            setTimeout(function() {
                message.remove();
            }, 500);
        }, 5000);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.querySelector('.simple-search');
    const gridContainer = document.getElementById('grid-container');


    if (searchInput && gridContainer) {
        const val = searchInput.value;
        searchInput.focus();
        searchInput.value = '';
        searchInput.value = val;

        // Listen for user typing
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(function() {
                const searchValue = searchInput?.value || '';
                const url = new URL(window.location.href);
                url.searchParams.set('search', searchValue);

                fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(response => response.text())
                    .then(html => {gridContainer.innerHTML = html; })
                    .catch(error => {console.error('Search failed:', error);});

            }, 300);
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const skipButtons = document.querySelectorAll('.temp-disable-button');

    skipButtons.forEach(button => {
        button.addEventListener('click', function(e) {

            if (this.classList.contains('pointer-events-none')) {
                e.preventDefault();
                return false;
            }

            const form = this.form || this.closest('form');
            if (form && typeof form.checkValidity === 'function') {
                if (!form.checkValidity()) {
                    return;
                }
            }

            // For buttons with confirm, set a timeout to restore in case user clicks Cancel
            const hasConfirm = this.getAttribute('onclick')?.includes('confirm(') || this.getAttribute('data-confirm');
            const btn = this;

            const parentRow = this.closest('tr');
            const siblingActions = parentRow ? parentRow.querySelectorAll('a, button') : [];

            setTimeout(() => {
                btn.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                btn.style.filter = 'grayscale(0.1)';

                siblingActions.forEach(actionBtn => {
                    actionBtn.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                    actionBtn.style.filter = 'grayscale(0.1)';
                });

                // If button has confirm dialog, auto-restore after 2 seconds in case user cancelled
                if (hasConfirm) {
                    setTimeout(() => {
                        // Check if page is still here (if page navigated, this won't execute)
                        if (document.body) {
                            btn.classList.remove('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                            btn.style.filter = '';

                                siblingActions.forEach(actionBtn => {
                                actionBtn.classList.remove('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                                actionBtn.style.filter = '';
                            });
                        }
                    }, 1500);
                }
            }, 10);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    let filterRequest;
    const filterButtons = document.querySelectorAll('[data-ajax-filter="true"]');

    if (filterButtons.length > 0) {

        filterButtons.forEach((filterBtn) => {

            filterBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Skip if already active
                if (filterBtn.classList.contains('active-filter')) return;

                const tableWrapper = filterBtn.closest('.data-table');
                const tableContainer = tableWrapper.querySelector('.ajax-table-content');

                if (!tableContainer) return;

                const paramName = filterBtn.getAttribute('data-filter-param');
                const paramValue = filterBtn.getAttribute('data-filter-value');
                const targetValue = filterBtn.getAttribute('data-target');

                const displayUrl = new URL(window.location.href);

                // Remove filter if empty
                if (!paramValue) {
                    displayUrl.searchParams.delete(paramName);
                } else {
                    displayUrl.searchParams.set(paramName, paramValue);
                }

                // Reset pagination
                displayUrl.searchParams.delete('page');
                const fetchUrl = new URL(displayUrl.toString());
                if (targetValue) {
                    fetchUrl.searchParams.set('target', targetValue);
                }

                // Abort previous request
                if (filterRequest) {
                    filterRequest.abort();
                }

                filterRequest = new AbortController();

                // Loading state
                tableContainer.classList.add('opacity-50', 'pointer-events-none');

                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: filterRequest.signal
                })
                    .then(response => response.text())
                    .then(html => {

                        tableContainer.innerHTML = html;
                        tableContainer.classList.remove('opacity-50', 'pointer-events-none');

                        // Update active states
                        const group = filterBtn.closest('[role="group"]');

                        if (!group) return;

                        const siblings = group.querySelectorAll('.filter-btn');

                        const activeClasses = [
                            'active-filter',
                            'bg-white',
                            'text-gray-900',
                            'shadow',
                            'dark:bg-gray-800',
                            'dark:text-white'
                        ];

                        const inactiveClasses = [
                            'text-gray-500',
                            'hover:text-gray-900',
                            'dark:text-gray-400',
                            'dark:hover:text-white',
                            'hover:bg-gray-50',
                            'dark:hover:bg-gray-600'
                        ];

                        siblings.forEach((btn) => {

                            btn.classList.remove(...activeClasses, ...inactiveClasses);

                            if (btn === filterBtn) {
                                btn.classList.add(...activeClasses);
                            } else {
                                btn.classList.add(...inactiveClasses);
                            }
                        });
                    })
                    .catch(error => {

                        if (error.name !== 'AbortError') {
                            console.error('Filter failed:', error);
                            tableContainer.classList.remove('opacity-50', 'pointer-events-none');
                        }
                    });
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    let gridFilterRequest;
    const filterSelects = document.querySelectorAll('[data-ajax-filter-select="true"]');
    const gridContainer = document.getElementById('grid-container');

    if (filterSelects.length > 0 && gridContainer) {
        filterSelects.forEach((select) => {
            select.addEventListener('change', function() {
                const paramName = this.getAttribute('data-filter-param');
                const paramValue = this.value;
                const url = new URL(window.location.href);

                if (!paramValue) {
                    url.searchParams.delete(paramName);
                } else {
                    url.searchParams.set(paramName, paramValue);
                }

                url.searchParams.delete('page');

                if (gridFilterRequest) {
                    gridFilterRequest.abort();
                }
                gridFilterRequest = new AbortController();

                gridContainer.classList.add('opacity-50', 'pointer-events-none');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: gridFilterRequest.signal
                })
                    .then(response => response.text())
                    .then(html => {
                        gridContainer.innerHTML = html;
                        gridContainer.classList.remove('opacity-50', 'pointer-events-none');

                    })
                    .catch(error => {
                        if (error.name !== 'AbortError') {
                            console.error('Grid filter failed:', error);
                            gridContainer.classList.remove('opacity-50', 'pointer-events-none');
                        }
                    });
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    let dropdownRequest;
    const filterSelects = document.querySelectorAll('[data-ajax-filter-select="true"]');
    const tableContainer = document.querySelector('.ajax-table-content');

    if (filterSelects.length > 0 && tableContainer) {
        filterSelects.forEach((select) => {
            select.addEventListener('change', function() {
                const paramName = this.getAttribute('data-filter-param');
                const paramValue = this.value;
                const targetValue = this.getAttribute('data-target');
                const displayUrl = new URL(window.location.href);

                // Update the specific parameter
                if (!paramValue) {
                    displayUrl.searchParams.delete(paramName);
                } else {
                    displayUrl.searchParams.set(paramName, paramValue);
                }

                // Reset pagination
                displayUrl.searchParams.delete('page');
                const fetchUrl = new URL(displayUrl.toString());
                if (targetValue) {
                    fetchUrl.searchParams.set('target', targetValue);
                }

                // Abort previous request
                if (dropdownRequest) {
                    dropdownRequest.abort();
                }
                dropdownRequest = new AbortController();

                // Loading state
                tableContainer.classList.add('opacity-50', 'pointer-events-none');

                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: dropdownRequest.signal
                })
                    .then(response => response.text())
                    .then(html => {
                        tableContainer.innerHTML = html;
                        tableContainer.classList.remove('opacity-50', 'pointer-events-none');

                    })
                    .catch(error => {
                        if (error.name !== 'AbortError') {
                            console.error('Filter failed:', error);
                            tableContainer.classList.remove('opacity-50', 'pointer-events-none');
                        }
                    });
            });
        });
    }
});
