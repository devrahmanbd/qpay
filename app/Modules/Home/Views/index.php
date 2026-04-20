<section class="reveal-up px-6 py-12 md:py-24 max-w-7xl mx-auto flex flex-col items-center text-center">
    <div class="inline-flex items-center px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-xs font-bold tracking-wide uppercase mb-6">
        Now Live in South Asia
    </div>
    <h1 class="text-4xl md:text-6xl font-extrabold text-[#1A1F36] tracking-tight leading-[1.1] mb-6 max-w-3xl">
        The Modern Payments Infrastructure for South Asia
    </h1>
    <p class="text-lg md:text-xl text-[#4F566B] leading-relaxed max-w-2xl mb-10">
        Accept bKash, Nagad, bank transfers, and cards with one unified API. Built for developers, trusted by thousands of merchants.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
        <a href="<?= base_url('sign-up') ?>" class="hero-gradient text-white px-8 py-4 rounded-xl font-bold ambient-shadow active:scale-95 transition-all text-lg inline-flex items-center justify-center">
            Create Account
        </a>
        <a href="<?= base_url('developers') ?>" class="bg-surface-container-lowest border border-outline-variant/20 text-on-surface-variant px-8 py-4 rounded-xl font-bold hover:bg-surface-container-low transition-all text-lg flex items-center justify-center gap-2">
            Explore the Docs
            <span class="material-symbols-outlined text-xl">arrow_forward</span>
        </a>
    </div>
    <div class="mt-16 w-full max-w-5xl rounded-2xl overflow-hidden ambient-shadow border border-outline-variant/10 scroll-reveal">
        <div class="bg-slate-900 p-2 flex items-center gap-2 px-4">
            <div class="flex gap-1.5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500/80"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-green-500/80"></div>
            </div>
            <div class="text-[10px] text-slate-500 font-mono ml-4">Terminal — bash</div>
        </div>
        <div class="p-6 bg-[#0F172A] text-left font-mono text-sm leading-relaxed overflow-x-auto">
            <p class="text-indigo-400">curl <span class="text-white"><?= base_url('api/v1/payments') ?></span> \</p>
            <p class="text-slate-400 pl-4">-u <span class="text-green-400">sk_test_4eC39HqLyjWDarjtT1zdp7dc</span>:</p>
            <p class="text-slate-400 pl-4">-d <span class="text-green-400">amount</span>=2000 \</p>
            <p class="text-slate-400 pl-4">-d <span class="text-green-400">currency</span>=bdt \</p>
            <p class="text-slate-400 pl-4">-d <span class="text-green-400">payment_method_types[]</span>=bkash</p>
        </div>
    </div>
</section>

<section class="bg-surface-container-low py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col items-center text-center mb-16 scroll-reveal">
            <h2 class="text-3xl md:text-4xl font-bold text-on-surface tracking-tight mb-4">Simple Integration, Powerful Results</h2>
            <p class="text-on-surface-variant max-w-xl">Focus on building your product while we handle the complexity of local payment networks.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-surface-container-lowest p-8 rounded-2xl ambient-shadow border border-outline-variant/10 group hover:-translate-y-1 transition-transform scroll-reveal">
                <div class="w-14 h-14 rounded-full bg-primary-fixed flex items-center justify-center mb-6 text-primary">
                    <span class="material-symbols-outlined text-3xl">person_add</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-on-surface">Create Your Account</h3>
                <p class="text-on-surface-variant leading-relaxed">Sign up in minutes with your business details and get instant access to our sandbox environment.</p>
            </div>
            <div class="bg-surface-container-lowest p-8 rounded-2xl ambient-shadow border border-outline-variant/10 group hover:-translate-y-1 transition-transform scroll-reveal" style="transition-delay: 100ms">
                <div class="w-14 h-14 rounded-full bg-primary-fixed flex items-center justify-center mb-6 text-primary">
                    <span class="material-symbols-outlined text-3xl">code</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-on-surface">Integrate the API</h3>
                <p class="text-on-surface-variant leading-relaxed">Our unified SDKs for Node.js, Python, and Go make it simple to connect all local payment methods at once.</p>
            </div>
            <div class="bg-surface-container-lowest p-8 rounded-2xl ambient-shadow border border-outline-variant/10 group hover:-translate-y-1 transition-transform scroll-reveal" style="transition-delay: 200ms">
                <div class="w-14 h-14 rounded-full bg-primary-fixed flex items-center justify-center mb-6 text-primary">
                    <span class="material-symbols-outlined text-3xl">verified_user</span>
                </div>
                <h3 class="text-xl font-bold mb-3 text-on-surface">Accept Payments</h3>
                <p class="text-on-surface-variant leading-relaxed">Go live and start receiving payments globally. Benefit from industry-leading success rates and security.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 px-6 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="scroll-reveal">
            <h2 class="text-3xl font-bold text-on-surface tracking-tight mb-6">Designed for high-growth commerce</h2>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-primary">speed</span>
                    <div>
                        <h4 class="font-bold text-on-surface">Unmatched Performance</h4>
                        <p class="text-sm text-on-surface-variant">Built on a distributed cloud architecture with 99.99% uptime for massive transaction volumes.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-primary">shield_lock</span>
                    <div>
                        <h4 class="font-bold text-on-surface">Bank-Grade Security</h4>
                        <p class="text-sm text-on-surface-variant">PCI-DSS Level 1 compliance ensures every transaction is encrypted and protected from fraud.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-primary">insights</span>
                    <div>
                        <h4 class="font-bold text-on-surface">Deep Analytics</h4>
                        <p class="text-sm text-on-surface-variant">Understand your customers with detailed transaction reporting and settlement insights.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative scroll-reveal" style="transition-delay: 200ms">
            <div class="aspect-video rounded-3xl bg-surface-container-highest overflow-hidden ambient-shadow border border-outline-variant/20">
                <img class="w-full h-full object-cover" alt="clean modern dashboard interface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRJCuAH-LuwSBpyuw_Bob8dcz6NxkXN_gfXR_16w_91m8RCn9bYERVOUC0RTJt-19oP-53bFbqWNd8wM-DQuffUDS_LQZCFY-S38VMQvEetdwc-Unp8ZRJnRiF2wSiKRSDuvj4-H58tZu40GrmjhM69h-L5vjGi0Hrk2BQicmFU7rF_baCl592CsWR5j2OV4n3taxIntb93Qlq-hk6f-aaq5udE0Ka_LJfSrfvQZCCRWYAgQFMH3k9Tf9oeO_NlRoAntQ3tQ00vWg"/>
            </div>
            <div class="absolute -bottom-6 -left-6 bg-surface-container-lowest p-6 rounded-2xl ambient-shadow max-w-[240px] hidden md:block">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-green-500" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <span class="text-xs font-bold text-on-surface uppercase tracking-wider">Settlement Success</span>
                </div>
                <div class="text-2xl font-bold text-on-surface">৳482,900.00</div>
                <div class="text-[10px] text-on-surface-variant mt-1">Transferred to bank account ending in *8291</div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 px-6">
    <div class="max-w-7xl mx-auto rounded-[2rem] hero-gradient p-12 md:p-20 text-center relative overflow-hidden scroll-reveal">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg height="100%" width="100%" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern height="40" id="grid" patternunits="userSpaceOnUse" width="40"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"></path></pattern></defs>
                <rect fill="url(#grid)" height="100%" width="100%"></rect>
            </svg>
        </div>
        <h2 class="text-3xl md:text-5xl font-bold text-white tracking-tight mb-6 relative z-10">Ready to scale your business?</h2>
        <p class="text-indigo-100 text-lg mb-10 max-w-xl mx-auto relative z-10">Join over 5,000 companies in South Asia using Qpay to power their global commerce.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
            <a href="<?= base_url('sign-up') ?>" class="bg-white text-primary px-8 py-4 rounded-xl font-bold active:scale-95 transition-all text-lg inline-flex items-center justify-center">
                Create Your Free Account
            </a>
            <a href="#contact-sales" class="bg-primary/20 border border-white/20 text-white px-8 py-4 rounded-xl font-bold hover:bg-white/10 transition-all text-lg inline-flex items-center justify-center">
                Contact Sales
            </a>
        </div>
    </div>
</section>
