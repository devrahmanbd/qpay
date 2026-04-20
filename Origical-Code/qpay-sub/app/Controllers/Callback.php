<?php

namespace App\Controllers;

use App\Libraries\Bkashapi;
use App\Models\Api as ModelsApi;
use CodeIgniter\API\ResponseTrait;
use Exception;

class Callback extends BaseController
{
    use ResponseTrait;
    public $main_model, $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->main_model = new ModelsApi();
    }

    public function bkash($ids = '')
    {
        $ids = decrypt($ids);

        $data = $this->main_model->get_info_by_temp_ids($ids);

        if (!empty($data)) {
            $setting = json_decode(json_encode($this->main_model->get('*', 'user_payment_settings', ['brand_id' => $data['all_info']['brand_id'], 'uid' => $data['all_info']['uid'], 'g_type' => 'bkash'])), true);
            $config = array(
                'username' => get_value($setting['params'], 'username'),
                'password' => get_value($setting['params'], 'password'),
                'app_key' => get_value($setting['params'], 'app_key'),
                'app_secret' => get_value($setting['params'], 'app_secret'),
            );

            $sandbox = (bool) get_value($setting['params'], 'sandbox');
            $logs = (bool) get_value($setting['params'], 'logs');
            $url = (!$sandbox) ? 'https://tokenized.pay.bka.sh' : 'https://tokenized.sandbox.bka.sh';

            try {
                $bkash = new Bkashapi($config['username'], $config['password'], $config['app_key'], $config['app_secret'], $url);

                $request = $bkash->execute_payment();
                $json_data = json_decode($request['message']);

                if ($logs) {
                    set_session('logs_data', $json_data);
                    return redirect()->to(base_url('api/execute_payment/bkash/' . $ids . '?acc_tp=wobmrkxd&logs=success&status=' . $json_data->statusMessage));
                }

                if ($json_data->statusCode == "0000" && $json_data->transactionStatus == 'Completed') {
                    unset_session("token");
                    $enc_ids = encrypt($data['all_info']['tmp_ids']);
                    return redirect()->to(base_url('api/checkout/bkash/' . $enc_ids . '/' . encodeParams('2')));
                }

                return redirect()->to(base_url('api/execute_payment/bkash/' . $ids . '?acc_tp=wobmrkxd&status=' . $json_data->statusMessage));
            } catch (Exception $e) {
                return redirect()->to(base_url('api/execute_payment/bkash/' . $ids . '?acc_tp=wobmrkxd&status=' . $e->getMessage()));
            }
        }
    }
    public function nagad()
	{
		if (!empty($url = session('complete_url'))) {
			unset_session('complete_url');
			echo '<script>window.location=" '.$url.'"</script>';
		}	
	}

	public function paypal($method='',$ids='')
	{

		$data = $this->main_model->get_info_by_temp_ids($ids);

		if (!empty(session('tmp_ids')) && !empty($tmp = $this->main_model->get_info_by_temp_ids($ids)) ) {
			$setting = json_decode(json_encode($this->main_model->get('*','user_payment_settings',['uid'=>$data['all_info']['uid'],'g_type'=>$method ])),true );

			$this->load->library("paypal");
			
			$client_id = get_value($setting['params'],'client_id');
			$secret_key = get_value($setting['params'],'secret_key');
			$mode = get_value($setting['params'],'mode');
			
			$newPaypal = new paypal($client_id,$secret_key,$mode);

			try {  
		        $order = $newPaypal->validate($_REQUEST['order_id']); 
				ms(["status"  => 1, "message" => 'success']);

		    } catch(Exception $e) {  
		        $api_error = $e->getMessage();  
				ms(["status"  => "error", "message" => $api_error]);
		    }


		}else{
			ms(["status"  => "error", "message" => 'Invalid API Response']);
		}
		

	}

	public function mastercard()
	{
		if (!empty($url = session('complete_url'))) {
			unset_session('complete_url');
			echo '<script>window.location=" '.$url.'"</script>';
		}
	}
    public function binance($ids = '')
    {
        $ids = decrypt($ids);

        $data = $this->main_model->get_info_by_temp_ids($ids);

        if (!empty($data)) {
            $tran = $this->main_model->get('transaction_id,status', 'transactions', ['transaction_id' => $data['all_info']['transaction_id'], 'status' => 1]);

            if (empty($tran)) {
                $this->db->table('temp_transactions')->where('ids', $ids)->update(['status' => 9]);
            }
        }
    }
}
