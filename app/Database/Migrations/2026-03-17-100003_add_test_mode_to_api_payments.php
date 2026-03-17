<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTestModeToApiPayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('api_payments', [
            'test_mode' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'status'],
            'webhook_delivered' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'test_mode'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('api_payments', ['test_mode', 'webhook_delivered']);
    }
}
