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

  <?=link_asset('blithe/css/app.min.css');?>
  <?=link_asset('blithe/css/style.css');?>
  <?=link_asset('js/jquery-toast/css/jquery.toast.css')?>
  <?=link_asset('js/select2/css/select2.min.css')?>
  <?=link_asset('blithe/css/components.css');?>
  <?=link_asset('blithe/css/jqvmap.min.css');?>

  <style>
    [x-cloak] { display: none !important; }
    #page-overlay { display:none; position:fixed; inset:0; background:rgba(255,255,255,.7); z-index:9998; align-items:center; justify-content:center; }
    #page-overlay.active { display:flex; }
    .q-spinner { width:40px; height:40px; border:4px solid #e5e7eb; border-top-color:#6366f1; border-radius:50%; animation:qspin .8s linear infinite; }
    @keyframes qspin { to { transform:rotate(360deg); } }
  </style>

  <?=script_asset("blithe/js/app.min.js");?>
  <script type="text/javascript">
      var token = '<?= csrf_hash() ?>',PATH = '<?=base_url()?>',user='user';
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

  <?=script_asset("blithe/js/scripts.js");?>

  <?=script_asset('js/notify.min.js')?>
  <?=script_asset('js/tinymce/tinymce.min.js')?>
  <?=script_asset('js/jquery-toast/js/jquery.toast.js')?>
  <?=script_asset('js/process2.js')?>
  <?=script_asset('js/general.js')?>
  <?=script_asset('js/select2/js/select2.full.min.js')?>
  <?=script_asset('js/admin.js')?>
  <?=script_asset('js/jquery-upload/js/vendor/jquery.ui.widget.js')?>
  <?=script_asset('js/jquery-upload/js/jquery.iframe-transport.js')?>
  <?=script_asset('js/jquery-upload/js/jquery.fileupload.js')?>

  <?php if ($msg = session()->getFlashdata('message')) : ?>
      <script type="text/javascript">
          notify('<?= esc($msg['message']) ?>', '<?= esc($msg['status']) ?>');
      </script>
  <?php endif; ?>

  <div id="modal-ajax" class="modal fade"></div>

  <?=script_asset('js/jquery-ui.min.js')?>
  <?=script_asset('js/blithe.js')?>

  <?php if (get_option('enable_panel_notification_popup') == 1 && get_cookie('panel_popup') != 1) : ?>
      <?php set_cookie("panel_popup", "1", 180); ?>
      <div class="modal zoom-in" id="notification" tabindex="-1" aria-labelledby="notificationLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="notificationLabel">
                          <span>Announcement</span>
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <?= get_option('notification_popup_panel_content') ?>
                  </div>
              </div>
          </div>
      </div>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              setTimeout(function() {
                  var notificationModal = new bootstrap.Modal(document.getElementById('notification'));
                  notificationModal.show();
              }, 500);
          });
      </script>
  <?php endif; ?>

  <?php echo htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES); ?>

</body>
</html>
