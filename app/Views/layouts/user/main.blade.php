<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=!empty($title)?$title.'-'.site_config("site_title","author"):site_config("site_title","author")?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="author" content="<?=site_config('site_description','author')?>">
  <meta name="description" content="<?=site_config('site_description','Site desc')?>">
  <meta name="theme-color" content="#303030">
  <meta property="og:url" content="<?= current_url(true)?>">
  <meta property="og:site_name" content="<?=site_config("site_name","My Site")?>">
  <meta property="og:locale" content="en_US">
  <link rel="shortcut icon" href="<?=get_logo(true);?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { 50:'#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 300:'#a5b4fc', 400:'#818cf8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' },
            sidebar: { bg:'#1e293b', hover:'#334155', active:'#4f46e5' }
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
    .q-spinner { width:40px; height:40px; border:4px solid #e5e7eb; border-top-color:#6366f1; border-radius:50%; animation:qspin .8s linear infinite; }
    @keyframes qspin { to { transform:rotate(360deg); } }
  </style>

  <script type="text/javascript">
      var token = '<?= csrf_hash() ?>',PATH = '<?=base_url()?>',user='user';
      function toRelativeUrl(url) {
        try { 
          if (url.startsWith('http')) return new URL(url).pathname + new URL(url).search;
          return url;
        } catch(e) { return url; }
      }
  </script>
</head>

<body class="bg-gray-100">
  <div id="page-overlay"><div class="q-spinner"></div></div>

  <?php include 'elements/sidebar.php'; ?>
  <?php include 'elements/navbar.php'; ?>

  <main class="lg:ml-64 pt-16 min-h-screen">
    <div class="p-4 lg:p-6">
      <?=view($view);?>
    </div>
  </main>

  <?=script_asset('js/qpay-alpine.js')?>

  <?php if ($msg = session()->getFlashdata('message')) : ?>
      <script type="text/javascript">
          notify('<?= esc($msg['message']) ?>', '<?= esc($msg['status']) ?>');
      </script>
  <?php endif; ?>

  <?php if (get_option('enable_panel_notification_popup') == 1 && get_cookie('panel_popup') != 1) : ?>
      <?php set_cookie("panel_popup", "1", 180); ?>
      <div x-data="{ showAnnouncement: true }" x-show="showAnnouncement" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4">
          <div class="bg-white rounded-xl shadow-2xl w-full max-w-md" @click.outside="showAnnouncement = false">
              <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                  <h5 class="text-lg font-semibold text-gray-800">Announcement</h5>
                  <button @click="showAnnouncement = false" class="text-gray-400 hover:text-gray-600">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                  </button>
              </div>
              <div class="p-5 text-sm text-gray-600">
                  <?= get_option('notification_popup_panel_content') ?>
              </div>
          </div>
      </div>
  <?php endif; ?>

  <?php echo htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES); ?>

</body>
</html>
