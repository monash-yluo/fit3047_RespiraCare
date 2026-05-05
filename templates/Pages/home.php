<?php

/** @var array<array> $copdSteps */
/** @var array<array> $specialists */

$this->setLayout('landing');
$this->assign('title', 'Respira Care');
?>

<!-- Hero Section -->
<section id="hero" class="hero section">
    <div class="container">
        <div class="row gy-4 justify-content-between align-items-center">
            <div class="col-lg-6 order-lg-last hero-img text-center">
                <?= $this->Html->image('landing-hero.png', [
                    'class' => 'img-fluid',
                    'alt' => 'RespiraCare Remote Monitoring Doctors',
                    'style' => 'max-height: 400px;',
                ]) ?>
            </div>

            <div class="col-lg-5 d-flex flex-column justify-content-center">
                <?= $this->ContentBlock->html('home-hero-title') ?>
                <p class="mb-4">
                    <?= h($this->ContentBlock->text('home-hero-description')) ?>
                </p>
                <div class="d-flex">
                    <a href="<?= $this->Url->build(['controller' => 'ContactMessages', 'action' => 'contact']) ?>"
                       class="btn text-white rounded-pill px-4 py-2 shadow-sm fw-bold"
                       style="background-color: #305BAB; border: none; transition: 0.3s;">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section id="process" class="section dark-background">
    <div class="container">
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="text-white fw-bold">
                    <?= h($this->ContentBlock->text('home-process-title')) ?>
                </h2>
            </div>
        </div>

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
                <?php
                $stepTitles = array_map('trim', explode('|', $this->ContentBlock->text('home-process-step-titles')));
                $stepDescriptions = array_map('trim', explode('|', $this->ContentBlock->text('home-process-step-descriptions')));
                $stepCount = min(count($stepTitles), count($stepDescriptions));
                ?>

                <?php for ($i = 0; $i < $stepCount; $i++) : ?>
                    <div class="col-md-4 d-flex align-items-start">
                        <div class="border border-2 border-white rounded-circle d-flex
                            align-items-center justify-content-center me-3 flex-shrink-0"
                            style="width: 50px; height: 50px; font-size: 1.25rem; font-weight: bold;">
                            <?= h((string)($i + 1)) ?>
                        </div>
                        <div>
                            <p class="mb-0 text-white-50 lh-lg">
                                <strong class="text-white"><?= h($stepTitles[$i]) ?></strong>
                                <?= h($stepDescriptions[$i]) ?>
                            </p>
                        </div>
                    </div>

                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- Feature Section -->
<section id="feature-details" class="feature-details section">
    <div class="container">
        <div class="row gy-4 align-items-center">

            <div class="col-md-6 d-flex justify-content-center" data-aos="zoom-out" data-aos-delay="100">
                <?= $this->Html->image('landing-feature.svg', [
                    'class' => 'img-fluid',
                    'alt' => 'RespiraCare Features Dashboard',
                    'style' => 'max-height: 350px;',
                ]) ?>
            </div>

            <div class="col-md-6 ps-md-5" data-aos="fade-up" data-aos-delay="100">
                <?= $this->ContentBlock->html('home-feature-details') ?>
            </div>

        </div>
    </div>
</section>

<section id="doctors" class="section pt-0">

    <div class="w-100 px-4 d-flex flex-column align-items-center text-center"
         style="background-color: var(--light-accent-color); padding: 80px 0 120px 0;"
         data-aos="fade-up">
        <?= $this->ContentBlock->html('home-doctors-header') ?>
    </div>

    <div class="container position-relative"
         style="margin-top: -80px; z-index: 2;">

        <div class="row gy-4 dark-background py-5 rounded-top-2"
             style="background-color: var(--background-color);  padding-inline: 96px;">
            <?php for ($i = 1; $i <= 3; $i++) : ?>
                <?php $doctorImagePath = $this->ContentBlock->imagePath("doctor-image-{$i}"); ?>
                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="<?= h((string)($i * 100)) ?>">
                    <div class="card h-100 text-center px-4 py-5 border-0 shadow text-dark rounded-3 lh-lg">
                        
                        <?php if (!empty($doctorImagePath)): ?>
                            <div class="mx-auto mb-4 shadow-sm rounded-circle bg-white dark:bg-gray-800 overflow-hidden border border-gray-200 dark:border-gray-600"
                                 style="width: 120px; height: 120px;">
                                <?= $this->ContentBlock->image("doctor-image-{$i}", [
                                    'class' => 'w-full h-full object-cover',
                                    'alt' => h($this->ContentBlock->text("doctor-name-{$i}")),
                                    'style' => 'width: 120px; height: 120px; object-fit: cover;',
                                ]) ?>
                            </div>
                        <?php else: ?>
                            <div class="mx-auto mb-4 shadow-sm rounded-circle bg-light d-flex align-items-center justify-content-center border"
                                 style="width: 120px; height: 120px;">
                                <svg class="text-secondary" style="width: 3rem; height: 3rem;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <h5 class="fw-bold text-muted mb-1"><?= h($this->ContentBlock->text("doctor-name-{$i}")) ?></h5>
                        <p class="small text-muted mb-0"><?= h($this->ContentBlock->text("doctor-description-{$i}")) ?></p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <div class="row align-items-center px-4 py-5 rounded-bottom-2"
             style="background-color: var(--secondary-accent-color)">

            <div class="col-md-8 mb-4 mb-md-0">
                <p class="mb-0 lh-lg">
                    <?= h($this->ContentBlock->text('home-doctors-cta-text')) ?>
                </p>
            </div>
            <div class="col-md-4 d-flex flex-column align-self-end align-items-center">
                <a href="<?= $this->Url->build(['controller' => 'ContactMessages', 'action' => 'contact']) ?>"
                   class="btn rounded-2 px-5 py-2 w-75 text-white dark-background"
                   style="background-color: var(--background-color);">
                    Enquire
                </a>
            </div>
        </div>
    </div>
</section>
