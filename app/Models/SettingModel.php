<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['setting_key', 'setting_value', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getValue(string $key, ?string $default = null): ?string
    {
        $setting = $this->where('setting_key', $key)->first();
        return $setting['setting_value'] ?? $default;
    }

    public function setValue(string $key, ?string $value): bool
    {
        $setting = $this->where('setting_key', $key)->first();
        $data = ['setting_key' => $key, 'setting_value' => $value];

        return $setting
            ? (bool) $this->update($setting['id'], ['setting_value' => $value])
            : (bool) $this->insert($data);
    }
}
