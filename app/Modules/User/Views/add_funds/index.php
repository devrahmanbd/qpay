<?php @$data['modal_title'] = '';
echo view('layouts/common/modal/modal_top', @$data);

if (!empty($payments)) : ?>
  <div id="result_ajaxSearch">
    <div class="max-w-lg mx-auto">
      <?php
      @$option           = get_value(@$payments->params, 'option');
      @$min_amount       = get_value(@$payments->params, 'min');
      @$max_amount       = get_value(@$payments->params, 'max');
      @$type             = get_value(@$payments->params, 'type');
      @$tnx_fee          = get_value(@$option, 'tnx_fee');
      ?>

      <div class="add-funds-form-content">
        <form class="form actionAddFundsForm" action="#" method="POST">
          <div class="text-center mb-4">
            <img src="<?= base_url(get_value(@$option, 'logo')) ?>" alt="<?= @$payments->name ?>" class="h-16 mx-auto mb-2">
            <p class="text-xs text-gray-500"><?= lang("deposit_via_" . @$payments->name . "_will_be_added_into_your_account") ?></p>
          </div>

          <div class="mb-4">
            <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" type="number" name="amount" placeholder="<?php echo @$min_amount; ?>">
          </div>

          <div class="mb-4">
            <label class="inline-flex items-start gap-2 cursor-pointer">
              <input type="checkbox" class="mt-1 rounded border-gray-300 text-primary-600 focus:ring-primary-500" name="agree" value="1">
              <span class="text-xs text-gray-500 uppercase">I understand that after adding the funds, I will not make fraudulent disputes or chargebacks. I am aware that once the funds have been added, I will not undertake any fraudulent disputes or chargebacks.</span>
            </label>
          </div>

          <input type="hidden" name="payment_id" value="<?= @$payments->id; ?>">
          <input type="hidden" name="payment_method" value="<?= @$payments->type; ?>">
          <button type="submit" class="w-full px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <?= lang("Pay Now") ?>
          </button>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php echo view('layouts/common/modal/modal_bottom'); ?>