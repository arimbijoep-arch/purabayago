<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'nama_lengkap',
        'email',
        'password',
        'foto_profil',
        'role',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'nama_lengkap' => 'required|min_length[3]|max_length[150]',
        'email' => 'required|valid_email|max_length[150]|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]|max_length[255]',
        'role' => 'required|in_list[admin,user]',
        'status' => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username wajib diisi.',
            'min_length' => 'Username minimal 3 karakter.',
            'is_unique' => 'Username sudah digunakan.',
        ],
        'nama_lengkap' => [
            'required' => 'Nama lengkap wajib diisi.',
            'min_length' => 'Nama lengkap minimal 3 karakter.',
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email sudah terdaftar.',
        ],
        'password' => [
            'required' => 'Password wajib diisi.',
            'min_length' => 'Password minimal 6 karakter.',
        ],
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (! isset($data['data']['password']) || empty($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }

    public function login(string $identity, string $password): ?array
    {
        $user = $this->where('username', $identity)
            ->orWhere('email', $identity)
            ->first();

        if (! $user) {
            return null;
        }

        if ($user['status'] !== 'active') {
            return null;
        }

        if (! password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }
}
