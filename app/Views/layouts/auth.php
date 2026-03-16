<!doctype html>
<html lang="en">

<head>
   <title><?= !empty($title) ? $title . '-' . site_config("site_title", "author") : site_config("site_title", "author") ?></title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
   <meta name="author" content="<?= site_config('site_description', 'author') ?>">
   <meta name="description" content="<?= site_config('site_description', 'Site desc') ?>">
   <meta name="theme-color" content="#303030">
   <meta name="keywords" content="<?= site_config('site_keywords', "keywords") ?>">
   <meta property="og:type" content="website">
   <meta property="og:title" content="<?= !empty($title) ? $title . '-' . site_config("site_title", "author") : site_config("site_title", "author") ?>">
   <meta property="og:description" content="<?= site_config('site_description', 'Site desc') ?>">
   <meta property="og:image" content="<?= get_logo() ?>">
   <meta property="og:url" content="<?= current_url(true) ?>">
   <meta property="og:site_name" content="<?= site_config("site_name", "My Site") ?>">
   <meta property="og:locale" content="en_US">
   <meta name="twitter:card" content="<?= get_logo() ?>">
   <meta name="twitter:url" content="<?= current_url(true) ?>">
   <meta name="twitter:title" content="<?= !empty($title) ? $title . '-' . site_config("site_title", "author") : site_config("site_title", "author") ?>">
   <meta name="twitter:image" content="<?= get_logo() ?>">
   <link rel="icon" type="image/png" href="<?= get_logo(true) ?>" />
   <link rel="apple-touch-icon" type="image/png" sizes="76x76" href="<?= get_logo() ?>" />
   <link rel="mask-icon" href="<?= get_logo() ?>" color="#5bbad5" />
   <link rel="canonical" href="<?= base_url() ?>">
   <script src="https://cdn.tailwindcss.com"></script>
   <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: { 50:'#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 300:'#a5b4fc', 400:'#818cf8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' }
            }
          }
        }
      }
   </script>
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
   <style>
      [x-cloak] { display: none !important; }
      #page-overlay { display:none; position:fixed; inset:0; background:rgba(255,255,255,.7); z-index:9998; align-items:center; justify-content:center; }
      #page-overlay.active { display:flex; }
      #page-overlay .spinner { width:40px; height:40px; border:4px solid #e5e7eb; border-top-color:#6366f1; border-radius:50%; animation:spin .8s linear infinite; }
      @keyframes spin { to { transform:rotate(360deg); } }
   </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
   <div id="page-overlay"><div class="spinner"></div></div>

   <?= view($view); ?>

   <script>
      var token = '<?= csrf_hash() ?>', PATH = '<?= base_url() ?>', user = '';
   </script>
   <?= script_asset('js/app.js') ?>
   <?php if ($msg = session()->getFlashdata('message')) : ?>
      <script type="text/javascript">
         notify('<?= esc($msg['message']) ?>', '<?= esc($msg['status']) ?>');
      </script>
   <?php endif; ?>
</body>

</html>
