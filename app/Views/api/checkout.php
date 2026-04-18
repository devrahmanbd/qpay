<!doctype html>
<html lang="en">
<head>
    <title>Checkout - <?= esc($brand_name ?? 'QPay') ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#f5f3ff',100:'#ede9fe',200:'#ddd6fe',300:'#c4b5fd',400:'#a78bfa',500:'#8b5cf6',600:'#7c3aed',700:'#6d28d9',800:'#5b21b6',900:'#4c1d95' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <?php if (!empty($test_mode)): ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4 text-center">
            <span class="text-yellow-800 text-sm font-medium">⚠ Test Mode — No real charges will be made</span>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-primary-700 px-6 py-5 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-200 text-sm"><?= esc($brand_name ?? 'Payment') ?></p>
                        <p class="text-3xl font-bold mt-1"><?= esc(strtoupper($currency)) ?> <?= number_format($amount, 2) ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <?php if (!empty($customer_email)): ?>
                <p class="text-primary-200 text-xs mt-2"><?= esc($customer_email) ?></p>
                <?php endif; ?>
            </div>

            <div class="p-6">
                <?php if ($status === 'processing'): ?>
                    <h3 class="text-gray-700 font-semibold mb-4">Select Payment Method</h3>

                    <form method="POST" action="<?= base_url("api/v1/payment/checkout/{$payment_id}/process") ?>">
                        <div class="space-y-2 mb-6">
                            <?php foreach ($methods as $i => $method): ?>
                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition-all group">
                                <input type="radio" name="payment_method" value="<?= esc($method['id']) ?>" class="text-primary-600 focus:ring-primary-500" <?= $i === 0 ? 'checked' : '' ?>>
                                <img src="<?= base_url(payment_option($method['id'])) ?>" alt="<?= esc($method['name']) ?>" class="w-8 h-8 rounded ml-3 object-contain">
                                <span class="ml-3 text-gray-700 font-medium group-hover:text-primary-700"><?= esc($method['name']) ?></span>
                                <span class="ml-auto text-xs text-gray-400 capitalize"><?= esc(str_replace('_', ' ', $method['type'])) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>

                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors">
                            Pay <?= esc(strtoupper($currency)) ?> <?= number_format($amount, 2) ?>
                        </button>
                    </form>

                    <?php if (!empty($cancel_url)): ?>
                    <a href="<?= esc($cancel_url) ?>" class="block text-center text-gray-400 hover:text-gray-600 text-sm mt-4 transition-colors">Cancel payment</a>
                    <?php endif; ?>

                <?php elseif ($status === 'completed'): ?>
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Payment Completed</h3>
                        <p class="text-gray-500 text-sm mt-1">Transaction ID: <?= esc($transaction_id ?? 'N/A') ?></p>
                    </div>

                <?php elseif ($status === 'failed'): ?>
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Payment Failed</h3>
                        <p class="text-gray-500 text-sm mt-1">This payment could not be processed.</p>
                        <?php if (!empty($cancel_url)): ?>
                        <a href="<?= esc($cancel_url) ?>" class="inline-block mt-4 text-primary-600 hover:text-primary-700 text-sm font-medium">Return to merchant</a>
                        <?php endif; ?>
                    </div>

                <?php elseif ($status === 'refunded'): ?>
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Payment Refunded</h3>
                        <p class="text-gray-500 text-sm mt-1">This payment has been refunded.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="border-t px-6 py-3 bg-gray-50 text-center">
                <p class="text-xs text-gray-400">Secured by <span class="font-semibold text-gray-500">QPay</span></p>
            </div>
        </div>
    </div>
</body>
</html>
