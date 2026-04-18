<?php

namespace Modules\Home\Database\Migrations;

use CodeIgniter\Database\Migration;

class ApiPayments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ids' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'merchant_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'brand_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'idempotency_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '12,3',
                'default' => '0.000',
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'default' => 'BDT',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => '0=pending,1=processing,2=completed,3=failed,4=refunded',
            ],
            'transaction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'callback_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'success_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cancel_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'customer_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'metadata' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'provider_response' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $tableAttributes = ['ENGINE' => 'InnoDB', 'DEFAULT CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci'];
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('ids');
        $this->forge->addKey('merchant_id');
        $this->forge->addKey('brand_id');
        $this->forge->addKey('status');
        $this->forge->addKey('transaction_id');
        $this->forge->createTable('api_payments', true, $tableAttributes);

        $this->db->query('ALTER TABLE api_payments ADD UNIQUE KEY idx_idempotency (merchant_id, brand_id, idempotency_key)');
    }

    public function down()
    {
        $this->forge->dropTable('api_payments', true);
    }
}
