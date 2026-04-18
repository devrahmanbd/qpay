<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApiKeysTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'brand_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'merchant_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Default'],
            'key_type' => ['type' => 'ENUM', 'constraint' => ['publishable', 'secret']],
            'key_prefix' => ['type' => 'VARCHAR', 'constraint' => 12],
            'key_hash' => ['type' => 'VARCHAR', 'constraint' => 64],
            'key_last4' => ['type' => 'VARCHAR', 'constraint' => 4],
            'environment' => ['type' => 'ENUM', 'constraint' => ['test', 'live'], 'default' => 'test'],
            'last_used_at' => ['type' => 'DATETIME', 'null' => true],
            'expires_at' => ['type' => 'DATETIME', 'null' => true],
            'revoked_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('key_prefix');
        $this->forge->addKey('key_hash');
        $this->forge->addKey(['brand_id', 'merchant_id']);
        $this->forge->createTable('api_keys', true);
    }

    public function down()
    {
        $this->forge->dropTable('api_keys', true);
    }
}
