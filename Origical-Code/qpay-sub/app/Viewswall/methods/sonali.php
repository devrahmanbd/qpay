<style type="text/css">
    :root {--bg1: #096235; } .bg1 {background-color: var(--bg1); } .flex_info{border-top: 7px solid var(--bg1) !important; } .marked_text{color: #f6c34d !important}
</style>
<div class="input_step_confirm bg1">
   <ul class="all_step">

      <li class="li_row"> 
         <p>
            একাউন্ট নামঃ
            <span class="marked_text"><?=get_value($setting['params'],'bank_account_name')?></span> 
            <a href="javascript:void(0)" class="text-to-cliboard" data-value="<?=get_value($setting['params'],'bank_account_name')?>">
            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 4l1-1h5.414L14 6.586V14l-1 1H5l-1-1V4zm9 3l-3-3H5v10h8V7z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3 1L2 2v10l1 1V2h6.414l-1-1H3z"/></svg>

            Copy
            </a>
         </p>
      </li>
      <hr>
      <li class="li_row"> 
         <p>
            একাউন্ট নাম্বারঃ
            <span class="marked_text"><?=get_value($setting['params'],'bank_account_number')?></span> 
            <a href="javascript:void(0)" class="text-to-cliboard" data-value="<?=get_value($setting['params'],'bank_account_number')?>">
            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 4l1-1h5.414L14 6.586V14l-1 1H5l-1-1V4zm9 3l-3-3H5v10h8V7z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3 1L2 2v10l1 1V2h6.414l-1-1H3z"/></svg>

            Copy
            </a>
         </p>
      </li>
      <hr>
      <li class="li_row"> 
         <p>
            ব্রাঞ্চ নামঃ
            <span class="marked_text"><?=get_value($setting['params'],'bank_account_branch_name')?></span> 
            <a href="javascript:void(0)" class="text-to-cliboard" data-value="<?=get_value($setting['params'],'bank_account_branch_name')?>">
            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 4l1-1h5.414L14 6.586V14l-1 1H5l-1-1V4zm9 3l-3-3H5v10h8V7z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3 1L2 2v10l1 1V2h6.414l-1-1H3z"/></svg>
            Copy
            </a>
         </p>
      </li>
      <hr>
      <li class="li_row"> 
         <p>
            রাউটিং নাম্বারঃ
            <span class="marked_text"><?=get_value($setting['params'],'bank_account_routing_number')?></span> 
            <a href="javascript:void(0)" class="text-to-cliboard" data-value="<?=get_value($setting['params'],'bank_account_routing_number')?>">
            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 4l1-1h5.414L14 6.586V14l-1 1H5l-1-1V4zm9 3l-3-3H5v10h8V7z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3 1L2 2v10l1 1V2h6.414l-1-1H3z"/></svg>

            Copy
            </a>
         </p>
      </li>
      <hr>
      <li class="li_row">
         <p>
            টাকার পরিমাণঃ <span class="marked_text"><?=currency_format($tmp['all_info']['total_amount'])?></span>
         </p>
      </li>
      <hr>
      <li class="li_row">
         <p>
            উল্লেখিত তথ্য অনুযায়ী আপনার ব্যাঙ্ক লেনদেন সম্পন্ন করে আপনার লেনদেনের স্লিপ আপলোড করুন অথবা আপনার লেনদেনের স্ক্রিনশট আপলোড করুন । তারপর নিচের CONFIRM বাটন এ ক্লিক করুন । 
         </p>
      </li>
   </ul>
    <p id="titless">পেমেন্ট স্লিপ আপলোড করুন  </p>
    <div id="flexs">
        <input type="file"placeholder="পেমেন্ট স্লিপ আপলোড করুন"id="payment_slip"style="text-align: left;background-color: #FFFFFF;padding-top: 13px;padding-bottom: 13px;padding-left: 13px;height: auto;" name="payment_slip[]">
    <input type="text" id="transaction_id" style="display:none;">
    </div>
</div>




