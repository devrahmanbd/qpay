<div class="w-full max-w-md mx-auto px-4">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
      <h4 class="text-xl font-semibold text-gray-900">Activate Account</h4>
    </div>
    <div class="px-6 py-6">
      <p class="text-sm text-gray-600 mb-5">Please click the button below to continue with your account.</p>
      <?= form_open('', 'class="actionForm" data-redirect="user"') ?>
      <button type="submit" class="w-full py-2.5 px-4 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
        Activate your Account
      </button>
      <?= form_close(); ?>
    </div>
  </div>
</div>
