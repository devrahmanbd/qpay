<?php

namespace App\Models;

use CodeIgniter\Model;

class Api extends Model
{
    protected $table = 'temp_transactions';
    protected $primaryKey = 'id';

    public function get_info_by_temp_ids($ids = '')
    {

        $result = '';

        $tmp = $this->get('*', 'temp_transactions', ['ids' => $ids]);

        if ($tmp && ($tmp->status == 0 || $tmp->status == 9)) {
            $b_info = $this->get('*', 'brands', ['id' => $tmp->brand_id, 'uid' => $tmp->uid]);
            $fees = 0;
            if (!empty($b_info->fees_amount)) {
                if ($b_info->fees_type == 0) {
                    $fees = $b_info->fees_amount;
                } else {
                    $fees = $b_info->fees_amount * $tmp->amount / 100;
                }
            }
            $rate = 1;

            $all_info = [
                'brand_id' => $b_info->id,
                'brand_logo' => $b_info->brand_logo,
                'brand_name' => $b_info->brand_name,
                'support_mail' => get_value($b_info->meta, 'support_mail'),
                'mobile_number' => get_value($b_info->meta, 'mobile_number'),
                'whatsapp_number' => get_value($b_info->meta, 'whatsapp_number'),
                'fees_type' => $b_info->fees_type,
                'fees_amount' => $rate * $fees,
                'b_fees_amount' => $fees,
                'amount' => $rate * $tmp->amount,
                'b_amount' => $tmp->amount,
                'total_amount' => ceil($rate * ($tmp->amount + $fees)),
                'b_total_amount' => ceil($tmp->amount + $fees),
                'cus_name' => get_value($tmp->params, 'cus_name'),
                'cus_email' => get_value($tmp->params, 'cus_email'),
                'cus_phone' => get_value($tmp->params, 'cus_phone'),
                'success_url' => get_value($tmp->params, 'success_url'),
                'cancel_url' => get_value($tmp->params, 'cancel_url'),
                'webhook_url' => get_value($tmp->params, 'webhook_url'),
                'transaction_id' => $tmp->transaction_id,
                'tmp_ids' => $tmp->ids,
                'uid' => $tmp->uid,
                'currency' => get_option('currency_code'),
            ];

            $mobile_s = $this->fetch('*', 'user_payment_settings', ['uid' => $tmp->uid, 'brand_id' => $tmp->brand_id, 'status' => 1, 't_type' => 'mobile']);
            $bank_s = $this->fetch('*', 'user_payment_settings', ['uid' => $tmp->uid, 'brand_id' => $tmp->brand_id, 'status' => 1, 't_type' => 'bank']);
            $int_b_s = $this->fetch('*', 'user_payment_settings', ['uid' => $tmp->uid, 'brand_id' => $tmp->brand_id, 'status' => 1, 't_type' => 'int_b']);

            $newArray_mobile = [];
            $newArray_int_bank = [];

            foreach ($mobile_s as $item) {
                $params = json_decode($item->params, true);
                $active_payments = isset($params['active_payments']) ? $params['active_payments'] : [];

                foreach ($active_payments as $payment_type => $value) {
                    if ($value == 1) {
                        $newItem = clone $item;
                        $newItem->active_payment = $payment_type;
                        $newArray_mobile[] = $newItem;
                    }
                }
            }
            foreach ($int_b_s as $item) {
                $params = json_decode($item->params, true);
                $active_payments = isset($params['active_payments']) ? $params['active_payments'] : [];

                foreach ($active_payments as $payment_type => $value) {
                    if ($value == 1) {
                        $newItem = clone $item;
                        $newItem->active_payment = $payment_type;
                        $newArray_int_bank[] = $newItem;
                    }
                }
            }

            $data = array(
                'all_info' => $all_info,
                'mobile_s' => $newArray_mobile,
                'bank_s'   => $bank_s,
                'int_b_s'  => $newArray_int_bank,
                'rate'     => $rate
            );
            $result = $data;
        }

        return $result;
    }

    public function module_task($method, $type)
    {
        $tmp = $this->get_info_by_temp_ids(post('tmp_id'));

        if (empty($tmp)) {
            return ["status"  => "error", "message" => 'Payment is not valid!'];
        }
        $temp_amount = amount_format($tmp['all_info']['total_amount']);
        $transaction_id = post('transaction_id');

        //it can verify two types of message
        $message1 = '';
        $message2 = '';
        $message3 = '';

        $address = '';
        switch ($method) {
            case 'bkash':
                $address = 'bkash';
                $transactionid = 'TrxID ' . $transaction_id;

                if ($type == 'personal') {
                    $message1 = "You have received Tk " . $temp_amount;
                } elseif ($type == 'agent') {
                    $message1 = "Cash Out Tk " . $temp_amount;
                } elseif ($type == 'payment_number') {
                    $message1 = "You have received payment Tk " . $temp_amount;
                }

                break;

            case 'nagad':
                $address = 'nagad';
                $transactionid = 'TxnID: ' . $transaction_id;
                $temp_amount = str_replace(",", "", $temp_amount);
                if ($type == 'personal') {
                $message1 = "Money Received. Amount: Tk ".$temp_amount;
                 
                } elseif ($type == 'agent') {
                    $message1 = "Cash Out Received. Amount: Tk " . $temp_amount;     }
                break;
            case 'surecash':
		    	$address ='16495';
		        $transactionid = 'TxnID: ' . $transaction_id;
		        $temp_amount = str_replace(",","",$temp_amount);

		        if ($type=='personal') {
		        	$message1 = "Amount: Tk ". $temp_amount;
		        }elseif ($type=='agent') {
		        	$message1 = "Amount: Tk ". $temp_amount;
		        }
		        break;

            case 'rocket':
                $address = '16216';
                $transactionid = 'TxnID:' . $transaction_id;
                if ($type == 'personal') {
                    $message1 = "Your account has been successfully credited by Tk. " . $temp_amount;
                    $message2 = "Tk" . $temp_amount . " received";
                } elseif ($type == 'agent') {
                    $message1 = "Amount: Tk " . $temp_amount;
                }
                break;
            case 'upay':
                $address = 'upay';
                $transactionid = 'TrxID ' . $transaction_id;
                if ($type == 'personal') {
                    $message1 = "Your account has been successfully credited by Tk. " . $temp_amount;
                    $message2 = "Tk. " . $temp_amount . " has been received";
                } elseif ($type == 'agent') {
                    $message1 = "Amount: Tk " . $temp_amount;
                }
                break;
            case 'cellfin':
		    	$address ='Islami.Bank';
		        $transactionid = 'TrxId: ' . $transaction_id;
		        $temp_amount = str_replace(",","",$temp_amount);
		        if ($type=='personal') {
		        	$message1 = 'Received ' . $temp_amount;
		        }elseif ($type=='agent') {
		        	$message1 = "Received ". $temp_amount;
		        }
		        break;
                
                case 'tap':
        $address = 'tap';
        $transactionid = 'TrxID ' . $transaction_id;
        if ($type == 'personal') {
            $message1 = "You have received Tk " . $temp_amount . " via Tap.";
        } elseif ($type == 'agent') {
            $message1 = "Cash out of Tk " . $temp_amount . " via Tap.";
        }
        break;

    case 'ipay':
        $address = '09638900800';
        $transactionid = 'TrxID ' . $transaction_id;
        if ($type == 'personal') {
            $message1 = "You have received Tk " . $temp_amount . " via Ipay.";
        } elseif ($type == 'agent') {
            $message1 = "Cash out of Tk " . $temp_amount . " via Ipay.";
        }
        break;

    case 'ok_wallet':
        $address = '01401195496';
        $transactionid = 'TrxID ' . $transaction_id;
        if ($type == 'personal') {
            $message1 = "You have received Tk " . $temp_amount . " via OK Wallet.";
        } elseif ($type == 'agent') {
            $message1 = "Cash out of Tk " . $temp_amount . " via OK Wallet.";
        }
        break;

    case 'mcash':
        $address = 'mCash';
        $transactionid = 'TrxID ' . $transaction_id;
        if ($type == 'personal') {
            $message1 = "You have received Tk " . $temp_amount . " via mCash.";
        } elseif ($type == 'agent') {
            $message1 = "Cash out of Tk " . $temp_amount . " via mCash.";
        }
        break;

    case 'Easypaisa':
                $address = '3737';
                $transactionid = 'TrxID ' . $transaction_id;

                if ($type == 'personal') {
                    $message1 = "You have received Rs " . $temp_amount;
                } elseif ($type == 'agent') {
                    $message1 = "Cash Out Tk " . $temp_amount;
                }
                break;

                        default:
                return ["status"  => "error", "title" => "Payment Failed", "message" => 'Illegal Operation!'];
                break;
        }
        

        $builder = $this->db->table('module_data');
        $builder->select('*');

        if (!empty($message2)) {
            $builder->groupStart();
            $builder->like('message', $message1);
            $builder->orLike('message', $message2);
            if (!empty($message3)) {
                $builder->orLike('message', $message3);
            }
            $builder->groupEnd();
        } else {
            $builder->like('message', $message1);
        }

        $builder->like('message', $transactionid);
        $builder->where('status', '0');
        $builder->where('address', $address);
        $builder->where('uid', session('uid'));

        $query = $builder->get();
        $result = $query->getRow();

        if (empty($result) || !empty($this->get('transaction_id', 'transactions', ['status' => '0', 'transaction_id' => $tmp['all_info']['transaction_id']]))) {
            return ["status"  => "error", "message" => 'দুঃখিত, আপনার Transaction ID খুঁজে পাওয়া যায়নি।'];
        }

        $pattern = '/\b(?:Tk|TK|tk)\s*([\d,.]+)/';
        if (preg_match($pattern, $result->message, $matches)) {
            if ((float)$matches[1] != (float)$temp_amount) {
                return ["status"  => "error",  "message" => 'Severe wrong!'];
            }
        } else {
            return ["status"  => "error", "message" => 'Malicious content found!'];
        }

        $object = array(
            'tmp_id' => post('tmp_id'),
            'status' => 1,
        );

        $this->db->table('module_data')->where('id', $result->id)->update($object);

        return ["status"  => "success", "title" => "Payment Successful", "message" => 'আপনার পেমেন্ট সঠিকভাবে সম্পন্ন হয়েছে।', 'redirect' => base_url('api/checkout/' . $method . '/' . encrypt(post('tmp_id')) . '/' . encodeParams('2'))];
    }
}
