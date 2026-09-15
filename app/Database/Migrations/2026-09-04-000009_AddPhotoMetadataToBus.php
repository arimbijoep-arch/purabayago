<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoMetadataToBus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bus', [
            'photo_alt' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'photo'],
            'photo_caption' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'photo_alt'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bus', ['photo_alt', 'photo_caption']);
    }
}
