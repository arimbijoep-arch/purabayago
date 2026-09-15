<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPendingUserStatus extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY status ENUM('pending', 'active', 'inactive') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        $this->db->query("UPDATE users SET status = 'inactive' WHERE status = 'pending'");
        $this->db->query("ALTER TABLE users MODIFY status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'");
    }
}