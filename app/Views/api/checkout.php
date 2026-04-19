<!doctype html>
<html lang="en">
<head>
    <title>Checkout - <?= esc($brand_name ?? 'QPay') ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php
        $branding = json_decode($brand->meta ?? '{}', true);
        $primaryColor = $branding['primary_color'] ?? '#6366f1'; // Default Indigo-500
        $brandLogo = $brand->brand_logo ? base_url($brand->brand_logo) : null;
    ?>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .mesh-gradient {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, <?= $primaryColor ?>22 0, transparent 50%), 
                radial-gradient(at 100% 100%, <?= $primaryColor ?>22 0, transparent 50%);
        }
        .method-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
        }
        .animate-in {
            animation: fadeInScale 0.4s ease-out forwards;
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 
                            500: '<?= $primaryColor ?>',
                            600: '<?= $primaryColor ?>ee',
                            700: '<?= $primaryColor ?>cc',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="mesh-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md animate-in">
        <?php if (!empty($test_mode)): ?>
        <div class="bg-indigo-900/10 backdrop-blur-md border border-indigo-200/50 rounded-2xl p-3 mb-4 text-center">
            <span class="text-indigo-800 text-sm font-semibold tracking-wide uppercase">⚡ Test Mode Enabled</span>
        </div>
        <?php endif; ?>

        <div class="glass rounded-[2rem] shadow-2xl shadow-primary-500/10 overflow-hidden border border-white/40">
            <!-- Header Section -->
            <div class="px-8 py-8 border-b border-gray-100/50">
                <div class="flex items-center justify-between mb-6">
                    <?php if ($brandLogo): ?>
                        <img src="<?= $brandLogo ?>" alt="<?= esc($brand_name) ?>" class="h-8 w-auto grayscale-0 brightness-110">
                    <?php else: ?>
                        <span class="text-xl font-bold bg-gradient-to-r from-primary-500 to-indigo-600 bg-clip-text text-transparent"><?= esc($brand_name ?? 'QPay') ?></span>
                    <?php endif; ?>
                    <span class="px-3 py-1 bg-primary-500/10 text-primary-600 text-[10px] font-bold uppercase tracking-widest rounded-full">Secure Checkout</span>
                </div>
                
                <div class="flex items-baseline gap-2">
                    <span class="text-gray-400 text-lg font-medium"><?= esc(strtoupper($currency)) ?></span>
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight"><?= number_format($amount, 2) ?></h1>
                </div>
                <?php if (!empty($customer_email)): ?>
                <div class="mt-4 flex items-center gap-2 text-gray-500">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="text-xs truncate"><?= esc($customer_email) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Content Area -->
            <div class="px-8 py-8">
                <?php if ($status === 'processing'): ?>
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Choose Payment Method</h3>
                        
                        <?php if (empty($methods)): ?>
                            <div class="text-center py-8 bg-red-50/50 rounded-2xl border border-red-100">
                                <p class="text-red-700 font-medium">No payment methods available.</p>
                                <p class="text-xs text-red-600 mt-1">Merchant has not configured any wallets yet.</p>
                            </div>
                        <?php elseif (!empty($payment_method) && !empty($selected_method)): ?>
                            <!-- Manual Payment Instructions -->
                            <div class="space-y-6">
                                <div class="p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Instructions</h4>
                                    
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="p-2 bg-primary-500/5 rounded-2xl">
                                            <img src="<?= base_url(payment_option($payment_method)) ?>" alt="<?= esc($payment_method) ?>" class="w-12 h-12 rounded-xl object-contain">
                                        </div>
                                        <div>
                                            <p class="text-lg font-bold text-gray-900"><?= esc(ucfirst($payment_method)) ?></p>
                                            <p class="text-xs text-gray-500">Manual verification</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <?php 
                                            $params = $selected_method->params;
                                            $activePayments = $params['active_payments'] ?? [];
                                            $instructionsShown = false;
                                            
                                            // Mapping of keys to human-readable labels
                                            $labelMap = [
                                                'personal_number' => 'Personal Number',
                                                'agent_number' => 'Agent Number',
                                                'payment_number' => 'Payment Number',
                                                'merchant_id' => 'Merchant ID',
                                                'merchant_code' => 'Merchant Code'
                                            ];

                                            foreach ($labelMap as $key => $label):
                                                if (!empty($params[$key])):
                                        ?>
                                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-none mb-1"><?= $label ?></p>
                                                <div class="flex items-center justify-between">
                                                    <p class="text-lg font-mono font-bold text-primary-600"><?= esc($params[$key]) ?></p>
                                                    <button onclick="navigator.clipboard.writeText('<?= esc($params[$key]) ?>')" class="p-2 hover:bg-white rounded-lg transition-colors text-gray-400 hover:text-primary-500" title="Copy Number">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php 
                                                endif;
                                            endforeach; 
                                        ?>
                                    </div>

                                    <div class="mt-6 p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                                        <p class="text-[11px] text-indigo-700 leading-relaxed">
                                            Please send the exact amount <strong><?= number_format($amount, 2) ?> <?= esc(strtoupper($currency)) ?></strong>. Your payment will be verified automatically via SMS once received.
                                        </p>
                                    </div>
                                </div>

                                <a href="<?= base_url("api/v1/payment/checkout/{$payment_id}") ?>" class="block text-center text-xs font-bold text-primary-600 hover:text-primary-700 uppercase tracking-widest transition-colors py-2">
                                    Change Payment Method
                                </a>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="<?= base_url("api/v1/payment/checkout/{$payment_id}") ?>" id="checkoutForm">
                                <div class="grid gap-3 mb-8">
                                    <?php foreach ($methods as $i => $method): ?>
                                    <label class="method-card relative flex items-center p-4 bg-white/50 border border-gray-100 rounded-2xl cursor-pointer hover:border-primary-500/50 transition-all duration-300 group">
                                        <input type="radio" name="payment_method" value="<?= esc($method['id']) ?>" class="hidden peer" <?= $i === 0 ? 'checked' : '' ?>>
                                        
                                        <div class="peer-checked:bg-primary-500/5 p-0.5 rounded-xl transition-all">
                                            <img src="<?= base_url(payment_option($method['id'])) ?>" alt="<?= esc($method['name']) ?>" class="w-10 h-10 rounded-lg object-contain bg-white p-1.5 shadow-sm border border-gray-50">
                                        </div>
                                        
                                        <div class="ml-4">
                                            <p class="text-gray-900 font-semibold group-hover:text-primary-600 transition-colors"><?= esc($method['name']) ?></p>
                                            <p class="text-[10px] text-gray-400 font-medium tracking-wide uppercase"><?= esc(str_replace('_', ' ', $method['type'])) ?></p>
                                        </div>

                                        <div class="ml-auto flex items-center justify-center w-5 h-5 rounded-full border-2 border-gray-100 peer-checked:border-primary-500 peer-checked:bg-primary-500 transition-all">
                                            <svg class="w-2.5 h-2.5 text-white scale-0 peer-checked:scale-100 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </label>
                                    <?php endforeach; ?>
                                </div>

                                <button type="submit" class="w-full relative group overflow-hidden bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-primary-500/20 transition-all duration-300 active:scale-95">
                                    <span class="relative z-10">Proceed with Secure Payment</span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($cancel_url)): ?>
                    <a href="<?= esc($cancel_url) ?>" class="block text-center text-gray-400 hover:text-gray-900 text-xs font-semibold tracking-wide uppercase transition-colors">← Back to Merchant</a>
                    <?php endif; ?>

                <?php elseif ($status === 'completed'): ?>
                    <div class="text-center py-10">
                        <div class="w-20 h-20 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Payment Successful</h2>
                        <p class="text-gray-500 mt-2 font-medium">Your transaction has been processed securely.</p>
                        
                        <div class="mt-8 p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Transaction Ref</p>
                            <p class="text-sm font-mono text-gray-800 mt-1"><?= esc($transaction_id ?? 'N/A') ?></p>
                        </div>
                    </div>

                <?php elseif ($status === 'failed'): ?>
                    <div class="text-center py-10">
                        <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Payment Failed</h2>
                        <p class="text-gray-500 mt-2 font-medium">We couldn't process your payment at this moment.</p>
                        <?php if (!empty($cancel_url)): ?>
                        <a href="<?= esc($cancel_url) ?>" class="inline-block mt-8 bg-gray-900 text-white font-bold py-3 px-8 rounded-xl hover:shadow-lg transition-all active:scale-95">Try Again</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="px-8 py-5 bg-gray-50/50 flex items-center justify-center gap-2 border-t border-gray-100">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Powered by <span class="text-gray-900">QPay Cloud</span></p>
            </div>
        </div>
    </div>
</body>
</html>
