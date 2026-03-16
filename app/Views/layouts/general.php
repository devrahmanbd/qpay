<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= !empty($title) ? $title . ' - ' . site_config("site_name", "QPay") : site_config("site_title", "QPay - Payment Gateway") ?></title>
  <meta name="description" content="<?= site_config('site_description', 'QPay Payment Gateway') ?>">
  <meta name="keywords" content="<?= site_config('site_keywords', 'payment gateway') ?>">
  <link rel="icon" type="image/png" href="<?= get_logo(true) ?>">
  <link rel="canonical" href="<?= base_url() ?>">

  <?= link_asset('frontend/vendor/bootstrap/css/bootstrap.min.css') ?>
  <?= link_asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') ?>
  <?= link_asset('frontend/vendor/aos/aos.css') ?>
  <?= link_asset('frontend/vendor/glightbox/css/glightbox.min.css') ?>
  <?= link_asset('frontend/vendor/swiper/swiper-bundle.min.css') ?>
  <?= link_asset('frontend/css/style.css') ?>
</head>

<body>

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="<?= base_url() ?>" class="logo d-flex align-items-center me-auto">
        <img src="<?= get_logo() ?>" alt="<?= site_config('site_name', 'QPay') ?>">
        <h1 class="sitename"><?= site_config('site_name', 'QPay') ?></h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?= base_url() ?>" class="<?= segment(1) == '' ? 'active' : '' ?>">Home</a></li>
          <li><a href="<?= base_url('developers') ?>" class="<?= segment(1) == 'developers' ? 'active' : '' ?>">API Docs</a></li>
          <li><a href="<?= base_url('blogs') ?>" class="<?= segment(1) == 'blogs' ? 'active' : '' ?>">Blog</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted" href="<?= base_url('sign-in') ?>">Sign In</a>
    </div>
  </header>

  <main class="main">
    <?= view($view) ?>
  </main>

  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
            <span class="sitename"><?= site_config('site_name', 'QPay') ?></span>
          </a>
          <p><?= site_config('site_description', 'Your reliable payment gateway solution.') ?></p>
          <div class="social-links d-flex mt-4">
            <?php if (site_config('social_twitter_link', '') && site_config('social_twitter_link') != '#') : ?>
              <a href="<?= site_config('social_twitter_link') ?>"><i class="bi bi-twitter-x"></i></a>
            <?php endif; ?>
            <?php if (site_config('social_facebook_link', '') && site_config('social_facebook_link') != '#') : ?>
              <a href="<?= site_config('social_facebook_link') ?>"><i class="bi bi-facebook"></i></a>
            <?php endif; ?>
            <?php if (site_config('social_instagram_link', '') && site_config('social_instagram_link') != '#') : ?>
              <a href="<?= site_config('social_instagram_link') ?>"><i class="bi bi-instagram"></i></a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-lg-2 col-6 footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('sign-in') ?>">Sign In</a></li>
            <li><a href="<?= base_url('sign-up') ?>">Sign Up</a></li>
            <li><a href="<?= base_url('developers') ?>">API Docs</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-6 footer-links">
          <h4>Legal</h4>
          <ul>
            <li><a href="<?= base_url('terms-condition') ?>">Terms of Service</a></li>
            <li><a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p><?= site_config('address', '') ?></p>
          <p class="mt-4"><strong>Phone:</strong> <span><?= site_config('contact_tel', '') ?></span></p>
          <p><strong>Email:</strong> <span><?= site_config('contact_email', '') ?></span></p>
        </div>
      </div>
    </div>
    <div class="container copyright text-center mt-4">
      <p>&copy; <?= date('Y') ?> <strong class="px-1 sitename"><?= site_config('site_name', 'QPay') ?></strong>. <?= site_config('copy_right_content', 'All rights reserved.') ?></p>
    </div>
  </footer>

  <?= script_asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>
  <?= script_asset('frontend/vendor/php-email-form/validate.js') ?>
  <?= script_asset('frontend/vendor/aos/aos.js') ?>
  <?= script_asset('frontend/vendor/glightbox/js/glightbox.min.js') ?>
  <?= script_asset('frontend/vendor/purecounter/purecounter_vanilla.js') ?>
  <?= script_asset('frontend/vendor/isotope-layout/isotope.pkgd.min.js') ?>
  <?= script_asset('frontend/vendor/swiper/swiper-bundle.min.js') ?>
  <?= script_asset('frontend/js/main.js') ?>
</body>

</html>
