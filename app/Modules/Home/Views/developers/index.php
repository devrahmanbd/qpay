<?php
define("PAYMENT_URL", rtrim(base_url(), '/') . '/');
?>
<section class="relative px-6 py-20 md:py-32 overflow-hidden bg-white">
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="max-w-5xl mx-auto text-center space-y-8 relative z-10">
        <div class="inline-flex items-center px-4 py-1.5 bg-primary/5 rounded-full border border-primary/10 mb-4">
            <span class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-[14px]">terminal</span> Developer Hub
            </span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tighter text-slate-900 leading-[1.05]">
            Build with <span class="text-primary italic">Qpay</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            The complete toolkit for builders, merchants, and fintech innovators in South Asia. Integrate in minutes, scale to millions.
        </p>
        <div class="pt-6 flex flex-wrap justify-center gap-4">
            <a href="<?= base_url('developers/docs') ?>" class="px-8 py-4 bg-primary text-white rounded-xl text-lg font-bold shadow-lg shadow-primary/20 hover:-translate-y-px transition-all active:scale-95">
                Explore the Docs
            </a>
            <a href="<?= base_url() ?>" class="px-8 py-4 bg-white text-slate-900 border border-slate-200 rounded-xl text-lg font-bold hover:bg-slate-50 transition-all">
                Get API Keys
            </a>
        </div>
    </div>
</section>

<!-- Bento Grid Section -->
<section class="px-6 py-20 bg-slate-50/50">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- API Documentation -->
            <a href="<?= base_url('developers/docs') ?>" class="bg-white p-8 rounded-3xl shadow-[0px_4px_20px_rgba(73,62,229,0.04),0px_10px_40px_rgba(24,28,30,0.06)] group hover:ring-2 hover:ring-primary/20 transition-all duration-300">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">API Documentation</h3>
                <p class="text-slate-500 text-sm leading-relaxed italic">
                    Comprehensive guides and endpoint references for every integration.
                </p>
            </a>

            <!-- SDKs & Integrations -->
            <a href="<?= base_url('developers/docs#sdks') ?>" class="bg-white p-8 rounded-3xl shadow-[0px_4px_20px_rgba(73,62,229,0.04),0px_10px_40px_rgba(24,28,30,0.06)] group hover:ring-2 hover:ring-primary/20 transition-all duration-300">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-indigo-600">extension</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 font-bold italic">SDKs & Integrations</h3>
                <p class="text-slate-500 text-sm leading-relaxed italic">
                    Ready-to-use libraries for Laravel, WordPress, and Node.js.
                </p>
            </a>

            <!-- Webhooks -->
            <a href="<?= base_url('developers/docs#webhooks') ?>" class="bg-white p-8 rounded-3xl shadow-[0px_4px_20px_rgba(73,62,229,0.04),0px_10px_40px_rgba(24,28,30,0.06)] group hover:ring-2 hover:ring-primary/20 transition-all duration-300">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-amber-600">notifications_active</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 font-bold italic">Webhooks</h3>
                <p class="text-slate-500 text-sm leading-relaxed italic">
                    Real-time payment event notifications for your server.
                </p>
            </a>

            <!-- API Keys -->
            <a href="<?= base_url() ?>" class="bg-white p-8 rounded-3xl shadow-[0px_4px_20px_rgba(73,62,229,0.04),0px_10px_40px_rgba(24,28,30,0.06)] group hover:ring-2 hover:ring-primary/20 transition-all duration-300">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-emerald-600">vpn_key</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 font-bold italic">API Keys</h3>
                <p class="text-slate-500 text-sm leading-relaxed italic">
                    Securely manage your test and production credentials.
                </p>
            </a>
        </div>
    </div>
</section>

<!-- Featured Snippet Section -->
<section class="px-6 py-24 bg-white border-y border-slate-100">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 items-center gap-16">
        <div class="space-y-6">
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight italic">Integration that scales with your ambition.</h2>
            <p class="text-slate-600 text-lg leading-relaxed italic">
                Copy and paste our robust API endpoints and get your first transaction running in under 15 minutes. Our environment is built by developers, for developers.
            </p>
            <div class="space-y-4 pt-4">
                <div class="flex items-center gap-3 italic">
                    <span class="material-symbols-outlined text-primary font-bold italic">check_circle</span>
                    <span class="font-bold text-slate-900 italic">99.99% API Uptime</span>
                </div>
                <div class="flex items-center gap-3 italic">
                    <span class="material-symbols-outlined text-primary font-bold italic">check_circle</span>
                    <span class="font-bold text-slate-900 italic">Sandbox testing environment</span>
                </div>
            </div>
        </div>
        <div class="w-full bg-slate-900 rounded-3xl p-8 shadow-2xl relative overflow-hidden group">
            <div class="flex items-center gap-1.5 mb-8">
                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
            </div>
            <div class="font-mono text-sm space-y-2 text-slate-300 overflow-x-auto">
                <p><span class="text-pink-400">curl</span> -X POST <?= PAYMENT_URL ?>api/v1/payment/create \</p>
                <p class="pl-4">-H <span class="text-emerald-400">"API-KEY: qp_test_..."</span> \</p>
                <p class="pl-4">-d amount=5000 \</p>
                <p class="pl-4">-d currency=BDT</p>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent pointer-events-none"></div>
        </div>
    </div>
</section>
