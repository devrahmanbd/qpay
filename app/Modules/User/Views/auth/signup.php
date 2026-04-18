<div class="w-full max-w-lg mx-auto px-4">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
      <h4 class="text-xl font-semibold text-gray-900">Register</h4>
    </div>
    <div class="px-6 py-6">
      <form action="<?= base_url('sign-up') ?>" method="post" class="space-y-5" x-data="authForm()" @submit.prevent="submitForm($event)" data-redirect="user">
        <input type="hidden" name="token" value="<?= csrf_hash() ?>">

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="frist_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
          <input id="frist_name" type="text" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="first_name" autofocus required>
        </div>
        <div>
          <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
          <input id="last_name" type="text" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="last_name" required>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input id="email" type="email" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="email" required autocomplete="email">
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
          <input id="phone" type="text" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="phone" required>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input id="password" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="password" required autocomplete="new-password">
        </div>
        <div>
          <label for="password2" class="block text-sm font-medium text-gray-700 mb-1">Password Confirmation</label>
          <input id="password2" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="c_password" required autocomplete="new-password">
        </div>
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="agree" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" id="agree">
        <label class="ml-2 text-sm text-gray-600" for="agree">I agree with the terms and conditions</label>
      </div>

      <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors disabled:opacity-50" :disabled="loading">
        <span x-show="!loading">Register</span>
        <span x-show="loading" x-cloak>Creating account...</span>
      </button>
      </form>
    </div>
    <div class="px-6 pb-5 text-center text-sm text-gray-500">
      Already Registered? <a href="<?= base_url('sign-in') ?>" class="text-indigo-600 hover:text-indigo-700 font-medium">Login</a>
    </div>
  </div>
</div>
