<?php
$cookie_email = !empty(get_cookie("c_cookie_email")) ? encrypt_decode(get_cookie("c_cookie_email")) : "";
$cookie_pass = !empty(get_cookie("c_cookie_pass")) ? encrypt_decode(get_cookie("c_cookie_pass")) : "";
$redirect = session('ref_url') ?? user_url();
?>

<div class="w-full max-w-md mx-auto px-4">
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
      <h4 class="text-xl font-semibold text-gray-900">Sign In</h4>
    </div>
    <div class="px-6 py-6">
      <?= form_open(base_url('sign-in'), 'class="actionForm space-y-5" novalidate="" data-redirect="' . $redirect . '"') ?>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-colors" name="email" tabindex="1" required autofocus autocomplete="email" value="<?= !empty($cookie_email) ? $cookie_email : set_value('email') ?>">
      </div>

      <div>
        <div class="flex items-center justify-between mb-1">
          <label for="password" class="text-sm font-medium text-gray-700">Password</label>
          <a href="<?= base_url('password-reset') ?>" class="text-xs text-primary-600 hover:text-primary-700">Forgot Password?</a>
        </div>
        <input id="password" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-colors" name="password" tabindex="2" required autocomplete="current-password" value="<?= !empty($cookie_pass) ? $cookie_pass : set_value('password') ?>">
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="remember" class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" tabindex="3" id="remember-me" <?= !empty($cookie_email) ? 'checked' : '' ?>>
        <label class="ml-2 text-sm text-gray-600" for="remember-me">Remember Me</label>
      </div>

      <button type="submit" class="w-full py-2.5 px-4 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors" tabindex="4">
        Login
      </button>

      <?php if (get_option('google_login')) : ?>
        <a href="<?= base_url('auth/google_process') ?>" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
          Google Login
        </a>
      <?php endif; ?>
      <?= form_close(); ?>
    </div>
    <div class="px-6 pb-5 text-center text-sm text-gray-500">
      Don't have an account? <a href="<?= base_url('sign-up') ?>" class="text-primary-600 hover:text-primary-700 font-medium">Register</a>
    </div>
  </div>
</div>
