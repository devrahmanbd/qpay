<section class="pt-8 pb-16">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
      <a href="<?= base_url() ?>" class="hover:text-primary-600">Home</a>
      <span>/</span>
      <span class="text-gray-900">Privacy Policy</span>
    </nav>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Privacy Policy</h1>
    <div class="prose prose-gray max-w-none">
      <?= htmlspecialchars_decode(get_option('policy_content'), ENT_QUOTES) ?>
    </div>
  </div>
</section>
