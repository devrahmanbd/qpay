<?php

/**
 * Migration Script: transactions -> api_payments
 * Run this once via 'php public/index.php migrate:transactions' or similar.
 */

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateTransactions extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'migrate:transactions';
    protected $description = 'Migrates legacy transactions table into api_payments table.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        $legacy = $db->table('transactions')->get()->getResultArray();
        
        CLI::write("Found " . count($legacy) . " legacy transactions.");
        
        $count = 0;
        foreach ($legacy as $row) {
            // Check if already exists in target
            $exists = $db->table('api_payments')->where('ids', $row['ids'])->countAllResults();
            if ($exists > 0) continue;

            $data = [
                'ids'             => $row['ids'],
                'merchant_id'     => $row['uid'],
                'brand_id'        => $row['brand_id'],
                'amount'          => $row['amount'],
                'currency'        => $row['currency'],
                'status'          => $row['status'],
                'transaction_id'  => $row['transaction_id'],
                'payment_method'  => $row['type'],
                'created_at'      => $row['created_at'],
                'updated_at'      => $row['updated_at'],
                'metadata'        => json_encode(['legacy' => true, 'message' => $row['message']])
            ];

            $db->table('api_payments')->insert($data);
            $count++;
        }

        CLI::write("Successfully migrated $count transactions!");
    }
}
