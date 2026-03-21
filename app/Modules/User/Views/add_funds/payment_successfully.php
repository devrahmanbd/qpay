<div class="max-w-lg mx-auto mt-8">
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
      <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <h3 class="text-lg font-semibold text-gray-800"><?=lang("payment_sucessfully")?></h3>
    </div>
    <div class="p-6">
      <p class="text-sm text-gray-600 mb-4"><?=lang("your_payment_has_been_processed_here_are_the_details_of_this_transaction_for_your_reference")?></p>
      <ul class="space-y-2 text-sm">
        <li class="flex items-center gap-2">
          <span class="text-gray-500"><?=lang("Transaction_ID")?>:</span>
          <strong class="text-gray-800"><?=(!empty($transaction) && $transaction->transaction_id == 'empty') ? lang($transaction->transaction_id)." ".lang("transaction_id_was_sent_to_your_email") : $transaction->transaction_id?></strong>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-gray-500"><?=lang("Amount_paid_includes_fee")?>:</span>
          <strong class="text-gray-800"><?=(!empty($transaction)) ? $transaction->amount : ''?> <?=get_option("currency_code", "USD")?></strong>
        </li>
      </ul>
    </div>
  </div>
</div>
