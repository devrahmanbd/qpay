<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestSmsStorage extends BaseCommand
{
    protected $group       = 'Tests';
    protected $name        = 'test:sms-storage';
    protected $description = 'Tests the SMS storage logic end-to-end.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        // 1. Find ANY authorized device to test logic
        $device = $db->table('devices')->get()->getRow();
        if (!$device) {
            CLI::error("No devices found in database. Cannot run test.");
            return;
        }
        
        $email = $device->user_email;
        $key = $device->device_key;
        $uid = $device->uid;
        $address = 'Nagad';
        $message = 'TrxID 9K27XJ2L Verified Payment of Tk 500 received. Ref: SPARK_TEST';

        CLI::write("--- Starting SMS Storage Test ---", 'yellow');
        CLI::write("Testing with Device ID: " . $device->id . " | Email: " . $email, 'cyan');

        // 2. Verify User
        $user = $db->table('users')->where('id', $uid)->get()->getRow();
        if (!$user) {
            CLI::error("User with UID $uid not found.");
            return;
        }
        CLI::write("[PASS] User found: " . $user->email, 'green');

        // 3. Insert Data
        $insertData = [
            'uid'        => $user->id,
            'device_id'  => $device->id,
            'message'    => $message,
            'address'    => $address,
            'created_at' => date('Y-m-d H:i:s'),
            'status'     => 0
        ];

        CLI::write("Inserting test message...");
        $db->table('module_data')->insert($insertData);

        if ($db->affectedRows() > 0) {
            $insertId = $db->insertID();
            CLI::write("[PASS] Data stored successfully! SMS ID: $insertId", 'green');
            
            // 4. Verify Search Logic (Matches SmsVerificationAdapter)
            $search = $db->table('module_data')
                ->where('id', $insertId)
                ->where('uid', $user->id)
                ->like('message', '9K27XJ2L')
                ->get()->getRow();
                
            if ($search) {
                CLI::write("[PASS] Search logic found the transaction correctly.", 'green');
            } else {
                CLI::error("Search logic could not find the ID in the stored message.");
            }
            
            // Clean up
            $db->table('module_data')->where('id', $insertId)->delete();
            CLI::write("Cleanup complete.", 'yellow');
        } else {
            CLI::error("Could not insert data into module_data table.");
        }

        CLI::write("--- Test Complete ---", 'yellow');
    }
}
