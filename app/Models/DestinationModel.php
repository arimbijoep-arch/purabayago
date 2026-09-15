<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinationModel extends Model
{
    protected $table            = 'destinations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['destination_name', 'description', 'photo', 'photo_alt', 'photo_caption', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAvailableCategories(int $destinationId): array
    {
        $db = $this->db;

        $query = $db->table('bus')
            ->select('bus_class')
            ->distinct()
            ->where('destination_id', $destinationId)
            ->orderBy('bus_class', 'ASC')
            ->get();

        return $query->getResultArray();
    }
}
