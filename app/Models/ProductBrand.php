<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductBrand extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'product_brand';
    protected $primaryKey       = 'brand_name';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getAll()
    {

        $builder = $this->db->table('product_brand');
        // $builder->select('brand_name');
        $query   = $builder->get();
        return $query->getResult();
    }
}
