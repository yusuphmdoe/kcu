<?php

namespace App\Models;

use CodeIgniter\Model;

class CuttingModel extends Model
{
    protected $table            = 'cuttings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'tailor_id', 'quantity_used'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $hidden = [];

    public function findSafe($id = null)
    {
        $row = $this->find($id);
        return $this->hideFields($row);
    }

    public function findAllSafe(?int $limit = null, int $offset = 0): array
    {
        $rows = $this->findAll($limit, $offset);
        return array_map(fn ($row) => $this->hideFields($row), $rows);
    }

    protected function hideFields($row)
    {
        if (! is_array($row) || $this->hidden === []) {
            return $row;
        }

        foreach ($this->hidden as $field) {
            unset($row[$field]);
        }

        return $row;
    }
}