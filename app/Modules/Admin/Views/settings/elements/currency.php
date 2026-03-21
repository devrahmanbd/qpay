<?php
$form_url = admin_url($controller_name."/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-dollar-sign text-gray-400 mr-1"></i> <?=lan("currency_setting")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-6">

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?=lan("currency_setting")?></h5>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("currency_code")?></label>
        <select name="currency_code" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
          <?php $currency_codes = currency_codes();
          if(!empty($currency_codes)){
            foreach ($currency_codes as $key => $row) { ?>
            <option value="<?=$key?>" <?=(get_option("currency_code", "USD") == $key)? 'selected': ''?>><?=$key." - ".$row?></option>
          <?php }}else{ ?>
            <option value="USD" selected>USD - United States dollar</option>
          <?php } ?>
        </select>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("symbol")?></label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="currency_symbol" value="<?=get_option('currency_symbol',"$")?>">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("thousand_separator")?></label>
          <select name="currency_thousand_separator" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="dot" <?=(get_option('currency_thousand_separator', 'comma') == 'dot')? 'selected': ''?>><?=lan("Dot")?></option>
            <option value="comma" <?=(get_option('currency_thousand_separator', 'comma') == 'comma')? 'selected': ''?>><?=lan("Comma")?></option>
            <option value="space" <?=(get_option('currency_thousand_separator', 'comma') == 'space')? 'selected': ''?>><?=lan("Space")?></option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("decimal_separator")?></label>
          <select name="currency_decimal_separator" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="dot" <?=(get_option('currency_decimal_separator', 'dot') == 'dot')? 'selected': ''?>><?=lan("Dot")?></option>
            <option value="comma" <?=(get_option('currency_decimal_separator', 'dot') == 'comma')? 'selected': ''?>><?=lan("Comma")?></option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("decimal_places")?></label>
          <select name="currency_decimal" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="0" <?=(get_option('currency_decimal', 2) == 0)? 'selected': ''?>>0</option>
            <option value="1" <?=(get_option('currency_decimal', 2) == 1)? 'selected': ''?>>0.0</option>
            <option value="2" <?=(get_option('currency_decimal', 2) == 2)? 'selected': ''?>>0.00</option>
            <option value="3" <?=(get_option('currency_decimal', 2) == 3)? 'selected': ''?>>0.000</option>
            <option value="4" <?=(get_option('currency_decimal', 2) == 4)? 'selected': ''?>>0.0000</option>
          </select>
        </div>
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?=lan("price_percentage_increase")?></h5>
      <div class="max-w-md">
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=sprintf(lan('auto_rounding_to_X_decimal_places'), "X")?></label>
        <select name="auto_rounding_x_decimal_places" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
          <?php for ($i = 1; $i <= 4; $i++) { ?>
          <option value="<?=$i?>" <?=(get_option("auto_rounding_x_decimal_places", 2) == $i)? "selected" : ''?>><?=$i?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?=lan("auto_currency_converter")?></h5>
      <label class="relative inline-flex items-center cursor-pointer mb-3">
        <input type="hidden" name="is_auto_currency_convert" value="0">
        <input type="checkbox" name="is_auto_currency_convert" class="sr-only peer" <?=(get_option("is_auto_currency_convert", 0) == 1) ? "checked" : ""?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600"><?=lan("Active")?></span>
      </label>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("currency_rate")?></label>
        <div class="flex items-center gap-2 max-w-md">
          <span class="text-sm text-gray-500"><?=lan("1_original_currency")?> =</span>
          <input type="text" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm text-right" name="new_currecry_rate" value="<?=get_option('new_currecry_rate', 1)?>">
          <span class="text-sm text-gray-500"><?=lan("new_currency")?></span>
        </div>
        <p class="text-xs text-gray-500 mt-1"><span class="text-red-500">*</span> <?=lan("if_you_dont_want_to_change_currency_rate_then_leave_this_currency_rate_field_to_1")?></p>
      </div>
    </div>

  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Save")?></button>
  </div>
  <?php echo form_close(); ?>
</div>
