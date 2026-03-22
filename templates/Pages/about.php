<?php
$this->setLayout('landing');
$this->assign('title', 'About Us | Respira Care');
?>

<div class="text-center py-5">
    <div class="container py-5" data-aos="fade-up">
        <h1 class="fw-bold mb-3 display-4">About RespiraCare</h1>
        <p class="lead mb-0">Pioneering the future of remote COPD management.</p>
    </div>
</div>

<section id="about" class="about section py-5">
    <div class="container my-4">
        <div class="row gy-5 align-items-center">

            <div class="col-lg-6 pe-lg-5" data-aos="fade-up" data-aos-delay="100">
                <span class="fw-bold text-uppercase small"
                      style="color: #305BAB; letter-spacing: 1.5px;">
                    Our Mission
                </span>

                <h2 class="fw-bold mb-4 mt-2 display-6">Empowering Patients. <br>Redefining Respiratory Care.</h2>

                <p class="mb-4 lh-lg fs-5">
                    Founded by certified physicians specialising in Chronic Obstructive Pulmonary Disease (COPD),
                    RespiraCare Online was built on a simple premise: managing a chronic lung condition should not mean
                    living in a waiting room.
                </p>
                <p class="mb-5 lh-lg">
                    Our platform allows patients to easily input vital data—such as lung function, oxygen saturation,
                    and daily symptoms—directly from home. By seamlessly connecting this data to specialised clinicians,
                    we provide real-time remote monitoring, personalised treatment adjustments, and total peace of mind.
                </p>

                <a href="<?= $this->Url->build('/contact') ?>"
                   class="btn text-white rounded-pill px-5 py-3 shadow-sm fw-bold"
                   style="background-color: #305BAB; border: none; transition: 0.3s;">
                    Get in Touch
                </a>
            </div>

            <!-- https://www.pexels.com/zh-cn/photo/6129507/ -->
            <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
                <?= $this->Html->image('about-clinic.jpg', [
                    'class' => 'img-fluid rounded-4 shadow-lg w-100',
                    'alt' => 'RespiraCare Virtual Clinic',
                    'style' => 'object-fit: cover; min-height: 400px;',
                ]) ?>
            </div>

        </div>
    </div>
</section>

