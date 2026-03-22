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
            <ul>
                <li>
                    <a href="<?= $this->Url->build('/') ?>" class="active">Home</a>
                </li>
                <li>
                    <a href="<?= $this->Url->build('/about') ?>">About</a>
                </li>
                <li>
                    <a href="<?= $this->Url->build('/contact') ?>">Contact</a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">Login</a>
                </li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
