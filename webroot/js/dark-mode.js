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

/**
 * Auto SearchingBar
 */
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.getElementById('simple-search');
    const searchForm = document.getElementById('search-form');

    if (searchInput && searchForm) {
        // Move cursor to the end of the text on load (UX improvement for auto-searches)
        const val = searchInput.value;
        searchInput.focus();
        searchInput.value = '';
        searchInput.value = val;

        // Listen for user typing
        searchInput.addEventListener('input', function() {
            // Clear the existing timer if they type again
            clearTimeout(searchTimeout);

            // Set a new timer for 2 seconds (2000 milliseconds)
            searchTimeout = setTimeout(function() {
                searchForm.submit();
            }, 1500);
        });
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

