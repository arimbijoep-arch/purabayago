<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBusTableAddFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bus', [
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
                'null'       => false,
            ],
            'capacity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 40,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default'    => 'aktif',
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bus', ['quantity', 'capacity', 'status']);
    }
}
