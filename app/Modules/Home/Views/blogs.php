<section class="pt-8 pb-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
      <a href="<?= base_url() ?>" class="hover:text-primary-600">Home</a>
      <span>/</span>
      <span class="text-gray-900">Blog</span>
    </nav>
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Blog</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-8">
        <?php foreach ($items as $item) : ?>
          <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <?php if (!empty($item->thumbnail)) : ?>
              <img src="<?= $item->thumbnail ?>" alt="<?= esc($item->title) ?>" class="w-full h-56 object-cover">
            <?php endif; ?>
            <div class="p-6">
              <h2 class="text-xl font-semibold text-gray-900 mb-2">
                <a href="<?= base_url('blog/' . $item->uri) ?>" class="hover:text-primary-600 transition-colors"><?= $item->title; ?></a>
              </h2>
              <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  Admin
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  <time><?= time_format($item->created_at); ?></time>
                </span>
              </div>
              <p class="text-gray-600 text-sm mb-4"><?= shorten_string($item->description, 240) ?></p>
              <a href="<?= base_url('blog/' . $item->uri) ?>" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">Read More &rarr;</a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <aside class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Posts</h3>
          <div class="space-y-4">
            <?php foreach ($items as $item) : ?>
              <div class="flex gap-3">
                <?php if (!empty($item->thumbnail)) : ?>
                  <img src="<?= base_url($item->thumbnail) ?>" alt="" class="w-16 h-12 rounded-lg object-cover flex-shrink-0">
                <?php endif; ?>
                <div class="min-w-0">
                  <h4 class="text-sm font-medium text-gray-900 truncate"><a href="<?= base_url('blog/' . $item->uri) ?>" class="hover:text-primary-600"><?= $item->title ?></a></h4>
                  <time class="text-xs text-gray-500"><?= time_ago($item->created_at) ?></time>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>
