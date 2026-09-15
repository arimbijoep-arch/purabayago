<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSheltersAndExtendBus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'shelter_number' => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true],
            'category' => ['type' => 'ENUM', 'constraint' => ['ekonomi', 'patas', 'executive', 'jalur_bebas']],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => false],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('shelter_number');
        $this->forge->createTable('shelters');

        $this->forge->addColumn('bus', [
            'shelter_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'null' => true],
            'fare_max' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
        ]);
        $this->forge->addForeignKey('shelter_id', 'shelters', 'id', 'SET NULL', 'CASCADE');
        $this->forge->processIndexes('bus');
    }

    public function down()
    {
        $this->forge->dropColumn('bus', ['shelter_id', 'fare_max']);
        $this->forge->dropTable('shelters');
    }
}