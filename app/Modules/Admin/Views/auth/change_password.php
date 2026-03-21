<div class="w-full max-w-md mx-auto px-4">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
      <h4 class="text-xl font-semibold text-gray-900">Reset your Password</h4>
    </div>
    <div class="px-6 py-6">
      <form action="" method="post" class="space-y-5" x-data="authForm()" @submit.prevent="submitForm($event)" data-redirect="dashboard">
        <input type="hidden" name="token" value="<?= csrf_hash() ?>">

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
        <input id="password" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-colors" name="password" required autofocus>
      </div>

      <div>
        <label for="c_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input id="c_password" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-colors" name="c_password" required>
      </div>

      <button type="submit" class="w-full py-2.5 px-4 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors disabled:opacity-50" :disabled="loading">
        <span x-show="!loading">Change Password</span>
        <span x-show="loading" x-cloak>Updating...</span>
      </button>
      </form>
    </div>
  </div>
</div>
