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
   <script>
      var _csrfToken = '<?= csrf_hash() ?>';
      var _basePath = '<?= base_url() ?>';

      var _toastContainer = null;
      function _ensureToastContainer() {
        if (_toastContainer) return _toastContainer;
        _toastContainer = document.createElement('div');
        _toastContainer.style.cssText = 'position:fixed;top:16px;right:16px;z-index:99999;display:flex;flex-direction:column;gap:8px;max-width:360px;';
        document.body.appendChild(_toastContainer);
        return _toastContainer;
      }
      function notify(message, type) {
        var c = _ensureToastContainer();
        var colors = {
          success: { bg: '#059669', icon: '\u2713' },
          error: { bg: '#dc2626', icon: '\u2717' },
          warning: { bg: '#d97706', icon: '\u26A0' },
          info: { bg: '#2563eb', icon: '\u2139' }
        };
        var s = colors[type] || colors.info;
        var t = document.createElement('div');
        t.style.cssText = 'display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:8px;color:#fff;font-size:14px;font-family:system-ui,sans-serif;box-shadow:0 4px 12px rgba(0,0,0,.15);opacity:0;transform:translateX(40px);transition:all .3s ease;background:' + s.bg;
        t.innerHTML = '<span style="flex-shrink:0;font-size:18px">' + s.icon + '</span><span style="flex:1">' + message + '</span><button onclick="this.parentElement.remove()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:18px">&times;</button>';
        c.appendChild(t);
        requestAnimationFrame(function() { t.style.opacity='1'; t.style.transform='translateX(0)'; });
        setTimeout(function() { t.style.opacity='0'; t.style.transform='translateX(40px)'; setTimeout(function(){ if(t.parentElement) t.remove(); }, 300); }, 3500);
      }

      function authForm() {
        return {
          loading: false,
          async submitForm(e) {
            this.loading = true;
            var overlay = document.getElementById('page-overlay');
            if (overlay) overlay.classList.add('active');
            var form = e.target;
            var action = form.getAttribute('action');
            try { action = new URL(action).pathname; } catch(ex) {}
            var redirectUrl = form.dataset.redirect || '';
            var formData = new FormData(form);
            if (!formData.has('token')) formData.append('token', _csrfToken);
            try {
              var resp = await fetch(action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(formData).toString(),
                credentials: 'same-origin'
              });
              var ct = resp.headers.get('content-type') || '';
              var result;
              if (ct.indexOf('application/json') !== -1) {
                result = await resp.json();
              } else {
                var txt = await resp.text();
                try { result = JSON.parse(txt); } catch(ex) { result = txt; }
              }
              if (overlay) overlay.classList.remove('active');
              this.loading = false;
              if (typeof result === 'object') {
                notify(result.message, result.status);
                if (result.redirect) {
                  setTimeout(function() { window.location = result.redirect; }, 2000);
                } else if (result.status === 'success' && redirectUrl) {
                  setTimeout(function() { window.location = redirectUrl; }, 2000);
                }
              } else {
                var rn = document.getElementById('result_notification');
                if (rn) rn.innerHTML = result;
              }
            } catch(err) {
              if (overlay) overlay.classList.remove('active');
              this.loading = false;
              notify('An error occurred. Please try again.', 'error');
            }
          }
        };
      }
   </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
   <div id="page-overlay"><div class="spinner"></div></div>

   <?= view($view); ?>

   <?php if ($msg = session()->getFlashdata('message')) : ?>
      <script>notify('<?= esc($msg['message']) ?>', '<?= esc($msg['status']) ?>');</script>
   <?php endif; ?>
</body>

</html>
