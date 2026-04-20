<style>
    :root {
        --bg1: #ED2730;
        --bg2: #F7962A;
    }
    .bg1 {
        background-color: var(--bg1);
    }
    .bg2 {
        background-color: var(--bg2);
        color: var(--bg1);
    }
    .bg2-t {
        letter-spacing: -1px;
        color: var(--bg1);
    }
    input::placeholder {
        color: var(--bg1);
    }
</style>

<?php
$acc_tp = $this->custom_encryption->decrypt($_GET['acc_tp']);

if ($acc_tp == 'business') {
    $rate = 1;
    if (get_option('currency_code') != 'USD') {
        $new_currency_rate = get_option('new_currecry_rate');
        if ($new_currency_rate !== null && $new_currency_rate != 0) {
            $rate = 1 / $new_currency_rate;
        }
        if (get_option('is_auto_currency_convert') == '1') {
            $rate = 1 / currency_converter(get_option('currency_code'));
        }
        if (!empty(get_value($setting['params'], 'dollar_rate'))) {
            $rate = 1 / get_value($setting['params'], 'dollar_rate');
        }
    }
    $amount = ceil($tmp['all_info']['total_amount'] * $rate);

    $clientId = get_value($setting['params'], 'client_id');
    $clientSecret = get_value($setting['params'], 'client_secret');
?>
    <style type="text/css">#transaction_id {
            display: none;
        }</style>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= $clientId; ?>&currency=USD"></script>
    <div class="panel">
        <div class="overlay hidden">
            <div class="overlay-content"></div>
        </div>
        <div class="panel-body">
            <div id="paymentResponse" class="hidden"></div>
            <div id="paypal-button-container"></div>
        </div>
    </div>

    <script>
        paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    "purchase_units": [{
                        "custom_id": "<?= $tmp['all_info']['tmp_ids'] ?>",
                        "description": "Uniquepay",
                        "amount": {
                            "currency_code": "USD",
                            "value": <?= $amount; ?>,
                            "breakdown": {
                                "item_total": {
                                    "currency_code": "USD",
                                    "value": <?= $amount; ?>
                                }
                            }
                        },
                        "items": [{
                            "name": "Uniquepay",
                            "description": "Uniquepay",
                            "unit_amount": {
                                "currency_code": "USD",
                                "value": <?= $amount; ?>
                            },
                            "quantity": "1",
                            "category": "DIGITAL_GOODS"
                        }]
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                return actions.order.capture().then(function (orderData) {
                    setProcessing(true);

                    var postData = {
                        paypal_order_check: 1,
                        order_id: orderData.id
                    };
                    fetch('<?= base_url("callback/paypal/paypal/".$tmp["all_info"]["tmp_ids"]) ?>', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: encodeFormData(postData)
                        })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result.status == 1) {
                                $.ajax({
                                    type: "POST",
                                    url: "<?= base_url('request/auto_payment/paypal') ?>",
                                    data: {
                                        token: token,
                                        id: "<?= $tmp['all_info']['tmp_ids']; ?>"
                                    },
                                    success: function (a) {
                                        window.location.href = a
                                    }
                                });
                            } else {
                                const messageContainer = document.querySelector("#paymentResponse");
                                messageContainer.classList.remove("hidden");
                                messageContainer.textContent = result.msg;

                                setTimeout(function () {
                                    messageContainer.classList.add("hidden");
                                    messageContainer.textContent = "";
                                }, 5000);
                            }
                            setProcessing(false);
                        })
                        .catch(error => console.log(error));
                });
            }
        }).render('#paypal-button-container');

        const encodeFormData = (data) => {
            var form_data = new FormData();

            for (var key in data) {
                form_data.append(key, data[key]);
            }
            return form_data;
        }

        // Show a loader on payment form processing
        const setProcessing = (isProcessing) => {
            if (isProcessing) {
                document.querySelector(".overlay").classList.remove("hidden");
            } else {
                document.querySelector(".overlay").classList.add("hidden");
            }
        }
    </script>

<?php } elseif ($acc_tp == 'personal') { ?>
    <div class="method-text">
        <p>
            Go to the PayPal website by typing WWW.PAYPAL.COM or go to PayPal Apps
            <br>
            "Pay & Send Money" তে ক্লিক করুন
        </p>
        <p>
            Enter this email as recipient email:
            <br />
            <br />
            <span class="d-flex-s">
                <span class="bg2-t"><?= get_value($setting['params'], 'personal_paypal') ?></span>
                <span class="copy-btn bg2 text-to-cliboard" data-value="<?= get_value($setting['params'], 'personal_paypal') ?>"> Copy !</span>
            </span>
        </p>
        <p class="d-flex-s">
            <span>মোট টাকার পরিমাণ </span>
            <span class="bg2-t"><?= currency_format($tmp['all_info']['total_amount']) ?></span>
        </p>
        Select the funding source and click on - <span class="marked_text">Send Money</span>

        <p>Now enter your <span class="marked_text">Transaction ID</span> in the above box and click on the <span class="marked_text">SUBMIT</span> button </p>
    </div>
<?php } ?>
