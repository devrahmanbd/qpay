<footer class="border-t border-gray-200 bg-white py-4 px-6">
  <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-gray-500">
    <p>&copy; <script>document.write(new Date().getFullYear())</script> <?= site_config('site_name', 'QPay') ?>. All rights reserved.</p>
    <div class="flex items-center gap-4">
      <a href="<?= base_url('terms') ?>" class="hover:text-gray-700 transition-colors">Terms</a>
      <a href="<?= base_url('privacy-policy') ?>" class="hover:text-gray-700 transition-colors">Privacy</a>
    </div>
  </div>
</footer>
