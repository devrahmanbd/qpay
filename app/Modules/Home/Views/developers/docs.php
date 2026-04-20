<?php
define("PAYMENT_URL", rtrim(base_url(), '/') . '/');
$siteName = site_config("site_name", "QPay");
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Reference | <?= $siteName ?></title>
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
                        surface: '#F6F9FC',
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
        .ambient-shadow { box-shadow: 0px 4px 20px rgba(73, 62, 229, 0.04), 0px 10px 40px rgba(24, 28, 30, 0.06); }
        .code-pane-height { height: calc(100vh - 4rem); }
        body { -webkit-font-smoothing: antialiased; }
        pre { color: inherit !important; }
    </style>
</head>
<body class="bg-white text-slate-900 font-sans selection:bg-primary/10" x-data="{ lang: 'curl', mobileMenu: false }">

    <!-- Fixed Universal Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white/80 backdrop-blur-xl border-b border-slate-100 z-50 flex items-center justify-between px-6">
        <div class="flex items-center gap-8">
            <a href="<?= base_url() ?>" class="text-2xl font-black text-primary tracking-tighter">Qpay</a>
            <div class="h-6 w-px bg-slate-200 hidden md:block"></div>
            <nav class="hidden md:flex gap-6 text-sm font-semibold text-slate-500">
                <a href="<?= base_url('developers') ?>" class="hover:text-primary transition-colors">Developer Hub</a>
                <a href="#" class="text-primary">API Reference</a>
                <a href="#" class="hover:text-primary transition-colors">Support</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-primary text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:-translate-y-px transition-all active:scale-95">Dashboard</button>
            <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-slate-600">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <div class="flex pt-16">
        
        <!-- Column 1: Sidebar Navigation (Fixed on Desktop) -->
        <aside class="hidden lg:block fixed left-0 top-16 bottom-0 w-64 bg-surface border-r border-slate-100 overflow-y-auto p-8">
            <nav class="space-y-8">
                <div>
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Introduction</h3>
                    <ul class="space-y-2 text-[13px] font-medium italic">
                        <li><a href="#intro" class="block py-1.5 text-primary hover:text-primary italic">Getting Started</a></li>
                        <li><a href="#auth" class="block py-1.5 text-slate-600 hover:text-primary italic">Authentication</a></li>
                        <li><a href="#test-mode" class="block py-1.5 text-slate-600 hover:text-primary italic">Test Mode</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Core APIs</h3>
                    <ul class="space-y-2 text-[13px] font-medium italic">
                        <li><a href="#payment-create" class="block py-1.5 text-slate-600 hover:text-primary italic">Create Payment</a></li>
                        <li><a href="#payment-verify" class="block py-1.5 text-slate-600 hover:text-primary italic">Verify Payment</a></li>
                        <li><a href="#refund-create" class="block py-1.5 text-slate-600 hover:text-primary italic">Issue Refund</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Security</h3>
                    <ul class="space-y-2 text-[13px] font-medium italic">
                        <li><a href="#webhooks" class="block py-1.5 text-slate-600 hover:text-primary italic">Webhooks</a></li>
                        <li><a href="#signatures" class="block py-1.5 text-slate-600 hover:text-primary italic">Signatures</a></li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content Wrapper (Col 2 & Col 3) -->
        <div class="flex-1 lg:ml-64 w-full">
            
            <!-- Intro Section (Horizontal Split) -->
            <section id="intro" class="flex flex-col lg:flex-row min-h-[500px] border-b border-slate-100">
                <!-- Middle Pane (Description) -->
                <div class="lg:w-1/2 p-8 lg:p-16 bg-white">
                    <div class="max-w-2xl">
                        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tighter mb-6 italic">API Reference</h1>
                        <p class="text-lg text-slate-600 leading-relaxed mb-10 italic">
                            The QPay API is a developer-first financial engine. We use standard REST patterns, JSON body encoding, and HMAC signatures to ensure your integrations are fast, secure, and future-proof.
                        </p>
                        
                        <div class="flex items-center gap-4 p-6 bg-surface rounded-2xl border border-slate-100 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined">link</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block italic">Base URL</span>
                                <code class="text-sm font-bold text-slate-900"><?= PAYMENT_URL ?>api/v1</code>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Pane (Code) -->
                <div class="lg:w-1/2 p-8 lg:p-16 bg-slate-950 text-slate-400">
                    <div class="sticky top-24">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-6 block italic">Base Endpoint Definition</span>
                        <div class="p-6 bg-slate-900 rounded-xl border border-white/5 font-mono text-sm leading-relaxed ambient-shadow italic">
                            <span class="text-primary italic">// All requests are rooted at</span><br>
                            <span class="text-emerald-400">"<?= PAYMENT_URL ?>api/v1/"</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Authentication Section -->
            <section id="auth" class="flex flex-col lg:flex-row min-h-[400px] border-b border-slate-100">
                <!-- Middle Pane -->
                <div class="lg:w-1/2 p-8 lg:p-16 bg-white italic">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic">Authentication</h2>
                    <p class="text-slate-600 leading-relaxed mb-8 italic">
                        Authorize your requests by including your secret API key in the <code class="bg-surface px-2 py-1 rounded italic font-bold">API-KEY</code> header. All keys start with <code class="font-bold italic">qp_</code>.
                    </p>
                    <div class="p-6 bg-amber-50 rounded-2xl border border-amber-100 italic">
                        <div class="flex items-center gap-3 mb-2 italic">
                            <span class="material-symbols-outlined text-amber-600 italic">lock</span>
                            <h4 class="text-sm font-bold text-amber-900 italic">Security best practices</h4>
                        </div>
                        <p class="text-xs text-amber-700 leading-relaxed italic">Never expose your secret keys in client-side code (browsers/mobile apps). Always route QPay calls through your secure backend.</p>
                    </div>
                </div>
                <!-- Right Pane -->
                <div class="lg:w-1/2 p-8 lg:p-16 bg-slate-950 text-slate-400">
                    <div class="sticky top-24">
                        <div class="flex gap-6 mb-6 border-b border-white/5 pb-2">
                            <button @click="lang = 'curl'" :class="lang === 'curl' ? 'text-primary border-b-2 border-primary' : 'text-slate-500'" class="text-[10px] font-bold uppercase transition-all pb-1 italic">cURL</button>
                            <button @click="lang = 'php'" :class="lang === 'php' ? 'text-primary border-b-2 border-primary' : 'text-slate-500'" class="text-[10px] font-bold uppercase transition-all pb-1 italic">PHP</button>
                        </div>
                        <div x-show="lang === 'curl'" class="p-6 bg-slate-900 rounded-xl border border-white/5 font-mono text-xs leading-relaxed italic">
                            <span class="text-blue-400 italic">curl</span> <span class="text-white italic"><?= PAYMENT_URL ?>api/v1/balance</span> \<br>
                            &nbsp;&nbsp;-H <span class="text-emerald-400 italic">"API-KEY: qp_test_51Mz..."</span>
                        </div>
                        <div x-show="lang === 'php'" x-cloak class="p-6 bg-slate-900 rounded-xl border border-white/5 font-mono text-xs leading-relaxed italic">
                            <span class="text-indigo-400 font-bold italic">$client</span> = <span class="text-white italic">new GuzzleHttp\Client()</span>;<br>
                            <span class="text-indigo-400 font-bold italic">$client</span>->request(<span class="text-emerald-400 italic">'GET'</span>, <span class="text-emerald-400 italic">'balance'</span>, [<br>
                            &nbsp;&nbsp;<span class="text-emerald-400 italic">'headers'</span> => [<span class="text-emerald-400 italic">'API-KEY'</span> => <span class="text-emerald-400 italic">'qp_test_...'</span>]<br>
                            ]);
                        </div>
                    </div>
                </div>
            </section>

            <!-- Create Payment Section -->
            <section id="payment-create" class="flex flex-col lg:flex-row border-b border-slate-100">
                <!-- Middle Pane -->
                <div class="lg:w-1/2 p-8 lg:p-16 bg-white italic">
                    <div class="flex items-center gap-3 mb-6 italic">
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase italic tracking-widest">POST</span>
                        <code class="text-sm font-bold text-slate-800 italic">/payment/create</code>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic">Create a Payment</h2>
                    <p class="text-slate-600 leading-relaxed mb-10 italic">
                        Generate a secure checkout link for your customers. This begins a transaction that you can track via callbacks and webhooks.
                    </p>
                    
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 italic">Query Parameters</h3>
                    <div class="border-t border-slate-100 divide-y divide-slate-100 italic">
                        <div class="py-5 flex gap-8 italic">
                            <div class="w-1/3 italic">
                                <span class="font-mono text-sm font-bold text-slate-900 italic">amount</span><span class="text-[10px] text-primary font-bold ml-2 italic">REQUIRED</span>
                            </div>
                            <div class="flex-1 italic text-slate-600 text-sm">
                                The amount in Poisha (e.g., 100 for 1.00 BDT).
                            </div>
                        </div>
                        <div class="py-5 flex gap-8 italic">
                            <div class="w-1/3 italic">
                                <span class="font-mono text-sm font-bold text-slate-900 italic">currency</span><span class="text-[10px] text-primary font-bold ml-2 italic tracking-tighter">REQUIRED</span>
                            </div>
                            <div class="flex-1 italic text-slate-600 text-sm italic">
                                Three-letter ISO code (fixed at <code class="italic font-bold">BDT</code>).
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Pane -->
                <div class="lg:w-1/2 p-8 lg:p-16 bg-slate-950 text-slate-400 italic">
                    <div class="sticky top-24 italic">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4 block italic">Request Payload</span>
                        <div class="p-6 bg-slate-900 rounded-2xl border border-white/5 font-mono text-xs leading-relaxed italic text-blue-300">
                            curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \<br>
                            &nbsp;&nbsp;-d amount=5000 \<br>
                            &nbsp;&nbsp;-d currency=BDT
                        </div>
                        <div class="mt-8 italic text-indigo-200">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4 block italic">Success Response</span>
                            <pre class="p-6 bg-slate-900 rounded-2xl border border-white/5 font-mono text-[11px] leading-relaxed italic">
{
  "status": "success",
  "id": "pay_abc123",
  "checkout_url": "https://qpay.com/check/123"
}</pre>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Verify Section -->
            <section id="payment-verify" class="flex flex-col lg:flex-row border-b border-slate-100">
                <div class="lg:w-1/2 p-8 lg:p-16 bg-white italic">
                    <div class="flex items-center gap-3 mb-6 italic">
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase italic tracking-widest">GET</span>
                        <code class="text-sm font-bold text-slate-800 italic">/payment/verify/{id}</code>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic">Verify Payment</h2>
                    <p class="text-slate-600 leading-relaxed mb-6 italic">Confirm the final status of a transaction before delivering value.</p>
                </div>
                <div class="lg:w-1/2 p-8 lg:p-16 bg-slate-950 text-slate-400 italic">
                    <div class="p-6 bg-slate-900 rounded-2xl border border-white/5 font-mono text-xs italic text-emerald-400">
                        curl <?= PAYMENT_URL ?>api/v1/payment/verify/pay_abc
                    </div>
                </div>
            </section>

            <!-- Webhooks Section -->
            <section id="webhooks" class="flex flex-col lg:flex-row border-b border-slate-100">
                <div class="lg:w-1/2 p-8 lg:p-16 bg-white italic">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 italic text-primary font-bold">Webhooks</h2>
                    <p class="text-slate-600 leading-relaxed mb-8 italic">Stay updated in real-time. QPay will POST to your endpoint whenever a payment status changes.</p>
                    <div class="p-6 bg-primary/5 rounded-2xl border border-primary/10 italic">
                        <h4 class="text-sm font-bold text-primary mb-2 italic tracking-tight">QPay-Signature Header</h4>
                        <p class="text-xs text-slate-500 italic">All webhooks include an HMAC signature. Use your webhook secret to verify authenticity before processing.</p>
                    </div>
                </div>
                <div class="lg:w-1/2 p-8 lg:p-16 bg-slate-900 text-slate-400 italic">
                    <div class="sticky top-24 italic">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4 block italic">Verification Snippet (Node.js)</span>
                        <pre class="p-6 bg-slate-900 rounded-2xl border border-white/5 font-mono text-[11px] leading-relaxed italic text-indigo-300 italic">
const sig = req.headers['qpay-signature'];
const event = QPay.Webhooks.constructEvent(
  req.body, sig, secret
);</pre>
                    </div>
                </div>
            </section>

            <section class="p-16 bg-white text-center italic text-slate-300">
                End of Documentation
            </section>

        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenu" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 lg:hidden" @click="mobileMenu = false">
        <div class="absolute inset-y-0 left-0 w-64 bg-white p-8" @click.stop>
            <h2 class="text-xl font-bold text-primary mb-8 italic">QPay API</h2>
            <nav class="space-y-4 text-sm font-medium italic">
                <a href="#intro" @click="mobileMenu = false" class="block text-slate-600 italic">Introduction</a>
                <a href="#auth" @click="mobileMenu = false" class="block text-slate-600 italic">Authentication</a>
                <a href="#payment-create" @click="mobileMenu = false" class="block text-slate-600 italic">Create Payment</a>
                <a href="#webhooks" @click="mobileMenu = false" class="block text-slate-600 italic">Webhooks</a>
            </nav>
        </div>
    </div>

</body>
</html>
