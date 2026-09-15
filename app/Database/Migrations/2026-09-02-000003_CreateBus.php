<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'operator' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'destination_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'bus_class' => [
                'type'       => 'ENUM',
                'constraint' => ['ekonomi', 'patas', 'executive'],
            ],
            'departure_time' => [
                'type' => 'TIME',
            ],
            'fare' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'departure_area' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'ticket_information' => [
                'type' => 'TEXT',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'last_updated' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('destination_id', 'destinations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bus');
    }

    public function down()
    {
        $this->forge->dropTable('bus');
    }
}
