(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initPaymentButtons();
        initPaymentForms();
        initDonateForms();
    });

    function initPaymentButtons() {
        document.querySelectorAll('.qpay-btn-pay').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var data = {
                    amount: btn.dataset.amount,
                    currency: btn.dataset.currency || 'BDT',
                    description: btn.dataset.description || '',
                    success_url: btn.dataset.successUrl || '',
                    cancel_url: btn.dataset.cancelUrl || '',
                    method: btn.dataset.method || '',
                    source: 'button'
                };

                btn.disabled = true;
                var origHTML = btn.innerHTML;
                btn.innerHTML = '<span class="qpay-spinner"></span> ' + qpay_vars.i18n.processing;

                createPayment(data, function(result) {
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        btn.disabled = false;
                        btn.innerHTML = origHTML;
                    }
                }, function(error) {
                    btn.disabled = false;
                    btn.innerHTML = origHTML;
                    alert(error || qpay_vars.i18n.error);
                });
            });
        });
    }

    function initPaymentForms() {
        document.querySelectorAll('.qpay-payment-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                var msgEl = form.querySelector('.qpay-form-message');
                var submitBtn = form.querySelector('.qpay-btn-submit');
                var formData = new FormData(form);

                var amount = parseFloat(formData.get('qpay_amount'));
                if (!amount || amount <= 0) {
                    showMessage(msgEl, qpay_vars.i18n.invalid_amount, 'error');
                    return;
                }

                submitBtn.disabled = true;
                var origText = submitBtn.textContent;
                submitBtn.innerHTML = '<span class="qpay-spinner"></span> ' + qpay_vars.i18n.processing;
                showMessage(msgEl, qpay_vars.i18n.processing, 'loading');

                var data = {
                    amount: amount,
                    currency: formData.get('qpay_currency') || 'BDT',
                    name: formData.get('qpay_name') || '',
                    email: formData.get('qpay_email') || '',
                    phone: formData.get('qpay_phone') || '',
                    description: formData.get('qpay_description') || '',
                    success_url: form.dataset.successUrl || '',
                    cancel_url: form.dataset.cancelUrl || '',
                    source: 'form'
                };

                createPayment(data, function(result) {
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        showMessage(msgEl, qpay_vars.i18n.success, 'success');
                        submitBtn.disabled = false;
                        submitBtn.textContent = origText;
                    }
                }, function(error) {
                    showMessage(msgEl, error || qpay_vars.i18n.error, 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = origText;
                });
            });
        });
    }

    function initDonateForms() {
        document.querySelectorAll('.qpay-donate-form').forEach(function(form) {
            var presetBtns = form.querySelectorAll('.qpay-preset-btn');
            var amountInput = form.querySelector('.qpay-donate-amount');

            presetBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    presetBtns.forEach(function(b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    if (amountInput) amountInput.value = btn.dataset.amount;
                });
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                var msgEl = form.querySelector('.qpay-form-message');
                var submitBtn = form.querySelector('.qpay-btn-donate');
                var formData = new FormData(form);

                var amount = parseFloat(formData.get('qpay_amount'));
                if (!amount || amount <= 0) {
                    showMessage(msgEl, qpay_vars.i18n.invalid_amount, 'error');
                    return;
                }

                submitBtn.disabled = true;
                var origText = submitBtn.textContent;
                submitBtn.innerHTML = '<span class="qpay-spinner"></span> ' + qpay_vars.i18n.processing;
                showMessage(msgEl, qpay_vars.i18n.processing, 'loading');

                var data = {
                    amount: amount,
                    currency: formData.get('qpay_currency') || 'BDT',
                    name: formData.get('qpay_name') || '',
                    email: formData.get('qpay_email') || '',
                    description: formData.get('qpay_description') || 'Donation',
                    success_url: form.dataset.successUrl || '',
                    cancel_url: form.dataset.cancelUrl || '',
                    source: 'donation'
                };

                createPayment(data, function(result) {
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        showMessage(msgEl, qpay_vars.i18n.success, 'success');
                        submitBtn.disabled = false;
                        submitBtn.textContent = origText;
                    }
                }, function(error) {
                    showMessage(msgEl, error || qpay_vars.i18n.error, 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = origText;
                });
            });
        });
    }

    function createPayment(data, onSuccess, onError) {
        var formData = new FormData();
        formData.append('action', 'qpay_create_payment');
        formData.append('nonce', qpay_vars.nonce);

        Object.keys(data).forEach(function(key) {
            formData.append(key, data[key]);
        });

        fetch(qpay_vars.ajax_url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(function(response) { return response.json(); })
        .then(function(result) {
            if (result.success) {
                onSuccess(result.data);
            } else {
                onError(result.data ? result.data.message : qpay_vars.i18n.error);
            }
        })
        .catch(function() {
            onError(qpay_vars.i18n.error);
        });
    }

    function showMessage(el, message, type) {
        if (!el) return;
        el.style.display = 'block';
        el.className = 'qpay-form-message qpay-msg-' + type;
        el.textContent = message;
    }
})();
