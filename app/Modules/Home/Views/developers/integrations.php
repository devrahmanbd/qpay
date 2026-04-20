<style>
    .premium-gradient {
        background: linear-gradient(135deg, #493ee5 0%, #635bff 100%);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(24px);
    }
</style>

<!-- Hero Section -->
<section class="mb-16 pt-12 animate-fade-in">
    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 mb-4 italic">Integrations & SDKs</h1>
    <p class="text-lg text-slate-600 max-w-2xl leading-relaxed italic">
        Connect Qpay to your existing stack with our official plugins and libraries. Engineered for security and high-speed throughput.
    </p>
</section>

<!-- Main Grid -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">
    
    <!-- SDK & Plugin Cards -->
    <div class="md:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-8">
        
        <!-- WordPress (Recommended) -->
        <div class="bg-white p-8 rounded-2xl shadow-[0px_4px_20px_rgba(73,62,229,0.04)] border-2 border-primary/10 group hover:shadow-[0px_10px_40px_rgba(24,28,30,0.06)] transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase tracking-widest rounded-bl-xl">Recommended</div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">language</span>
            </div>
            <h3 class="text-xl font-bold mb-2 italic">WordPress Plugin</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed italic">
                Accept payments on any WordPress site. Includes built-in support for <strong>WooCommerce</strong>, shortcodes for buttons, custom forms, and donation modules.
            </p>
            <a href="<?= base_url('sdks/wordpress/qpay-wordpress.zip') ?>" download class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-600 transition-all shadow-lg shadow-primary/20">
                Download Plugin <span class="material-symbols-outlined text-base">download</span>
            </a>
        </div>

        <!-- WHMCS -->
        <div class="bg-white p-8 rounded-2xl shadow-[0px_4px_20px_rgba(73,62,229,0.04)] border border-slate-100 group hover:shadow-[0px_10px_40px_rgba(24,28,30,0.06)] transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">dns</span>
            </div>
            <h3 class="text-xl font-bold mb-2 italic">WHMCS</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed italic">
                Automated billing and client management integration for WHMCS. Includes callback and hook support.
            </p>
            <a href="<?= base_url('sdks/whmcs/qpay-whmcs.zip') ?>" download class="inline-flex items-center text-primary font-bold text-sm group-hover:gap-2 transition-all">
                Download Module <span class="material-symbols-outlined ml-1 text-base">download</span>
            </a>
        </div>

        <!-- NodeJS -->
        <div class="bg-white p-8 rounded-2xl shadow-[0px_4px_20px_rgba(73,62,229,0.04)] border border-slate-100 group hover:shadow-[0px_10px_40px_rgba(24,28,30,0.06)] transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl">javascript</span>
            </div>
            <h3 class="text-xl font-bold mb-2 italic">NodeJS SDK</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed italic">
                A modern client for the Qpay API. Supports async/await, webhook verification, and all API endpoints.
            </p>
            <a href="<?= base_url('sdks/nodejs/qpay.js') ?>" download class="inline-flex items-center text-primary font-bold text-sm group-hover:gap-2 transition-all">
                Download SDK <span class="material-symbols-outlined ml-1 text-base">download</span>
            </a>
        </div>

        <!-- PHP -->
        <div class="bg-white p-8 rounded-2xl shadow-[0px_4px_20px_rgba(73,62,229,0.04)] border border-slate-100 group hover:shadow-[0px_10px_40px_rgba(24,28,30,0.06)] transition-all duration-300">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-primary text-3xl font-bold">code</span>
            </div>
            <h3 class="text-xl font-bold mb-2 italic">PHP Library</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed italic">
                Lightweight single-file PHP client for integrating payments into any PHP project with zero dependencies.
            </p>
            <a href="<?= base_url('sdks/php/QPay.php') ?>" download class="inline-flex items-center text-primary font-bold text-sm group-hover:gap-2 transition-all">
                Download QPay.php <span class="material-symbols-outlined ml-1 text-base">download</span>
            </a>
        </div>

    </div>

    <!-- Featured Highlight: Direct API -->
    <div class="md:col-span-4 bg-primary text-white p-8 rounded-2xl flex flex-col justify-between premium-gradient shadow-xl relative overflow-hidden italic">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg height="100%" preserveaspectratio="none" viewbox="0 0 100 100" width="100%">
                <path d="M0 100 C 20 0 50 0 100 100" fill="none" stroke="white" stroke-width="0.5"></path>
                <path d="M0 80 C 30 20 70 20 100 80" fill="none" stroke="white" stroke-width="0.5"></path>
            </svg>
        </div>
        <div class="relative z-10 italic">
            <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase mb-6 inline-block italic border border-white/20">Direct API</span>
            <h2 class="text-2xl font-bold mb-4 italic">Custom Integrations</h2>
            <p class="text-white/80 text-sm mb-8 leading-relaxed italic">
                Not using a framework? Our RESTful API allows you to build custom experiences on any platform.
            </p>
            <div class="space-y-3 italic">
                <div class="flex items-center gap-3 bg-white/10 p-4 rounded-xl italic">
                    <span class="material-symbols-outlined text-sm font-bold">api</span>
                    <span class="text-xs font-mono font-bold">POST /v1/payments</span>
                </div>
                <div class="flex items-center gap-3 bg-white/10 p-4 rounded-xl italic">
                    <span class="material-symbols-outlined text-sm font-bold">key</span>
                    <span class="text-xs font-mono font-bold">API-KEY: qp_test_...</span>
                </div>
            </div>
        </div>
        <a href="<?= base_url('developers/docs') ?>" class="relative z-10 mt-8 w-full bg-white text-primary py-4 rounded-xl font-bold text-center hover:bg-slate-50 transition-colors active:scale-[0.98] italic shadow-lg">
            Explore Documentation
        </a>
    </div>

</div>

<!-- Footer Resources -->
<section class="mt-24 pb-12 italic border-t border-slate-100 pt-16">
    <div class="flex items-center justify-between mb-10 italic">
        <h2 class="text-2xl font-bold italic">Developer Resources</h2>
        <a href="<?= base_url('developers/docs') ?>" class="text-primary font-bold text-sm italic">See all docs</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 italic">
        <div class="flex gap-5 p-6 hover:bg-slate-50 rounded-2xl transition-colors italic">
            <div class="w-12 h-12 shrink-0 bg-indigo-50 text-primary flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined font-bold">menu_book</span>
            </div>
            <div>
                <h4 class="font-bold mb-1 italic">Quick Start Guide</h4>
                <p class="text-xs text-slate-500 leading-relaxed italic">Get up and running with your first transaction in under 5 minutes.</p>
            </div>
        </div>
        <div class="flex gap-5 p-6 hover:bg-slate-50 rounded-2xl transition-colors italic">
            <div class="w-12 h-12 shrink-0 bg-indigo-50 text-primary flex items-center justify-center rounded-xl">
                <span class="material-symbols-outlined font-bold">webhook</span>
            </div>
            <div>
                <h4 class="font-bold mb-1 italic">Webhook Events</h4>
                <p class="text-xs text-slate-500 leading-relaxed italic">Real-time notifications for payment success, refunds, and disputes.</p>
            </div>
        </div>
        <div class="flex gap-5 p-6 hover:bg-slate-50 rounded-2xl transition-colors italic group">
            <div class="w-12 h-12 shrink-0 bg-indigo-50 text-primary flex items-center justify-center rounded-xl group-hover:bg-primary group-hover:text-white transition-colors">
                <span class="material-symbols-outlined font-bold">security</span>
            </div>
            <div>
                <h4 class="font-bold mb-1 italic">Security Best Practices</h4>
                <p class="text-xs text-slate-500 leading-relaxed italic">Implementing PCI DSS compliance and 3D Secure 2.0 flows.</p>
            </div>
        </div>
    </div>
</section>
