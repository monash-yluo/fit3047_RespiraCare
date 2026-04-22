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
                <h1 class="fs-2 mb-3">Your Dedicated Partner in <br><span>COPD Management</span></h1>
                <p class="mb-4">
                    Log your daily vitals, receive personalised reminders,
                    and get expert respiratory support exactly when you need it.
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
                <h2 class="text-white fw-bold">Simple, Remote COPD Management</h2>
            </div>
        </div>

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
                <?php foreach ($copdSteps as $step) : ?>
                    <div class="col-md-4 d-flex align-items-start">
                        <div class="border border-2 border-white rounded-circle d-flex
                            align-items-center justify-content-center me-3 flex-shrink-0"
                            style="width: 50px; height: 50px; font-size: 1.25rem; font-weight: bold;">
                            <?= h($step['number']) ?>
                        </div>
                        <div>
                            <p class="mb-0 text-white-50 lh-lg">
                                <strong class="text-white"><?= h($step['title']) ?></strong>
                                <?= h($step['description']) ?>
                            </p>
                        </div>
                    </div>

                <?php endforeach; ?>
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
                <h3 class="fw-bold mb-4">Empowering Your Respiratory Health</h3>
                <p>
                    Managing Chronic Obstructive Pulmonary Disease shouldn't require constant
                    hospital visits. RespiraCare brings the clinic to your living room.
                </p>
                <p>
                    Our intuitive platform allows you to securely input your daily health data, providing your
                    specialised care team with the real-time insights they need to monitor your condition.
                </p>
                <p>
                    With automated reminders, we are dedicated to helping you stay proactive
                    about your lung health and preventing flare-ups before they happen.
                </p>
            </div>

        </div>
    </div>
</section>

<section id="doctors" class="section pt-0">

    <div class="w-100 px-4 d-flex flex-column align-items-center text-center"
         style="background-color: var(--light-accent-color); padding: 80px 0 120px 0;"
         data-aos="fade-up">
        <h2 class="text-white fw-bold mb-3">Meet Our Certified Specialists</h2>
        <p class="text-white-50 col-lg-8 mb-0">
            Our dedicated team of certified physicians and pulmonologists specialise in
            advanced COPD management, ensuring you receive the highest standard of virtual respiratory care.
        </p>
    </div>

    <div class="container position-relative"
         style="margin-top: -80px; z-index: 2;">

        <div class="row gy-4 dark-background py-5 rounded-top-2"
             style="background-color: var(--background-color);  padding-inline: 96px;">
            <?php foreach ($specialists as $doc) : ?>
                <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="<?= h($doc['delay']) ?>">
                    <div class="card h-100 text-center px-4 py-5 border-0 shadow text-dark rounded-3 lh-lg">

                        <?php if (!empty($doc['image_url'])): ?>
                            <?= $this->Html->image('users/' . $doc['image_url'], [
                                'class' => 'image-loading-placeholder rounded-circle mx-auto mb-4 shadow-sm',
                                'loading' => 'lazy',
                                'alt' => $doc['name'],
                                'style' => 'width: 120px; height: 120px; object-fit: cover;',
                            ]) ?>
                        <?php else: ?>
                            <div class="mx-auto mb-4 shadow-sm rounded-circle bg-light d-flex align-items-center justify-content-center border"
                                 style="width: 120px; height: 120px;">
                                <svg class="text-secondary" style="width: 3rem; height: 3rem;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <h5 class="fw-bold text-muted mb-1"><?= h($doc['name']) ?></h5>
                        <p class="small text-muted mb-0"><?= h($doc['desc']) ?></p>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row align-items-center px-4 py-5 rounded-bottom-2"
             style="background-color: var(--secondary-accent-color)">

            <div class="col-md-8 mb-4 mb-md-0">
                <p class="mb-0 lh-lg">
                    Ready to take control of your COPD? Reach out to our team to learn more about how the RespiraCare
                    platform can support your daily health journey. Whether you need help setting up your remote vitals
                    monitoring, or have questions about connecting with our certified specialists, we are here to help.
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
