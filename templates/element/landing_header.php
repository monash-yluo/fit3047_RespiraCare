<?php
    // 1. get current login user's identity
    // @Var \App\Model\Entity\User $identity
?>

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="<?= $this->Url->build('/') ?>" class="d-flex align-items-center">
            <!-- logo.com -->
            <?= $this->Html->image('respiracare-Icon.png', [
                'alt' => 'RespiraCare Logo',
                'class' => 'me-3 light-mode-logo',
                'style' => 'max-height: 30px;',
            ]) ?>
            <?= $this->Html->image('respiracare-Icon-dark.png', [
                'alt' => 'RespiraCare Logo - Dark Logo',
                'class' => 'me-3 dark-mode-logo',
                'style' => 'max-height: 30px;',
            ]) ?>
            <h1 class="sitename mb-0 fs-3">RespiraCare</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <?php
            $currentPath = $this->request->getPath();
            ?>
            <ul>
                <li>
                    <a href="<?= $this->Url->build('/') ?>"
                       class="<?= $currentPath === '/' ? 'active' : '' ?>">Home</a>
                </li>
                <li>
                    <a href="<?= $this->Url->build('/about') ?>"
                       class="<?= $currentPath === '/about' ? 'active' : '' ?>">About</a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'ContactMessages', 'action' => 'contact']) ?>"
                       class="<?= $currentPath === '/contact' ? 'active' : '' ?>">Contact</a>
                </li>
                <li>
                    <!-- 仅当用户未登录时显示 Login 链接 -->
                    <?php if (!$identity): ?>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>"
                           class="<?= ($this->request->getParam('controller') === 'Users' && $this->request->getParam('action') === 'login') ? 'active' : '' ?>">Login</a>
                    <?php endif; ?>
                </li>
                <li>
                    <!-- 如果是admin 登录 显示dashboard 链接 -->
                    <?php if ($identity && $identity->role === 'admin'): ?>
                        <a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']) ?>"
                           class="<?= ($this->request->getParam('controller') === 'Admins' && $this->request->getParam('action') === 'dashboard') ? 'active' : '' ?>">Admin Dashboard</a>
                    <?php endif; ?>
                </li>
                <li>
                    <!-- 如果是patient 登录 显示dashboard 链接 -->
                    <?php if ($identity && $identity->role === 'patient'): ?>
                        <a href="<?= $this->Url->build(['controller' => 'PatientPortals', 'action' => 'dashboard']) ?>"
                           class="<?= ($this->request->getParam('controller') === 'PatientPortals' && $this->request->getParam('action') === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
                    <?php endif; ?>
                </li>
                <li>
                    <!-- 如果是clinician 登录 显示dashboard 链接 -->
                    <?php if ($identity && $identity->role === 'clinician'): ?>
                        <a href="<?= $this->Url->build(['controller' => 'ClinicianPortals', 'action' => 'dashboard']) ?>"
                           class="<?= ($this->request->getParam('controller') === 'ClinicianPortals' && $this->request->getParam('action') === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
                    <?php endif; ?>
                </li>
                <li>
                    <!-- 仅当用户已登录时显示 Logout 链接 -->
                    <?php if ($identity): ?>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>"
                           class="<?= ($this->request->getParam('controller') === 'Users' && $this->request->getParam('action') === 'logout') ? 'active' : '' ?>">Logout</a>
                    <?php endif; ?>
                </li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
