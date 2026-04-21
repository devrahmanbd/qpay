<?php
namespace App\Controllers;
// Cache buster: 2026-04-21 01:26:00

use Blocks\Models\QueueModel;

class ApiController extends BaseController
{
    protected $tb_file_manage;
    protected $controller_name;
    protected $image;
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
                log_message('error', "[ApiController] Received connection request: Email={$user_email}, Key={$device_key}, IP={$device_ip}");

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
            $errorInfo = [
                'status' => 0, 
                'message' => 'Server Error [VERIFY-SYNC-A1]: ' . $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine()
            ];
            log_message('error', "[ApiController] FATAL ERROR: " . json_encode($errorInfo));
            return json_encode($errorInfo);
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

    private function logDeviceEvent($deviceId, $event, $message, $debugData = null, $type = 'info')
    {
        if (!$deviceId) return;
        
        try {
            $this->db->table('device_logs')->insert([
                'device_id'  => $deviceId,
                'event'      => $event,
                'type'       => $type,
                'message'    => $message,
                'debug_data' => $debugData,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Throwable $e) {
            // Log the failure to the system log so you can see it in error_log
            log_message('error', "[ApiController] Telemetry Logging Failed: " . $e->getMessage());
            // We do NOT throw the error further so the user can still connect
        }
    }

    public function cron()
    {
        $this->model->processPendingTasks();

        $webhookService = new \App\Libraries\WebhookService();
        $webhookService->retryFailed();
    }

    /**
     * Diagnostic Ping
     * Use this to verify if the code on the server is actually synced
     */
    public function ping()
    {
        return json_encode([
            'status' => 1,
            'message' => 'PONG-v3', // Incremented version to verify sync
            'time' => date('Y-m-d H:i:s'),
            'db_status' => (db_connect()->connect() ? 'Connected' : 'Failed')
        ]);
    }

    /**
     * Diagnostic Log Fetcher
     * WARNING: Temporary diagnostic use ONLY. 
     */
    public function getSystemLogs()
    {
        $logFile = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
        if (file_exists($logFile)) {
            $content = file_get_contents($logFile);
            $lines = explode("\n", $content);
            $lastLines = array_slice($lines, -100);
            return json_encode(['status' => 1, 'logs' => $lastLines]);
        }
        return json_encode(['status' => 0, 'message' => 'Log file not found for today: ' . $logFile]);
    }

    /**
     * Remote Log Receiver
     * Allows the Android app to send its error logs to the server
     */
    public function receiveAppLog()
    {
        $request = service('request');
        $logData = [
            'email' => $request->getVar('email'),
            'device_key' => $request->getVar('device_key'),
            'error' => $request->getVar('error_message'),
            'raw_response' => $request->getVar('raw_response'),
            'version' => $request->getVar('version') ?? 'unknown'
        ];
        $message = "[REMOTE_APP_LOG] " . json_encode($logData);
        log_message('error', $message);
        error_log($message); // Also to PHP system log

        return json_encode(['status' => 1, 'message' => 'Log received and stored']);
    }
}

?>
