<?php
// 获取用户信息，如果未登录则提供默认值
$userName = $identity ? $identity->get('full_name') : 'Unknown User';
$userEmail = $identity ? $identity->get('email') : 'Unknown email';
$userId = $identity ? $identity->get('id') : null;
$imageUrl = $identity ? $identity->get('image_path') : null;

// 确保 $menuItems 即使没传也不报错
$menuItems = $menuItems ?? [];
$searchableLinks = $searchableLinks ?? [];
?>

<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button
                    id="toggleSidebarMobile"
                    aria-expanded="true"
                    aria-controls="sidebar"
                    class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <a href="<?= $this->Url->build('/') ?>" class="flex flex-row items-center mx-2">
                    <?= $this->ContentBlock->image('logo-light', [
                        'alt' => 'Logo',
                        'class' => 'me-3 block dark:hidden',
                        'style' => 'max-height: 30px;',
                    ]) ?>
                    <?= $this->ContentBlock->image('logo-dark', [
                        'alt' => 'Logo Dark',
                        'class' => 'me-3 hidden dark:block',
                        'style' => 'max-height: 30px;',
                    ]) ?>
                    <?= $this->ContentBlock->html('dashboard-website-title') ?>
                </a>

                <div class="hidden lg:block lg:pl-3.5 relative">
                    <?= $this->Form->create(null, [
                        'onkeydown' => "return event.key != 'Enter';",
                        'class' => 'relative mt-1 lg:w-96'
                    ]) ?>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <?= $this->Form->control('q', [
                        'type' => 'text',
                        'id' => 'topbar-search',
                        'label' => false,
                        'placeholder' => __('Search Page...'),
                        'autocomplete' => 'off',
                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white'
                    ]) ?>

                    <div id="search-dropdown" class="absolute z-50 hidden w-full mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 border border-gray-200 dark:border-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" id="search-results-list">
                            <li class="px-4 py-2 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Quick Actions</li>
                            <?php foreach ($searchableLinks as $link): ?>
                                <li class="search-item" data-label="<?= strtolower(h($link['label'])) ?>">
                                    <?= $this->Html->link($link['label'], $link['url'], [
                                        'class' => 'block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white'
                                    ]) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="button" data-dropdown-toggle="notification-dropdown" class="relative p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                    <span class="sr-only">View notifications</span>

                    <!-- Bell Icon -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>

                    <?php
                    //Check if any reminder have unread
                    $hasUnread = false;
                    if (!empty($navbarReminders)) {
                        foreach ($navbarReminders as $reminder) {
                            if (!$reminder->is_read && $reminder->receiver_id === $identity->get('id')) {
                                $hasUnread = true;
                                break;
                            }
                        }
                    }
                    ?>

                    <?php if ($hasUnread): ?>
                        <div class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-0.5 right-0.5 dark:border-gray-900"></div>
                    <?php endif; ?>
                </button>

                <div class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700" id="notification-dropdown">
                    <div class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Notifications</div>
                    <div>
                        <?php if (!empty($navbarReminders)) : ?>
                            <?php foreach ($navbarReminders as $reminder) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Reminders', 'action' => 'view', $reminder->id]) ?>" class="flex px-4 py-3 border-b dark:border-gray-600 <?= !$reminder->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : 'hover:bg-gray-100 dark:hover:bg-gray-600' ?>">
                                    <div class="w-full pl-3">
                                        <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                            <span class="font-semibold text-gray-900 dark:text-white"><?= $reminder->sender ? h($reminder->sender->full_name) : 'System' ?></span>: <?= h($reminder->message) ?>
                                        </div>
                                        <div class="text-xs font-medium text-primary-700 dark:text-primary-400"><?= $this->Time->timeAgoInWords($reminder->created) ?></div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="block px-4 py-6 text-sm text-center text-gray-500 dark:text-gray-400">You have no new notifications.</div>
                        <?php endif; ?>
                    </div>

                    <?= $this->Html->link(
                        '<div class="inline-flex items-center"><svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>' . __('View all') . '</div>',
                        ['controller' => 'Reminders', 'action' => 'index'],
                        ['class' => 'block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline', 'escape' => false]
                    ) ?>
                </div>

                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <div class="flex items-center">
                    <button type="button" class="flex items-center justify-center w-8 h-8 text-sm bg-gray-200 rounded-full focus:ring-4 focus:ring-gray-300 dark:bg-gray-700 dark:focus:ring-gray-600 overflow-hidden" id="user-menu-button-2" data-dropdown-toggle="dropdown-2">

                        <?php if (!empty($imageUrl)): ?>
                            <?= $this->Html->image('users/' . $imageUrl, [
                                'alt' => $userName,
                                'class' => 'w-full h-full object-cover',
                                'onerror' => "this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                            ]) ?>

                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-300 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>

                        <?php else: ?>
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        <?php endif; ?>

                    </button>

                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-2">
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 dark:text-white"><?= h($userName) ?></p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"><?= h($userEmail) ?></p>
                        </div>
                        <ul class="py-1">
                            <?php foreach ($menuItems as $item): ?>
                                <li>
                                    <?= $this->Html->link(
                                        $item['label'],
                                        $item['url'],
                                        ['class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white']
                                    ) ?>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <?= $this->Html->link(
                                    __('Sign out'),
                                    ['controller' => 'Users', 'action' => 'logout'],
                                    ['class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white']
                                ) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
