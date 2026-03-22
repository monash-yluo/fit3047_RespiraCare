<?php

/** @var \App\Model\Entity\ContactMessage $message */

$this->setLayout('landing');
$this->assign('title', 'Contact Us | Respira Care');
?>

<div class="text-center py-5">
    <div class="container py-5" data-aos="fade-up">
        <h1 class="fw-bold mb-3 display-4">Contact RespiraCare</h1>
        <p class="lead mb-0">Pioneering the future of remote COPD management.</p>
    </div>
</div>

<section id="contact" class="contact section pb-5 pt-2">
    <div class="container my-4" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">

            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">

                    <h3 class="fw-bold mb-4" style="color: #305BAB;">Send us a message</h3>
                    <p class="text-muted mb-4">
                        Whether you are a current patient experiencing issues with your vitals tracking,
                        or a new patient looking to join our remote monitoring program, our team is here to help.
                    </p>

                    <?= $this->Form->create($message, ['class' => 'needs-validation']) ?>

                    <div class="row gy-4">
                        <div class="col-md-6">
                            <?= $this->Form->control('first_name', [
                                'class' => 'form-control',
                                'label' => ['text' => 'First Name', 'class' => 'fw-bold small text-muted mb-1'],
                                'placeholder' => 'John',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('last_name', [
                                'class' => 'form-control',
                                'label' => ['text' => 'Last Name', 'class' => 'fw-bold small text-muted mb-1'],
                                'placeholder' => 'Doe',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('email', [
                                'type' => 'email',
                                'class' => 'form-control',
                                'label' => ['text' => 'Email Address', 'class' => 'fw-bold small text-muted mb-1'],
                                'placeholder' => 'john.doe@example.com',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('category', [
                                'type' => 'select',
                                'class' => 'form-select',
                                'label' => [
                                    'text' => 'How can we help you?',
                                    'class' => 'fw-bold small text-muted mb-1',
                                ],
                                'options' => [
                                    'General Inquiry' => 'General Inquiry',
                                    'Platform Support' => 'Platform Support (App/Website Issues)',
                                    'Medical Concern' => 'Medical Concern / Symptom Update',
                                    'New Patient Enrollment' => 'New Patient Enrollment',
                                ],
                                'empty' => 'Please select a category...',
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('message', [
                                'type' => 'textarea',
                                'class' => 'form-control',
                                'label' => ['text' => 'Your Message', 'class' => 'fw-bold small text-muted mb-1'],
                                'rows' => 6,
                                'placeholder' => 'Please describe your inquiry or symptoms here...',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="col-12 mt-4 text-center">
                            <?= $this->Form->button(__('Send Message'), [
                                'class' => 'btn text-white fw-bold rounded-pill px-5 py-3 w-100 shadow-sm',
                                'style' => 'background-color: #305BAB; border: none; font-size: 1.1rem;',
                            ]) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

        </div>
    </div>
</section>
