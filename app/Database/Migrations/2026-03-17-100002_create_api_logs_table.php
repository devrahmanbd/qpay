<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApiLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'api_key_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'brand_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'merchant_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'method' => ['type' => 'VARCHAR', 'constraint' => 10],
            'endpoint' => ['type' => 'VARCHAR', 'constraint' => 255],
            'status_code' => ['type' => 'SMALLINT', 'unsigned' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'response_time_ms' => ['type' => 'INT', 'constraint' => 10, 'null' => true],
            'environment' => ['type' => 'ENUM', 'constraint' => ['test', 'live'], 'default' => 'live'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['brand_id', 'created_at']);
        $this->forge->addKey('api_key_id');
        $this->forge->createTable('api_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('api_logs', true);
    }
}
