<?php
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-globe text-gray-400 mr-1"></i> <?= lang("Affiliate Setting") ?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-4">

    <?php
    $aff_toggles = [
      ['is_addfund_bonus', 'Add Fund Bonus'],
      ['is_plan_bonus', 'Plan Bonus'],
      ['is_signup_bonus', 'Signup Bonus'],
    ];
    foreach ($aff_toggles as $at): ?>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"><?= lang($at[1]) ?></label>
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="hidden" name="<?=$at[0]?>" value="0">
        <input type="checkbox" name="<?=$at[0]?>" class="sr-only peer" <?= (get_option($at[0], 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600"><?= lang("Active") ?></span>
      </label>
      <?php if ($at[0] === 'is_signup_bonus'): ?>
      <div class="mt-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Signup Bonus amount (Only used for signup)</label>
        <input type="number" name="signup_bonus_amount" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="<?= get_option('signup_bonus_amount', 0) ?>">
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang("Bonus type") ?></label>
      <select name="affiliate_bonus_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="0" <?= get_option('affiliate_bonus_type') == 0 ? 'selected' : '' ?>>Fixed</option>
        <option value="1" <?= get_option('affiliate_bonus_type') == 1 ? 'selected' : '' ?>>Percentage</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang("Affiliate bonus") ?></label>
      <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="affiliate_bonus" type="number" value="<?= get_option('affiliate_bonus', 0) ?>">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang("Minimum amount for bonus") ?></label>
      <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="min_affiliate_amount" type="number" value="<?= get_option('min_affiliate_amount', 0) ?>">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?= lang("Maximum time for bonus") ?></label>
      <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="max_affiliate_time" type="number" value="<?= get_option('max_affiliate_time', 0) ?>">
    </div>

  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?= lang("Save") ?></button>
  </div>
  <?php echo form_close(); ?>
</div>
