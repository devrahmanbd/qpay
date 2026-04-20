## Qpay

### High Priority

- [x]  sk_key, pk_key doesn't work cause in user dashboard I can't generate a new key, there’s no backend logic. Create button and backend seems to be the issue. sk_key renamed to qp_key. 
	    Step 1. Create backend logic for generating qp_key and pk_key, also sandbox key pair.
		Step 2. Then update the API and security headers
		Step 3. Update user dashboard to generate qp_key and pk_key, also sandbox key pair.
		Step 4. Update documentation about key pair.
        Step 5. Currently our SDK or integration with other platform doesn't match because of keys, api call and response and also requirements. 
		
		Goal: Stripe key like feature

The details of our payment gateways workflow and system architecture is described in https://localhost:8443/developers/docs 

## Low priority

- [ ]  Webhook details are missing in the docs and couldn't be tested cause webhook add endpoint button doesn't do anything, backend logic maybe missing.
	    Step 1. Create backend webhook logic
	    Step 2. Enhance webhook security
	    Step 3. Update dashboard with updated webhook feature
	    Step 4. Update documentation about webhook.

		Goal: Stripe like webhook feature
- [ ]  Brands key is nowhere to be used. any suggestion? And what’s the use of device key? I want to remove device key and want to use brand key for like uh custom brand design or something like that give any idea.


- [ ]  [https://qpay.cloudman.one/user/user-settings/bkash](https://qpay.cloudman.one/user/user-settings/bkash) which is Setting => Wallets => Bkash or other wallet I can't see or edit existing wallet.
      Step 1. I don’t see existing wallet setting, i guess it can’t retrieve from database to show current value.
      Step 2. Update the whole wallet interface with modern UI 
- [ ] Global Debug is needed on admin dashboard to check logs. Like in wordpress we have wp_debug=enable;
