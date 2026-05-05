<?php
$this->setLayout('landing');
$this->assign('title', 'About Us | Respira Care');
?>

<div class="text-center py-5">
    <div class="container py-5" data-aos="fade-up">
        <?= $this->ContentBlock->html('about-hero') ?>
    </div>
</div>

<section id="about" class="about section py-5">
    <div class="container my-4">
        <div class="row gy-5 align-items-center">

            <div class="col-lg-6 pe-lg-5" data-aos="fade-up" data-aos-delay="100">
                <?= $this->ContentBlock->html('about-mission') ?>

                <a href="<?= $this->Url->build(['controller' => 'ContactMessages', 'action' => 'contact']) ?>"
                   class="btn text-white rounded-pill px-5 py-3 shadow-sm fw-bold"
                   style="background-color: #305BAB; border: none; transition: 0.3s;">
                    Get in Touch
                </a>
            </div>

            <!-- https://www.pexels.com/zh-cn/photo/6129507/ -->
            <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
                <?= $this->ContentBlock->image('about-clinic-image', [
                    'class' => 'img-fluid rounded-4 shadow-lg w-100',
                    'alt' => 'RespiraCare Virtual Clinic',
                    'style' => 'object-fit: cover; min-height: 400px;',
                ]) ?>
            </div>

        </div>
    </div>
</section>

