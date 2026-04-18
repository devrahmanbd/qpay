<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= !empty($title) ? $title . ' - ' . site_config("site_name", "QPay") : site_config("site_title", "QPay - Payment Gateway") ?></title>
  <meta name="description" content="<?= site_config('site_description', 'QPay Payment Gateway - Accept bKash, Nagad, Rocket payments with a single API') ?>">
  <meta name="keywords" content="<?= site_config('site_keywords', 'payment gateway Bangladesh') ?>">
  <link rel="icon" type="image/png" href="<?= get_logo(true) ?>">
  <link rel="canonical" href="<?= current_url() ?>">

  <meta name="robots" content="index, follow">
  <meta name="author" content="<?= site_config('site_name', 'QPay') ?>">

  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= !empty($title) ? $title . ' - ' . site_config('site_name', 'QPay') : site_config('site_title', 'QPay - Payment Gateway') ?>">
  <meta property="og:description" content="<?= site_config('site_description', 'QPay Payment Gateway') ?>">
  <meta property="og:url" content="<?= current_url() ?>">
  <meta property="og:site_name" content="<?= site_config('site_name', 'QPay') ?>">
  <meta property="og:image" content="<?= base_url(get_logo()) ?>">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= !empty($title) ? $title . ' - ' . site_config('site_name', 'QPay') : site_config('site_title', 'QPay - Payment Gateway') ?>">
  <meta name="twitter:description" content="<?= site_config('site_description', 'QPay Payment Gateway') ?>">

  <link rel="preconnect" href="https://cdn.tailwindcss.com">
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
  <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { 50:'#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 300:'#a5b4fc', 400:'#818cf8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' }
          }
        }
      }
    }
  </script>
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css">

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "<?= site_config('site_name', 'QPay') ?>",
    "url": "<?= base_url() ?>",
    "logo": "<?= base_url(get_logo()) ?>",
    "description": "<?= site_config('site_description', 'Payment gateway for South Asia') ?>",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Dhaka",
      "addressCountry": "BD"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "<?= site_config('contact_tel', '') ?>",
      "contactType": "sales",
      "email": "<?= site_config('contact_email', '') ?>"
    }
  }
  </script>

  <style>
    [x-cloak] { display: none !important; }

    .reveal-up { animation: revealUp .8s cubic-bezier(.16,1,.3,1) both; }
    @keyframes revealUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:none; } }

    .scroll-reveal { opacity:0; transform:translateY(24px); transition: opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1); }
    .scroll-reveal.is-visible { opacity:1; transform:none; }

    @keyframes pulse-slow { 0%,100% { opacity:.3; transform:scale(1); } 50% { opacity:.5; transform:scale(1.05); } }
    .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }

    .logo-marquee { display:flex; gap:3rem; animation: marquee 25s linear infinite; }
    .logo-marquee:hover { animation-play-state: paused; }
    @keyframes marquee { 0% { transform:translateX(0); } 100% { transform:translateX(-50%); } }

    .fade-in { animation: fadeIn .6s ease-out both; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:none; } }

    html { scroll-behavior: smooth; }
  </style>
</head>

<body class="bg-white text-gray-800 antialiased" x-data="{ mobileOpen: false }">

  <header id="header" class="header fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
      <a href="<?= base_url() ?>" class="flex items-center gap-2">
        <img src="<?= get_logo() ?>" alt="<?= site_config('site_name', 'QPay') ?>" class="h-8" width="32" height="32">
        <span class="text-xl font-bold text-gray-900"><?= site_config('site_name', 'QPay') ?></span>
      </a>
      <nav class="hidden md:flex items-center gap-8">
        <a href="<?= base_url() ?>" class="text-sm font-medium <?= segment(1) == '' ? 'text-primary-600' : 'text-gray-600 hover:text-gray-900' ?> transition-colors">Home</a>
        <a href="<?= base_url('developers') ?>" class="text-sm font-medium <?= segment(1) == 'developers' ? 'text-primary-600' : 'text-gray-600 hover:text-gray-900' ?> transition-colors">API Docs</a>
        <a href="<?= base_url('blogs') ?>" class="text-sm font-medium <?= segment(1) == 'blogs' || segment(1) == 'blog' ? 'text-primary-600' : 'text-gray-600 hover:text-gray-900' ?> transition-colors">Blog</a>
      </nav>
      <div class="flex items-center gap-3">
        <a href="<?= base_url('sign-up') ?>" class="hidden md:inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">Sign Up</a>
        <a href="<?= base_url('sign-in') ?>" class="hidden md:inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">Sign In</a>
        <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-600" aria-label="Toggle navigation menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
    <div x-show="mobileOpen" x-cloak x-transition class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-2">
      <a href="<?= base_url() ?>" class="block px-3 py-2 rounded-lg text-sm font-medium <?= segment(1) == '' ? 'bg-primary-50 text-primary-700' : 'text-gray-600' ?>">Home</a>
      <a href="<?= base_url('developers') ?>" class="block px-3 py-2 rounded-lg text-sm font-medium <?= segment(1) == 'developers' ? 'bg-primary-50 text-primary-700' : 'text-gray-600' ?>">API Docs</a>
      <a href="<?= base_url('blogs') ?>" class="block px-3 py-2 rounded-lg text-sm font-medium <?= segment(1) == 'blogs' || segment(1) == 'blog' ? 'bg-primary-50 text-primary-700' : 'text-gray-600' ?>">Blog</a>
      <a href="<?= base_url('sign-up') ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600">Sign Up</a>
      <a href="<?= base_url('sign-in') ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-white bg-primary-600 text-center">Sign In</a>
    </div>
  </header>

  <main class="main pt-16">
    <?= view($view) ?>
  </main>

  <footer id="footer" class="bg-gray-900 text-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
        <div class="md:col-span-1">
          <span class="text-lg font-bold text-white"><?= site_config('site_name', 'QPay') ?></span>
          <p class="mt-3 text-sm leading-relaxed">The payment infrastructure for South Asia. Accept bKash, Nagad, Rocket, and more with a single API.</p>
          <div class="flex gap-3 mt-5">
            <?php if (site_config('social_twitter_link', '') && site_config('social_twitter_link') != '#') : ?>
              <a href="<?= site_config('social_twitter_link') ?>" class="hover:text-white transition-colors" aria-label="Follow us on X (Twitter)">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </a>
            <?php endif; ?>
            <?php if (site_config('social_facebook_link', '') && site_config('social_facebook_link') != '#') : ?>
              <a href="<?= site_config('social_facebook_link') ?>" class="hover:text-white transition-colors" aria-label="Follow us on Facebook">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
            <?php endif; ?>
            <?php if (site_config('social_instagram_link', '') && site_config('social_instagram_link') != '#') : ?>
              <a href="<?= site_config('social_instagram_link') ?>" class="hover:text-white transition-colors" aria-label="Follow us on Instagram">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
            <?php endif; ?>
            <?php if (site_config('social_github_link', '') && site_config('social_github_link') != '#') : ?>
              <a href="<?= site_config('social_github_link') ?>" class="hover:text-white transition-colors" aria-label="View our GitHub">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <div>
          <h4 class="text-sm font-semibold text-white mb-4">Product</h4>
          <ul class="space-y-2.5 text-sm">
            <li><a href="<?= base_url() ?>" class="hover:text-white transition-colors">Home</a></li>
            <li><a href="<?= base_url('developers') ?>" class="hover:text-white transition-colors">API Docs</a></li>
            <li><a href="<?= base_url('developers/docs') ?>" class="hover:text-white transition-colors">Documentation</a></li>
            <li><a href="<?= base_url('sign-up') ?>" class="hover:text-white transition-colors">Sign Up</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-sm font-semibold text-white mb-4">Legal</h4>
          <ul class="space-y-2.5 text-sm">
            <li><a href="<?= base_url('terms-condition') ?>" class="hover:text-white transition-colors">Terms of Service</a></li>
            <li><a href="<?= base_url('privacy-policy') ?>" class="hover:text-white transition-colors">Privacy Policy</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-sm font-semibold text-white mb-4">Contact</h4>
          <div class="space-y-2.5 text-sm">
            <p><?= site_config('address', '') ?></p>
            <?php if (site_config('contact_tel', '')): ?><p><strong class="text-white">Phone:</strong> <?= site_config('contact_tel') ?></p><?php endif; ?>
            <?php if (site_config('contact_email', '')): ?><p><strong class="text-white">Email:</strong> <?= site_config('contact_email') ?></p><?php endif; ?>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-10 pt-8 text-center text-sm">
        <p>&copy; <?= date('Y') ?> <strong class="text-white"><?= site_config('site_name', 'QPay') ?></strong>. <?= site_config('copy_right_content', 'All rights reserved.') ?></p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-php.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-javascript.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-python.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-go.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-json.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-bash.min.js"></script>
  <script>
    function copyCode(button) {
      var container = button.parentElement;
      var code = container.querySelector('code');
      if (code) {
        navigator.clipboard.writeText(code.innerText).then(function() {
          button.textContent = 'Copied!';
          setTimeout(function() { button.textContent = 'Copy'; }, 1500);
        });
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

      document.querySelectorAll('.scroll-reveal').forEach(function(el) {
        observer.observe(el);
      });
    });
  </script>
</body>

</html>
