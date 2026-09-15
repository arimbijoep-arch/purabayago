<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoToBus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bus', [
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'operator',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bus', 'photo');
    }
}
