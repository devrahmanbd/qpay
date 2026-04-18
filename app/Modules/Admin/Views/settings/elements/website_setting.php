<?php
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-globe text-gray-400 mr-1"></i> <?= lan("website_setting") ?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <input type="hidden" name="update_file" value="1">
  <div class="p-5 space-y-6">

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"><?= lan("Maintenance_mode") ?></label>
      <label class="relative inline-flex items-center cursor-pointer mb-2">
        <input type="hidden" name="is_maintenance_mode" value="0">
        <input type="checkbox" name="is_maintenance_mode" class="sr-only peer" <?= (get_option("is_maintenance_mode", 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600"><?= lan("Active") ?></span>
      </label>
      <div class="mb-2">
        <input type="datetime-local" name="maintenance_mode_time" value="<?= get_option('maintenance_mode_time'); ?>" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
      </div>
      <p class="text-xs text-red-500"><strong><?= lan("note") ?></strong> <?= lan("link_to_access_the_maintenance_mode") ?></p>
      <a href="<?= base_url('maintenance/access') ?>" class="text-xs text-primary-600 hover:underline"><?= base_url('maintenance/access') ?></a>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("enable_https") ?></h5>
      <label class="relative inline-flex items-center cursor-pointer mb-1">
        <input type="hidden" name="enable_https" value="0">
        <input type="checkbox" name="enable_https" class="sr-only peer" <?= (get_option("enable_https", 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600"><?= lan("Active") ?></span>
      </label>
      <p class="text-xs text-red-500"><strong><?= lan("note") ?></strong> <?= lan("note_please_make_sure_the_ssl_certificate_has_the_active_status_in_your_hosting_before__you_activate") ?></p>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("site_settings") ?></h5>
      <?php
      $toggles = [
        ['optimize', 'Site Optimizer', 1],
        ['google_login', 'enable_google_login', 1],
        ['enable_google_translator', 'Enable Google translator', 0],
        ['enable_kyc', 'Enable KYC for user', 0],
        ['preloader', 'Enable Preloader', 0],
      ];
      foreach ($toggles as $t): ?>
      <label class="relative inline-flex items-center cursor-pointer mb-2">
        <input type="hidden" name="<?=$t[0]?>" value="0">
        <input type="checkbox" name="<?=$t[0]?>" class="sr-only peer" <?= (get_option($t[0], $t[2]) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600"><?= lan($t[1]) ?></span>
      </label><br>
      <?php endforeach; ?>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-bug mr-1"></i> Global Debug Mode</h5>
      <label class="relative inline-flex items-center cursor-pointer mb-1">
        <input type="hidden" name="global_debug" value="0">
        <input type="checkbox" name="global_debug" class="sr-only peer" <?= (get_option("global_debug", 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600">Active</span>
      </label>
      <p class="text-xs text-gray-500"><strong>Note:</strong> When active, administrators can append <code>?debug=enable</code> to any URL to see detailed error logs and performance metrics.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("google_Auth_Client_Id") ?></label>
        <textarea rows="1" name="google_auth_clientId" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?= get_option('google_auth_clientId', lang("google_Auth_Client_Id")) ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("google_Auth_ClientSecret") ?></label>
        <textarea rows="1" name="google_auth_clientSecret" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?= get_option('google_auth_clientSecret', lang("google_Auth_ClientSecret")) ?></textarea>
      </div>
    </div>

    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("site_name") ?></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="site_name" value="<?= get_option('site_name', "name") ?>">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("site_description") ?></label>
        <textarea rows="3" name="site_description" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?= get_option('site_description', "Description") ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("address") ?></label>
        <textarea rows="3" name="address" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?= get_option('address', "Your address") ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("site_keywords") ?></label>
        <textarea rows="3" name="site_keywords" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?= get_option('site_keywords', "site_keywords") ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("site_title") ?></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="site_title" value="<?= get_option('site_title', "Title") ?>">
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> Google reCAPTCHA</h5>
      <label class="relative inline-flex items-center cursor-pointer mb-3">
        <input type="hidden" name="enable_google_recaptcha" value="0">
        <input type="checkbox" name="enable_google_recaptcha" class="sr-only peer" <?=(get_option("enable_google_recaptcha", 0) == 1) ? "checked" : ""?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600">Active</span>
      </label>
      <div class="space-y-3">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Google reCAPTCHA site key</label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="google_capcha_site_key" value="<?=get_option('google_capcha_site_key', '')?>">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Google reCAPTCHA secret key</label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="google_capcha_secret_key" value="<?=get_option('google_capcha_secret_key', '')?>">
        </div>
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("social_media_links") ?></h5>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php
        $socials = [
          ['Github', 'social_github_link', 'https://www.github.com/'],
          ['Facebook', 'social_facebook_link', 'https://www.facebook.com/'],
          ['Instagram', 'social_instagram_link', 'https://www.instagram.com/'],
          ['Pinterest', 'social_pinterest_link', 'https://www.pinterest.com/'],
          ['Twitter', 'social_twitter_link', 'https://twitter.com/'],
          ['Tumblr', 'social_tumblr_link', 'https://tumblr.com/'],
          ['Youtube', 'social_youtube_link', 'https://youtube.com/'],
        ];
        foreach ($socials as $s): ?>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan($s[0]) ?></label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="<?=$s[1]?>" value="<?= get_option($s[1], $s[2]) ?>">
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("contact_informations") ?></h5>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("Tel") ?></label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="contact_tel" value="<?= get_option('contact_tel', "+12345678") ?>">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("Email") ?></label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="contact_email" value="<?= get_option('contact_email', "support@rentalpanelbd.com") ?>">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("working_hour") ?></label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="contact_work_hour" value="<?= get_option('contact_work_hour', "Mon - Sat 09 am - 10 pm") ?>">
        </div>
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> CopyRight</h5>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="copy_right_content" value="<?= get_option('copy_right_content', "Copyright &copy; 2020 - Blitheforge") ?>">
      </div>
    </div>

  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?= lan("Save") ?></button>
  </div>
  <?php echo form_close(); ?>
</div>
