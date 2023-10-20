<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreArea extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'store_area';
    protected $primaryKey       = 'area_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getAll()
    {

        $builder = $this->db->table('store_area');
        // $builder->select('area_name');
        $query   = $builder->get();
        return $query->getResult();
    }
}
