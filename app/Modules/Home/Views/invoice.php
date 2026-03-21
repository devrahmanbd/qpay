<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice of <?= get_brand_data($items['brand_id'], $items['uid'])->brand_name; ?> to <?= @$items['customer_name'] ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(get_brand_data($items['brand_id'], $items['uid'])->brand_logo); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-container { box-shadow: none !important; margin: 0 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="print-container max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white text-center py-6">
            <h1 class="text-3xl font-bold">INVOICE</h1>
        </div>

        <div class="p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-8">
                <div class="flex items-center gap-3">
                    <img class="w-14 h-14 rounded-lg border border-gray-200 object-cover" src="<?= base_url(get_brand_data($items['brand_id'], $items['uid'])->brand_logo) ?>" alt="Brand Logo">
                    <h4 class="text-lg font-semibold text-gray-900"><?= get_option('business_name') ?></h4>
                </div>
                <div class="text-right">
                    <?php if (@$items['pay_status'] == 1) : ?>
                        <p class="text-lg font-semibold text-gray-900">Payment Status: <span class="text-blue-600">Pending</span></p>
                        <p class="text-sm text-gray-500 mt-1">TrxId: <?= @$items['transaction_id'] ?></p>
                    <?php elseif (@$items['pay_status'] == 2) : ?>
                        <p class="text-lg font-semibold text-gray-900">Payment Status: <span class="text-green-600">Paid</span></p>
                        <p class="text-sm text-gray-500 mt-1">TrxId: <?= @$items['transaction_id'] ?></p>
                    <?php else : ?>
                        <p class="text-lg font-semibold text-gray-900">Payment Status: <span class="text-red-600">Unpaid</span></p>
                        <button onclick="location.href='?start_payment=<?= @$items['ids'] ?>'" class="no-print mt-2 px-5 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">Pay Now</button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-5 mb-6">
                <h2 class="text-lg font-semibold text-green-700 mb-3">Invoice Details</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tr class="border-b border-gray-200"><th class="py-2.5 pr-4 text-left font-medium text-gray-700 whitespace-nowrap">INVOICE</th><td class="py-2.5 text-gray-600">#<?= @$items['invoice_ids'] ?></td></tr>
                        <tr class="border-b border-gray-200"><th class="py-2.5 pr-4 text-left font-medium text-gray-700 whitespace-nowrap">Creation Date</th><td class="py-2.5 text-gray-600"><?= @time_format($items['created_at']) ?></td></tr>
                        <tr><th class="py-2.5 pr-4 text-left font-medium text-gray-700 whitespace-nowrap">Pay to</th><td class="py-2.5 text-gray-600"><?= get_brand_data($items['brand_id'], $items['uid'])->brand_name; ?></td></tr>
                    </table>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-5 mb-6">
                <h2 class="text-lg font-semibold text-green-700 mb-3">Customer Information</h2>
                <div class="space-y-1.5 text-sm">
                    <p><span class="font-medium text-gray-700">Name: </span><span class="text-gray-600"><?= @$items['customer_name'] ?></span></p>
                    <p><span class="font-medium text-gray-700">Number: </span><span class="text-gray-600"><?= @$items['customer_number'] ?></span></p>
                    <p><span class="font-medium text-gray-700">Email: </span><span class="text-gray-600"><?= @$items['customer_email'] ?></span></p>
                    <?php if (!empty(get_value(@$items['extras'], 'reference'))) : ?>
                        <p><span class="font-medium text-gray-700">Reference: </span><span class="text-gray-600"><?= get_value(@$items['extras'], 'reference') ?></span></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-5 mb-6">
                <h2 class="text-lg font-semibold text-green-700 mb-3">Invoice Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-green-600 text-white">
                                <th class="py-2.5 px-3 text-left font-medium rounded-tl-lg">Description</th>
                                <th class="py-2.5 px-3 text-left font-medium">Qty</th>
                                <th class="py-2.5 px-3 text-left font-medium">Price</th>
                                <th class="py-2.5 px-3 text-left font-medium rounded-tr-lg">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="py-2.5 px-3 text-gray-600"><?= @$items['customer_description'] ?></td>
                                <td class="py-2.5 px-3 text-gray-600">1</td>
                                <td class="py-2.5 px-3 text-gray-600"><?= @$items['customer_amount'] . get_option('currency_symbol') ?></td>
                                <td class="py-2.5 px-3 text-gray-600"><?= @$items['customer_amount'] . get_option('currency_symbol') ?></td>
                            </tr>
                            <tr class="bg-green-600 text-white font-semibold">
                                <td class="py-2.5 px-3 rounded-bl-lg" colspan="3">Total Price</td>
                                <td class="py-2.5 px-3 rounded-br-lg"><?= @$items['customer_amount'] . get_option('currency_symbol') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center no-print">
                <button onclick="window.print()" class="px-6 py-2.5 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors">
                    Print Invoice
                </button>
            </div>
        </div>
    </div>
</body>
</html>
