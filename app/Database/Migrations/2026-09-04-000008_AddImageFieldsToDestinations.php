<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageFieldsToDestinations extends Migration
{
    public function up()
    {
        $this->forge->addColumn('destinations', [
            'photo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'description'],
            'photo_alt' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'photo'],
            'photo_caption' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'photo_alt'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('destinations', ['photo', 'photo_alt', 'photo_caption']);
    }
}
