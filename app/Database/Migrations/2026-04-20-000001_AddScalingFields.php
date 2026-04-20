<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHeartbeatToDevices extends Migration
{
    public function up()
    {
        // Change text columns to varchar so they can be indexed
        $this->forge->modifyColumn('module_data', [
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'tmp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);

        // Add heartbeat fields to devices
        if (!$this->db->fieldExists('last_sync_at', 'devices')) {
            $fields = [
                'last_sync_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'after'   => 'device_ip',
                ],
                'battery_level' => [
                    'type'       => 'INT',
                    'constraint' => 3,
                    'null'       => true,
                    'after'      => 'last_sync_at',
                ],
            ];
            $this->forge->addColumn('devices', $fields);
        }

        // Add recipient_number
        if (!$this->db->fieldExists('recipient_number', 'module_data')) {
            $fields_module = [
                'recipient_number' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'null'       => true,
                    'after'      => 'address',
                ],
            ];
            $this->forge->addColumn('module_data', $fields_module);
        }

        // Add indices for performance (using TRY/CATCH for raw queries)
        try {
            $this->db->query("ALTER TABLE module_data ADD INDEX idx_uid_status_address (uid, status, address)");
        } catch (\Exception $e) {}
        
        try {
            $this->db->query("ALTER TABLE module_data ADD INDEX idx_tmp_id (tmp_id)");
        } catch (\Exception $e) {}
    }

    public function down()
    {
        $this->forge->dropColumn('devices', ['last_sync_at', 'battery_level']);
        $this->forge->dropColumn('module_data', ['recipient_number']);
        $this->db->query("ALTER TABLE module_data DROP INDEX idx_uid_status_address");
        $this->db->query("ALTER TABLE module_data DROP INDEX idx_tmp_id");
    }
}
