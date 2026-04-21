<?php
namespace App\Controllers;
// Cache buster: 2026-04-20 22:27:00

use Blocks\Models\QueueModel;

class ApiController extends BaseController
{
    protected $tb_file_manage;
    protected $controller_name;
    protected $image;
    protected $helpers = ['user', 'common'];
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
                // Use standard database query to ensure an object is returned reliably
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

                        // Log a connection event if it's been a while (e.g. 5 mins) or no logs exist
                        $lastLog = $this->db->table('device_logs')
                            ->where('device_id', $device->id)
                            ->orderBy('id', 'DESC')
                            ->limit(1)
                            ->get()
                            ->getRow();
                        
                        if (!$lastLog || (strtotime(date('Y-m-d H:i:s')) - strtotime($lastLog->created_at) > 300)) {
                            $this->logDeviceEvent(
                                $device->id, 
                                'device_connected', 
                                'Device connected to server successfully', 
                                'Device IP: ' . $device_ip, 
                                'success'
                            );
                        }

                        return json_encode([
                            "status" => "1", 
                            "message" => $device->uid, 
                            "device_id" => $device->id
                        ]);
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
                'message' => 'System error: ' . $e->getMessage()
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

        // Check device status and insert message
        if (!empty($device->status) && $device->status == 1 && !empty($message)) {
            $data = [
                'uid'        => $device->message,
                'device_id'  => $device->device_id ?? null,
                'message'    => preg_replace("/\r?\n/", " ", $message),
                'address'    => $address,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('module_data')->insert($data);
            $smsId = $this->db->insertID();

            if ($this->db->affectedRows() > 0) {
                if (!empty($device->device_id)) {
                    $this->logDeviceEvent(
                        $device->device_id,
                        'sms_received',
                        "New SMS received from {$address}",
                        "SMS ID: {$smsId}\nContent: " . shorten_string($message, 50),
                        'info'
                    );
                }
                ms(['status' => 1, 'message' => 'Data inserted successfully']);
            } else {
                ms(["status" => "0", "message" => 'Failed to insert data']);
            }
        } else {
            ms(['status' => "0", 'message' => 'Failed to connect or invalid device']);
        }
    }

    public function getLogs()
    {
        $request = service('request');
        $deviceResponse = $this->deviceConnect();
        $device = json_decode($deviceResponse);

        if (empty($device->status) || $device->status != 1 || empty($device->device_id)) {
            ms(['status' => 0, 'message' => 'Authentication failed', 'debug' => $device]);
        }

        $logs = $this->db->table('device_logs')
            ->where('device_id', $device->device_id)
            ->orderBy('id', 'DESC')
            ->limit(30)
            ->get()
            ->getResult();

        ms(['status' => 1, 'logs' => $logs]);
    }

    private function logDeviceEvent($deviceId, $event, $message, $debugData = null, $type = 'info')
    {
        if (!$deviceId) return;
        
        $this->db->table('device_logs')->insert([
            'device_id'  => $deviceId,
            'event'      => $event,
            'type'       => $type,
            'message'    => $message,
            'debug_data' => $debugData,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function cron()
    {
        $this->model->processPendingTasks();

        $webhookService = new \App\Libraries\WebhookService();
        $webhookService->retryFailed();
    }
}

?>
