<div class="w-full max-w-md mx-auto px-4">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
      <h4 class="text-xl font-semibold text-gray-900">Password Reset</h4>
    </div>
    <div class="px-6 py-6">
      <?= form_open(url_to('password-reset'), 'class="actionForm space-y-5" data-redirect="user"') ?>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="email" tabindex="1" required autofocus autocomplete="email">
      </div>

      <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors" tabindex="4">
        Send Mail
      </button>
      <?= form_close(); ?>
    </div>
    <div class="px-6 pb-5 text-center text-sm text-gray-500">
      Don't have an account? <a href="<?= base_url('sign-up') ?>" class="text-indigo-600 hover:text-indigo-700 font-medium">Register</a>
    </div>
  </div>
</div>
