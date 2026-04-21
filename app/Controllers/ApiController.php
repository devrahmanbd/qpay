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
                // 1. Find User by Email
                $user = $this->db->table('users')
                    ->select('id')
                    ->where('email', $user_email)
                    ->get()
                    ->getRow();
                
                if (!$user) {
                    return json_encode(['status' => 0, 'message' => 'User account not found']);
                }

                $uid = $user->id;

                // 2. Check for Active Plan
                $plan = get_active_plan($uid);
                if (!$plan) {
                    // Check if they HAVE a plan that is expired vs no plan at all
                    $hasAnyPlan = $this->db->table('user_plans')->where('uid', $uid)->countAllResults();
                    $msg = $hasAnyPlan > 0 ? 'Your plan has expired. Please renew.' : 'No active plan found. Please purchase a plan.';
                    return json_encode(['status' => 0, 'message' => $msg]);
                }

                // 3. Find Device
                $device = $this->db->table('devices')
                    ->select('id, uid, device_ip')
                    ->where('user_email', $user_email)
                    ->where('device_key', $device_key)
                    ->get()
                    ->getRow();

                if ($device) {
                    // 4. Validate Device Limit (uses new simplified logic)
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
                            "status" => 1, 
                            "message" => (string)$device->uid, 
                            "device_id" => (int)$device->id
                        ]);
                    } else {
                        return json_encode(["status" => 0, "message" => 'Device limit reached or key unauthorized']);
                    }
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect Device Key or Email']);
                }
            }

            $missing = [];
            if (!$user_email) $missing[] = 'user_email';
            if (!$device_key) $missing[] = 'device_key';
            if (!$device_ip) $missing[] = 'device_ip';
            
            $msg = count($missing) > 0 
                ? 'Missing required parameters: ' . implode(', ', $missing) 
                : 'Connection failed: Data required';

            return json_encode(['status' => 0, 'message' => $msg]);

        } catch (\Throwable $e) {
            return json_encode([
                'status' => 0, 
                'message' => 'Server Error [VERIFY-SYNC-A1]: ' . $e->getMessage()
            ]);
        }
    }
    
    public function addMessage()
    {
        $request = service('request');
        $deviceResponse = $this->deviceConnect();
        $deviceData = json_decode($deviceResponse);

        if (!$deviceData || $deviceData->status != 1) {
            ms([
                'status' => 0,
                'message' => $deviceData->message ?? 'Authentication failed'
            ]);
            return;
        }

        $address = $request->getVar('address');
        $message = $request->getVar('message');

        if (!empty($message)) {
            $data = [
                'uid'        => $deviceData->message,
                'device_id'  => $deviceData->device_id ?? null,
                'message'    => preg_replace("/\r?\n/", " ", $message),
                'address'    => $address,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('module_data')->insert($data);
            $smsId = $this->db->insertID();

            if ($this->db->affectedRows() > 0) {
                if (!empty($deviceData->device_id)) {
                    $this->logDeviceEvent(
                        $deviceData->device_id,
                        'sms_received',
                        "New SMS received from {$address}",
                        "SMS ID: {$smsId}\nContent: " . shorten_string($message, 50),
                        'info'
                    );
                }
                ms(['status' => 1, 'message' => 'Data inserted successfully']);
            } else {
                ms(["status" => 0, "message" => 'Failed to insert data']);
            }
        } else {
            ms(['status' => 0, 'message' => 'Empty message received']);
        }
    }

    public function getLogs()
    {
        $request = service('request');
        $deviceResponse = $this->deviceConnect();
        $deviceData = json_decode($deviceResponse);

        if (!$deviceData || $deviceData->status != 1 || empty($deviceData->device_id)) {
            ms([
                'status' => 0, 
                'message' => $deviceData->message ?? 'Authentication failed'
            ]);
            return;
        }

        $logs = $this->db->table('device_logs')
            ->where('device_id', $deviceData->device_id)
            ->orderBy('id', 'DESC')
            ->limit(30)
            ->get()
            ->getResult();

        ms(['status' => 1, 'logs' => $logs]);
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
