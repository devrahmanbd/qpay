<?php
define("PAYMENT_URL", rtrim(base_url(), '/') . '/');
$siteName = site_config("site_name", "QPay");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation | <?= $siteName ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#635BFF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { -webkit-font-smoothing: antialiased; }
        .scroll-mt-24 { scroll-margin-top: 6rem; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased" x-data="{ lang: 'curl', mobileMenu: false }">
  
    <!-- Mobile Header -->
    <header class="lg:hidden flex items-center justify-between p-4 border-b bg-white sticky top-0 z-50">
        <div class="font-bold text-primary text-xl tracking-tighter italic"><?= $siteName ?> Docs</div>
        <button @click="mobileMenu = !mobileMenu" class="p-2 text-slate-500">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </header>

    <div class="flex flex-col lg:flex-row lg:h-screen w-full">
    
        <!-- Left Sidebar (Desktop Nav) -->
        <nav class="hidden lg:block lg:w-64 xl:w-72 shrink-0 border-r border-slate-200 bg-slate-50 h-full overflow-y-auto p-6">
            <div class="mb-8 p-1">
                <a href="<?= base_url() ?>" class="text-2xl font-black text-primary tracking-tighter italic"><?= $siteName ?></a>
            </div>
            <div class="space-y-8 italic">
                <div>
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Introduction</h3>
                    <ul class="space-y-2 text-sm font-medium italic">
                        <li><a href="#intro" class="text-primary hover:text-primary italic">Getting Started</a></li>
                        <li><a href="#auth" class="text-slate-600 hover:text-primary italic">Authentication</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Endpoints</h3>
                    <ul class="space-y-2 text-sm font-medium italic">
                        <li><a href="#payment-create" class="text-slate-600 hover:text-primary italic">Create Payment</a></li>
                        <li><a href="#payment-verify" class="text-slate-600 hover:text-primary italic">Verify Payment</a></li>
                        <li><a href="#refund-create" class="text-slate-600 hover:text-primary italic">Issue Refund</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Advanced</h3>
                    <ul class="space-y-2 text-sm font-medium italic">
                        <li><a href="#webhooks" class="text-slate-600 hover:text-primary italic">Webhooks</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 w-full p-6 lg:p-10 xl:p-16 h-full overflow-y-auto italic">
            <div class="max-w-3xl italic">
                
                <section id="intro" class="mb-20 scroll-mt-24 italic">
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-6 italic">API Reference</h1>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8 italic">
                        Welcome to the QPay API. Our RESTful interface allows you to process payments, verify transactions, and manage refunds with high precision and security. 
                    </p>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 flex items-center gap-4 italic font-bold">
                        <span class="material-symbols-outlined text-primary font-bold">link</span>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block italic">Base API URL</span>
                            <code class="text-sm font-bold text-slate-900 italic"><?= PAYMENT_URL ?>api/v1</code>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 my-16 italic">

                <section id="auth" class="mb-20 scroll-mt-24 italic">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic">Authentication</h2>
                    <p class="text-slate-600 leading-relaxed mb-6 italic">
                        All requests must be authenticated using your secret API key in the <code class="bg-slate-100 px-2 py-1 rounded italic font-bold">API-KEY</code> header.
                    </p>
                    <div class="bg-amber-50 border border-amber-100 p-6 rounded-2xl italic">
                        <h4 class="text-sm font-bold text-amber-900 mb-2 italic">Keep it secret</h4>
                        <p class="text-xs text-amber-700 leading-relaxed italic">Your secret key allows full access to your merchant account. Never commit it to GitHub or share it in support tickets.</p>
                    </div>
                </section>

                <hr class="border-slate-100 my-16 italic">

                <section id="payment-create" class="mb-20 scroll-mt-24 italic">
                    <div class="flex items-center gap-3 mb-6 italic">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase italic font-bold">POST</span>
                        <code class="text-sm font-bold text-slate-800 italic">/payment/create</code>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic">Create a Payment</h2>
                    <p class="text-slate-600 leading-relaxed mb-10 italic">
                        Initiate a new payment. This returns a <code class="italic font-bold">checkout_url</code> where you should redirect your customer to complete the transaction.
                    </p>
                    
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 italic">Parameters</h4>
                    <div class="space-y-8 italic">
                        <div class="flex gap-4 italic border-t border-slate-50 pt-4">
                            <span class="font-mono text-sm font-bold text-slate-900 w-32 italic">amount</span>
                            <div class="flex-1 italic">
                                <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded font-bold italic">REQUIRED</span>
                                <p class="text-sm text-slate-500 mt-2 italic">Integer. Amount in Poisha (e.g., 5000 for 50.00 BDT).</p>
                            </div>
                        </div>
                        <div class="flex gap-4 italic border-t border-slate-50 pt-4">
                            <span class="font-mono text-sm font-bold text-slate-900 w-32 italic">currency</span>
                            <div class="flex-1 italic">
                                <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-bold italic">FIXED</span>
                                <p class="text-sm text-slate-500 mt-2 italic">Always use <code class="italic">BDT</code>.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 my-16">

                <section id="payment-verify" class="mb-20 scroll-mt-24 italic">
                    <div class="flex items-center gap-3 mb-6 italic">
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase italic">GET</span>
                        <code class="text-sm font-bold text-slate-800 italic">/payment/verify/{id}</code>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic uppercase font-bold">Verify Payment</h2>
                    <p class="text-slate-600 leading-relaxed italic uppercase font-bold">Check the status of a specific payment ID.</p>
                </section>

                <hr class="border-slate-100 my-16">

                <section id="webhooks" class="mb-20 scroll-mt-24 italic">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic uppercase font-bold">Webhooks</h2>
                    <p class="text-slate-600 leading-relaxed italic uppercase font-bold">Configure your endpoint in the dashboard to receive real-time notifications for payment successes and failures.</p>
                </section>

            </div>
        </main>

        <!-- Right Side Pane (Examples/Code Blocks) -->
        <aside class="w-full lg:w-1/3 xl:w-[40%] shrink-0 bg-slate-50 lg:border-l border-slate-200 text-slate-800 lg:h-full overflow-y-auto p-6 lg:p-10 italic">
            
            <div class="sticky top-0 italic">
                <div class="flex gap-4 mb-8 border-b border-slate-200 pb-2 italic">
                    <button @click="lang = 'curl'" :class="lang === 'curl' ? 'text-primary border-b-2 border-primary font-bold' : 'text-slate-400'" class="text-xs uppercase tracking-widest transition-all italic">cURL</button>
                    <button @click="lang = 'php'" :class="lang === 'php' ? 'text-primary border-b-2 border-primary font-bold' : 'text-slate-400'" class="text-xs uppercase tracking-widest transition-all italic">PHP</button>
                </div>

                <!-- Intro Examples -->
                <div class="space-y-12 italic">
                    <div class="italic">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 block italic">Authentication Request</span>
<pre class="bg-slate-800 text-slate-50 p-4 rounded-lg overflow-x-auto text-sm italic"><code>curl <?= PAYMENT_URL ?>api/v1/balance \
  -H "API-KEY: qp_test_your_key"</code></pre>
                    </div>

                    <div class="italic">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 block italic">Create Payment Request</span>
                        <div x-show="lang === 'curl'" class="italic">
<pre class="bg-slate-800 text-slate-50 p-4 rounded-lg overflow-x-auto text-sm italic"><code>curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \
  -d amount=5000 \
  -d currency=BDT</code></pre>
                        </div>
                        <div x-show="lang === 'php'" x-cloak class="italic">
<pre class="bg-slate-800 text-slate-50 p-4 rounded-lg overflow-x-auto text-sm italic"><code>$headers = [
  'API-KEY' => 'qp_test_...'
];
$data = ['amount' => 5000];
// Post request...</code></pre>
                        </div>
                    </div>

                    <div class="italic">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 block italic">Sample Response</span>
<pre class="bg-slate-800 text-slate-50 p-4 rounded-lg overflow-x-auto text-sm italic"><code>{
  "status": "success",
  "id": "pay_9a2b7c",
  "checkout_url": "https://..."
}</code></pre>
                    </div>

                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm italic">
                        <div class="flex items-center gap-3 mb-2 italic">
                            <span class="material-symbols-outlined text-primary italic font-bold">info</span>
                            <span class="text-xs font-bold text-slate-900 italic font-bold">API Versions</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed italic">All requests are versioned under <code class="italic font-bold">v1</code>. We ensure backward compatibility for all stable releases.</p>
                    </div>
                </div>
            </div>
        </aside>

    </div>

    <!-- Mobile Navigation Overlay -->
    <div x-show="mobileMenu" x-cloak class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 lg:hidden" @click="mobileMenu = false">
        <div class="absolute inset-y-0 left-0 w-64 bg-white p-6" @click.stop>
            <div class="flex justify-between items-center mb-10 italic">
                <span class="text-xl font-bold text-primary italic underline uppercase"><?= $siteName ?></span>
                <button @click="mobileMenu = false" class="text-slate-400">
                    <span class="material-symbols-outlined italic uppercase">close</span>
                </button>
            </div>
            <nav class="space-y-6 text-sm font-medium italic underline uppercase">
                <a href="#intro" @click="mobileMenu = false" class="block text-slate-600 italic underline uppercase">Introduction</a>
                <a href="#auth" @click="mobileMenu = false" class="block text-slate-600 italic underline uppercase">Authentication</a>
                <a href="#payment-create" @click="mobileMenu = false" class="block text-slate-600 italic underline uppercase">Create Payment</a>
                <a href="#payment-verify" @click="mobileMenu = false" class="block text-slate-600 italic underline uppercase">Verify Payment</a>
                <a href="#webhooks" @click="mobileMenu = false" class="block text-slate-600 italic underline uppercase">Webhooks</a>
            </nav>
        </div>
    </div>

</body>
</html>
