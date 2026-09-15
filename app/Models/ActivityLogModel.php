<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'action', 'description', 'ip_address', 'created_at'];

    protected $useTimestamps = false;

    public function log($userId, $action, $description = '', $ipAddress = '')
    {
        return $this->insert([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ipAddress ?: $_SERVER['REMOTE_ADDR'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getWithUser()
    {
        return $this->select('activity_logs.*, users.username, users.nama_lengkap')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.created_at', 'DESC')
            ->paginate(20);
    }

    public function pager()
    {
        return $this->pager;
    }
}
