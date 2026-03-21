<?php
$cookie_email = !empty(get_cookie("a_cookie_email")) ? encrypt_decode(get_cookie("a_cookie_email")) : "";
$cookie_pass = !empty(get_cookie("a_cookie_pass")) ? encrypt_decode(get_cookie("a_cookie_pass")) : "";
$redirect = session('ref_url') ?? admin_url();
?>

<div class="w-full max-w-md mx-auto px-4">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
      <h4 class="text-xl font-semibold text-gray-900">Admin Sign In</h4>
    </div>
    <div class="px-6 py-6">
      <form action="<?= url_to('admin.attempt_signin') ?>" method="post" class="space-y-5" x-data="authForm()" @submit.prevent="submitForm($event)" data-redirect="<?= $redirect ?>">
        <input type="hidden" name="token" value="<?= csrf_hash() ?>">

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="email" tabindex="1" required autofocus autocomplete="email" value="<?= !empty($cookie_email) ? $cookie_email : set_value('email') ?>">
      </div>

      <div>
        <div class="flex items-center justify-between mb-1">
          <label for="password" class="text-sm font-medium text-gray-700">Password</label>
          <a href="<?= base_url('admin/password-reset') ?>" class="text-xs text-indigo-600 hover:text-indigo-700">Forgot Password?</a>
        </div>
        <input id="password" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" name="password" tabindex="2" required autocomplete="current-password" value="<?= !empty($cookie_pass) ? $cookie_pass : set_value('password') ?>">
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" tabindex="3" id="remember-me" <?= !empty($cookie_email) ? 'checked' : '' ?>>
        <label class="ml-2 text-sm text-gray-600" for="remember-me">Remember Me</label>
      </div>

      <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors disabled:opacity-50" tabindex="4" :disabled="loading">
        <span x-show="!loading">Login</span>
        <span x-show="loading" x-cloak>Signing in...</span>
      </button>
      </form>
    </div>
  </div>
</div>
