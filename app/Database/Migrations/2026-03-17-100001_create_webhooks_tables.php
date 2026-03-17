<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebhooksTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'brand_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'merchant_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'url' => ['type' => 'VARCHAR', 'constraint' => 500],
            'secret' => ['type' => 'VARCHAR', 'constraint' => 64],
            'events' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['brand_id', 'merchant_id']);
        $this->forge->createTable('webhooks', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'webhook_id' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'event_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'payload' => ['type' => 'TEXT'],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'delivered', 'failed'], 'default' => 'pending'],
            'attempts' => ['type' => 'TINYINT', 'constraint' => 3, 'default' => 0],
            'last_attempt_at' => ['type' => 'DATETIME', 'null' => true],
            'response_code' => ['type' => 'SMALLINT', 'null' => true],
            'response_body' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('webhook_id');
        $this->forge->addKey('event_type');
        $this->forge->createTable('webhook_events', true);
    }

    public function down()
    {
        $this->forge->dropTable('webhook_events', true);
        $this->forge->dropTable('webhooks', true);
    }
}
