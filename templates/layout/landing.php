<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= $this->fetch('title') ?> - Respira Care</title>

    <?= $this->Html->css([
        '/vendor/bootstrap/css/bootstrap.min.css',
        '/vendor/bootstrap-icons/bootstrap-icons.css',
        '/vendor/aos/aos.css',
        '/vendor/glightbox/css/glightbox.min.css',
        '/vendor/swiper/swiper-bundle.min.css',
        'landing.css',
    ]) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body class="index-page">

<?= $this->element('landing_header') ?>

<main class="main">
    <?= $this->fetch('content') ?>
</main>

<?= $this->element('landing_footer') ?>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<?= $this->Html->script([
    '/vendor/bootstrap/js/bootstrap.bundle.min.js',
    '/vendor/aos/aos.js',
    '/vendor/glightbox/js/glightbox.min.js',
    '/vendor/purecounter/purecounter_vanilla.js',
    '/vendor/imagesloaded/imagesloaded.pkgd.min.js',
    '/vendor/isotope-layout/isotope.pkgd.min.js',
    '/vendor/swiper/swiper-bundle.min.js',
    'landing.js',
]) ?>

<?= $this->fetch('script') ?>

</body>
</html>
