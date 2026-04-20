<!doctype html>
<html lang="en">

<head>
    <title><?= !empty($title) ? $title . '-' . get_option("site_title", "author") : get_option("site_title", "author") ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="author" content="<?= get_option('site_description', 'author') ?>">
    <meta name="description" content="<?= get_option('site_description', 'Site desc') ?>">
    <meta name="theme-color" content="#303030">
    <meta name="keywords" content="<?= get_option('site_keywords', "keywords") ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= !empty($title) ? $title . '-' . get_option("site_title", "author") : get_option("site_title", "author") ?>">
    <meta property="og:description" content="<?= get_option('site_description', 'Site desc') ?>">
    <meta property="og:image" content="<?= BASE_SITE . get_option('site_icon') ?>">
    <meta property="og:url" content="<?= BASE_SITE; ?>">
    <meta property="og:site_name" content="<?= get_option("site_name", "My Site") ?>">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:card" content="<?= BASE_SITE . get_option('site_icon') ?>">
    <meta name="twitter:url" content="<?= BASE_SITE . get_option('site_icon') ?>">
    <meta name="twitter:title" content="<?= !empty($title) ? $title . '-' . get_option("site_title", "author") : get_option("site_title", "author") ?>">
    <meta name="twitter:image" content="<?= BASE_SITE . get_option('site_icon') ?>">
    <link rel="icon" type="image/png" href="<?= BASE_SITE . get_option('site_icon') ?>" />
    <link rel="apple-touch-icon" type="image/png" sizes="76x76" href="/favicon.png?width=76" />
    <link rel="mask-icon" href="<?= BASE_SITE . get_option('site_icon') ?>" color="#5bbad5" />
    <link rel="canonical" href="<?= base_url() ?>">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="<?= base_url('public/assets/css/404.css') ?>" />


</head>

<body>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Oops!</h1>
            </div>
            <h2>404 - Page not found</h2>
            <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
            <a href="<?= base_url() ?>">Go To Homepage</a>
        </div>
    </div>
</body>

</html>