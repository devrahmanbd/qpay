<?php
namespace App\Controllers;

use Blocks\Models\QueueModel;

class ApiController extends BaseController
{
    protected $tb_file_manage;
    protected $controller_name;
    protected $image;
    protected $helpers = ['user'];
    public $model, $db;

    public function __construct()
    {
        $this->model = new QueueModel;
    }

    public function deviceConnect()
    {
        $this->db = db_connect();
        $request = service('request');

        $user_email = $request->getVar('user_email');
        $device_key = $request->getVar('device_key');
        $device_ip = $request->getVar('device_ip');

        try {
            if ($user_email && $device_key && $device_ip) {
                $device = $this->db->table('devices')
                    ->select('id, uid, device_ip')
                    ->where('user_email', $user_email)
                    ->where('device_key', $device_key)
                    ->get()
                    ->getRow();

                if ($device) {
                    if (deviceValidation($device_key, $device->uid)) {
                        $updateData = [
                            'device_ip' => $device_ip,
                            'last_sync_at' => date('Y-m-d H:i:s'),
                            'battery_level' => $request->getVar('battery_level') ?? null
                        ];
                        
                        $this->db->table('devices')->where('id', $device->id)->update($updateData);
                        return json_encode(["status" => "1", "message" => $device->uid]);
                    } else {
                        return json_encode(["status" => "2", "message" => 'Your key is expired']);
                    }
                } else {
                    return json_encode(['status' => '0', 'message' => 'Device not found with the provided user_email and device_key']);
                }
            }

            $missing = [];
            if (!$user_email) $missing[] = 'user_email';
            if (!$device_key) $missing[] = 'device_key';
            if (!$device_ip) $missing[] = 'device_ip';
            
            $msg = count($missing) > 0 
                ? 'Missing required parameters: ' . implode(', ', $missing) 
                : 'Failed to connect with the server';

            return json_encode(['status' => '0', 'message' => $msg]);

        } catch (\Throwable $e) {
            return json_encode([
                'status' => '0', 
                'message' => 'System error: ' . $e->getMessage(),
                'debug_info' => 'Production fix applied'
            ]);
        }
    }
    
    public function addMessage()
    {
        $request = service('request');
        $deviceResponse = $this->deviceConnect();
        $device = json_decode($deviceResponse);

        // Handle JSON parsing errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            ms([
                'status' => 0,
                'message' => 'JSON Parsing Error: ' . json_last_error_msg(),
                'response' => $deviceResponse
            ]);
            return;
        }

        $address = $request->getVar('address');
        $message = $request->getVar('message');

        // Validate input
      //  if (empty($message) || !in_array($address, ['bkash', 'nagad', 'rocket'//, 'upay', 'surecash', 'Ipay', 'okwallet', 'tap', 'cellfin'])) {
          //  ms(["status" => "0", "message" => 'Invalid message or address']);
     //       return;
    //    }

        // Check device status and insert message
        if (!empty($device->status) && $device->status == 1 && !empty($message)) {
            $data = [
                'uid'        => $device->message,
                'message'    => preg_replace("/\r?\n/", " ", $message),
                'address'    => $address,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('module_data')->insert($data);

            if ($this->db->affectedRows() > 0) {
                ms(['status' => 1, 'message' => 'Data inserted successfully']);
            } else {
                ms(["status" => "0", "message" => 'Failed to insert data']);
            }
        } else {
            ms(['status' => "0", 'message' => 'Failed to connect or invalid device']);
        }
    }

    public function cron()
    {
        $this->model->processPendingTasks();

        $webhookService = new \App\Libraries\WebhookService();
        $webhookService->retryFailed();
    }
}

?>
