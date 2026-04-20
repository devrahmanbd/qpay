<?php defined('BASEPATH') OR exit('No direct script access allowed');


use Xenon\NagadApi\Helper;
use Xenon\NagadApi\Base;
require 'Nagad/vendor/autoload.php';

class Nagad_lib{
	public function __construct($config='')
	{
		$config = [
		    'NAGAD_APP_ENV' => 'development', // development|production
		    'NAGAD_APP_LOG' => '1',
		    'NAGAD_APP_ACCOUNT' => '016XXXXXXXX', //demo
		    'NAGAD_APP_MERCHANTID' => '6800000025', //demo
		    'NAGAD_APP_MERCHANT_PRIVATE_KEY' => 'MIIEvFAAxN1qfKiRiCL720FtQfIwPDp9ZqbG2OQbdyZUB8I08irKJ0x/psM4SjXasglHBK5G1DX7BmwcB/PRbC0cHYy3pXDmLI8pZl1NehLzbav0Y4fP4MdnpQnfzZJdpaGVE0oI15l',
		    'NAGAD_APP_MERCHANT_PG_PUBLIC_KEY' => 'MIIBIjANBc54jjMJoP2toR9fGmQV7y9fzj',
		    'NAGAD_APP_TIMEZONE' => 'Asia/Dhaka',
		];

		$nagad = new Base($config, [
		    'amount' => 10,
		    'invoice' => Helper::generateFakeInvoice(15, true),
		    'merchantCallback' => 'https://example.com/payment/success/id=4',
		]);
		$status = $nagad->payNow($nagad); //will redirect to payment page

	}
		

}