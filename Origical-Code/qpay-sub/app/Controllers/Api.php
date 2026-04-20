<?php

namespace App\Controllers;

use App\Libraries\Curl;
use App\Models\Api as ModelsApi;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class Api extends BaseController
{
    use ResponseTrait;
    public $main_model, $db;
    public function __construct()
    {
        $this->db = db_connect();
        $this->main_model = new ModelsApi();
    }


    public function show404()
    {
        load_404();
    }
    public function payment($type = '')
    {
        $get_api = $_REQUEST['api_key'] ?? $this->request->getHeaderLine('API-KEY');

        if (!in_array($type, ['create', 'verify'])) {
            ms(["status" => 0, "message" => 'Invalid API request'], 400);
        }

        if (empty($get_api) || !brandValidation($get_api)) {
            ms(['status' => 0, 'message' => 'Invalid API Request.'], 404);
        }
        $user_brand = brandValidation($get_api);
        $params = (array)$this->request->getVar();

        if ($type == 'verify') {
            if (!empty($params['transaction_id'])) {
                $trx = $this->main_model->get('ids,params,meta,amount,transaction_id,status', 'temp_transactions', ['transaction_id' => $params['transaction_id'], 'uid' => $user_brand['uid']]);
                if (!empty($trx)) {
                    $status = $trx->status == 1 ? 'PENDING' : ($trx->status == 2 ? 'COMPLETED' : 'ERROR');

                    $tr = $this->main_model->get('type', 'transactions', ['ids' => $trx->ids, 'uid' => $user_brand['uid']]);
                    ms(['cus_name' => get_value($trx->params, 'cus_name'), 'cus_email' => get_value($trx->params, 'cus_email'), 'amount' => $trx->amount, 'transaction_id' => $trx->transaction_id, 'metadata' => $trx->meta, 'payment_method' => $tr->type, 'status' => $status]);
                }
                ms(['status' => 0, 'message' => 'failed']);
            }
            ms(['status' => 0, 'message' => 'Required field missing']);
        } elseif ($type == 'create') {
            if (!empty($params['amount']) && is_numeric($params['amount']) && $params['amount'] <= 1000000 && !empty($params['success_url']) && !empty($params['cancel_url'])) {
                $meta = [];
                if (!empty($params['metadata'])) {
                    if (!is_object($params['metadata'])) {
                        ms(["status"  => "error", "message" => 'Metadata must be in JSON format.']);
                    }
                    $meta = $params['metadata'];
                }
                $param = [
                    "cus_name"          => $params['cus_name'] ?? 'Default Name',
                    "cus_email"         => $params['cus_email'] ?? 'default@gmail.com',
                    "success_url"       => $params['success_url'],
                    "cancel_url"        => $params['cancel_url'],
                    "webhook_url"      => $params['webhook_url'] ?? '',
                ];

                $ids = ids();
                $data   = array(
                    "ids"               => $ids,
                    "uid"               => $user_brand['uid'],
                    "brand_id"          => $user_brand['brand_id'],
                    "params"            => json_encode($param),
                    "meta"              => json_encode($meta),
                    "request"           => $params['return_type'] ?? 'GET',
                    "amount"            => $params['amount'],
                    "transaction_id"    => trxId(),
                    "created_at"        => now()
                );
                $this->db->table('temp_transactions')->insert($data);

                if ($this->db->affectedRows() > 0) {
                    ms(['status' => 1, 'message' => 'Payment Link', 'payment_url' => base_url("api/execute/" . $ids)]);
                }
            }
            ms(["status"  => 0, "message" => 'Your request with Invalid Parameters.'], 400);
        }


        ms(['status' => 0, 'message' => 'Invalid API Request'], 400);
    }

    public function execute($ids = '')
    {
        if (!empty($data = $this->main_model->get_info_by_temp_ids($ids))) {
            set_session('tmp_ids', $ids);
            set_session('uid', $data['all_info']['uid']);
            $data = $this->main_model->get_info_by_temp_ids($ids);

            return view('execute', $data);
        } else {
            ms(["status"  => "error", "message" => 'Invalid API Response'], 404);
        }
    }


    public function execute_payment($method = '', $ids = '')
    {
        $data = $this->main_model->get_info_by_temp_ids($ids);

        if (!empty(session('tmp_ids')) && !empty($data)) {

            $setting = json_decode(json_encode($this->main_model->get('*', 'user_payment_settings', ['brand_id' => $data['all_info']['brand_id'], 'uid' => $data['all_info']['uid'], 'g_type' => $method])), true);
            if (!empty($setting)) {
                return view('execute_payment', array_merge($data, ['setting' => $setting]));
            } else {
                ms(["status"  => "error", "message" => 'Invalid API Response']);
            }
        } else {
            ms(["status"  => "error", "message" => 'Invalid API Response']);
        }
    }

    public function save_payment($method)
    {
        _is_ajax();
        $rules = [
            'transaction_id' => [
                'label' => 'Transaction ID',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Transaction ID is required.',
                    'min_length' => 'Transaction ID 8 অক্ষর দীর্ঘ হওয়া উচিত।',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->listErrors();
            ms(["status"  => "error", "message" => $errors]);
        }

        $tmp = $this->main_model->get_info_by_temp_ids(post('tmp_id'));

        if (empty($tmp)) {
            ms(["status"  => "error", "message" => 'Invalid Request']);
        }

        if (post('t_type') == 'mobile') {
            $ac = decrypt(post('acc_tp'));
            $result = $this->main_model->module_task($method, $ac);
        } elseif (post('t_type') == 'bank') {

            $data = array(
                'ids'               => post('tmp_id'),
                'uid'               => $tmp['all_info']['uid'],
                'brand_id'          => $tmp['all_info']['brand_id'],
                'files'             => post('transaction_id'),
                'status'            => '1',
                'type'              => $method,
                'created_at'        => now()
            );
            $this->db->table('bank_transaction_logs')->insert($data);

            ms(["status"  => "warning", "message" => 'Your Request is sent for review!', 'redirect' => base_url('api/checkout/' . $method . '/' . encrypt(post('tmp_id')) . '/' . encodeParams('1'))]);
        }

        ms($result);
    }
    public function checkout($method = '', $ids = '', $type = '')
    {
        if ($method == 'undetected') {
            $ids = encrypt($ids);
        }
        if (!empty(session('tmp_ids')) && !empty($ids) && !empty($method) && !empty($type)) {
            $ids = decrypt($ids);
            $type = decodeParams($type);
            $tmp = $this->main_model->get_info_by_temp_ids($ids);
            if ($method=='binance') {
				$query2 = $this->main_model->get('ids,transaction_id','temp_transactions',['ids'=>$ids,'status'=>9]);
				if (empty($query2)) {
					ms(["status"  => "error", "message" => 'Something went wrong with binance connection.']);
				}					
			}
            if (!empty($tmp)) {
                $bg = '#ff5353';
                $url = ($type == '1' || $type == '2') ? $tmp['all_info']['success_url'] : $tmp['all_info']['cancel_url'];
                $st = 'failed';

                if ($type == '1') {
                    $st = "pending";
                    $bg = '#FF7C00';
                } elseif ($type == '2') {
                    $st = "completed";
                    $bg = '#008000';
                }
                $redirect = [
                    'business_name'      => $tmp['all_info']['brand_name'],
                    'business_logo'      => $tmp['all_info']['brand_logo'],
                    'temp_method'        => $method,
                    'redirect_url'       => url_modifier($url, [
                        'paymentMethod'  => $method,
                        'transactionId'  => $tmp['all_info']['transaction_id'],
                        'paymentAmount'  => $tmp['all_info']['amount'],
                        'paymentFee'     => $tmp['all_info']['fees_amount'],
                        'status'         => $st
                    ]),
                    'temp_transaction_id' => $tmp['all_info']['transaction_id'],
                    'temp_amount'         => $tmp['all_info']['amount'],
                    'fees_amount'         => $tmp['all_info']['fees_amount'],
                    'type'                => $type,
                    'bg'                  => $bg
                ];

                $redirect2 = [];

                if (in_array($type, ['1', '2'])) {
                    $query = $this->main_model->get('*', 'module_data', ['tmp_id' => $ids]);
                    //if it is binance then execute following code
                    if ($method == 'binance') {
                        $query2 = $this->main_model->get('ids,transaction_id', 'temp_transactions', ['ids' => $ids, 'status' => 9]);
                        if (empty($query2)) {
                            ms(["status"  => "error", "message" => 'Something went wrong with binance connection.']);
                        }
                    }

                    if (!empty($query) && !empty($query->message)) {
                        $message = $query->message;
                    } else {
                        $message = 'Request of Taka ' . $tmp['all_info']['total_amount'] . ' has been processed by ' . $method . '. TrxID ' . $tmp['all_info']['transaction_id'];
                    }


                    $data = [
                        'ids'            => $tmp['all_info']['tmp_ids'],
                        'uid'            => $tmp['all_info']['uid'],
                        'brand_id'       => $tmp['all_info']['brand_id'],
                        'type'           => $method,
                        'status'         => (int)$type,
                        'transaction_id' => $tmp['all_info']['transaction_id'],
                        'message'        => $message,
                        'amount'         => $tmp['all_info']['total_amount'],
                        'currency'       => $tmp['all_info']['currency'],
                        'created_at'     => date('Y-m-d H:i:s')
                    ];

                    try {
                        $this->db->transException(true)->transStart();
                        $this->db->table('module_data')->delete(['tmp_id' => $ids]);
                        $this->db->table('transactions')->insert($data);
                        $this->db->table('temp_transactions')->update(['status' => (int)$type], ['ids' => $ids]);
                        $this->db->transComplete();

                        $redirect2 = [
                            'status'  => 'success',
                            'message' => 'Your Payment Request is Processed. Please Stay On this Page',
                        ];
                        if (!empty($tmp['all_info']['webhook_url'])) {

                            $post_data = [
                                'paymentMethod'  => $method,
                                'transactionId'  => $tmp['all_info']['transaction_id'],
                                'paymentAmount'  => $tmp['all_info']['amount'],
                                'paymentFee'     => $tmp['all_info']['fees_amount'],
                                'status'         => $st
                            ];
                            simple_post($tmp['all_info']['webhook_url'], $post_data);
                        }

                        unset_session('tmp_ids');
                    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                        // Log the error message
                        log_message('alert', 'Transaction failed: ' . $e->getMessage());

                        $redirect2 = [
                            'status'  => 'error',
                            'message' => 'Your Payment Request is Failed.',
                        ];
                    }
                } else {

                    $redirect2 = [
                        'status'       => 'error',
                        'message'      => 'Your Payment Request is Canceled.',
                    ];
                }
                return view('report', array_merge($redirect, $redirect2));
            }
        }
        load_404();
    }
}
