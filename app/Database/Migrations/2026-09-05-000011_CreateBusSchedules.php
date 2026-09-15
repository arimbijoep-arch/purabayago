<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusSchedules extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'bus_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'departure_time' => ['type' => 'TIME', 'null' => true],
            'schedule_status' => ['type' => 'ENUM', 'constraint' => ['available', 'estimated', 'flexible'], 'default' => 'estimated'],
            'frequency' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'note' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => false],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['bus_id', 'departure_time']);
        $this->forge->addForeignKey('bus_id', 'bus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bus_schedules');
    }

    public function down()
    {
        $this->forge->dropTable('bus_schedules');
    }
}