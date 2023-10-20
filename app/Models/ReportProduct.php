<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportProduct extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'report_product';
    protected $primaryKey       = 'report_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getAll()
    {
        $builder = $this->db->table('report_product');
        $query   = $builder->get();
        return $query->getResult();
    }

    public function getData()
    {
        $builder = $this->db->table('report_product');
        $builder->select('product_brand.brand_name, store_area.area_name, compliance');
        $builder->join('product', 'report_product.product_id = product.product_id', 'inner');
        $builder->join('store', 'report_product.store_id = store.store_id', 'inner');
        $builder->join('product_brand', 'product.brand_id = product_brand.brand_id', 'inner');
        $builder->join('store_area', 'store.area_id = store_area.area_id', 'inner');

        $query   = $builder->get();
        return $query->getResult();
    }

    public function getNilaiArea($area, $brand = null, $tgl_awal = null, $tgl_akhir = null)
    {
        $totalRows = $this->getRows($area, $brand, $tgl_awal, $tgl_akhir);
        $result = $this->prepareQuery($area, $brand, $tgl_awal, $tgl_akhir)->get()->getResult();
        return $this->calculateNilai($result, $totalRows);
    }

    public function getNilaiAreaBrand($area, $brand = null, $tgl_awal = null, $tgl_akhir = null)
    {
        $totalRows = $this->getRows($area, $brand, $tgl_awal, $tgl_akhir);
        $result = $this->prepareQuery($area, $brand, $tgl_awal, $tgl_akhir)->get()->getResult();
        return $this->calculateNilai($result, $totalRows);
    }

    protected function prepareQuery($area, $brand = null, $tgl_awal = null, $tgl_akhir = null)
    {
        $builder = $this->db->table('report_product');
        $builder->select('product_brand.brand_name, store_area.area_name, SUM(compliance) as total_compliance');
        $builder->join('product', 'report_product.product_id = product.product_id', 'inner');
        $builder->join('store', 'report_product.store_id = store.store_id', 'inner');
        $builder->join('product_brand', 'product.brand_id = product_brand.brand_id', 'inner');
        $builder->join('store_area', 'store.area_id = store_area.area_id', 'inner');

        $builder->where('store_area.area_id', $area);

        if ($brand) {
            $builder->where('product_brand.brand_id', $brand);
        }
        if ($tgl_awal) {
            $builder->where('tanggal >=', $tgl_awal);
        }
        if ($tgl_akhir) {
            $builder->where('tanggal <=', $tgl_akhir);
        }

        // $builder->groupBy('product_brand.brand_name, store_area.area_name');

        return $builder;
    }


    protected function getRows($area, $brand = null, $tgl_awal = null, $tgl_akhir = null)
    {
        $builder = $this->prepareQuery($area, $brand, $tgl_awal, $tgl_akhir);
        return $builder->countAllResults();
    }

    protected function calculateNilai($result, $totalRows)
    {
        if (!empty($result) && !empty($totalRows)) {
            $totalCompliance = $result[0]->total_compliance;
            $nilai = ($totalCompliance / $totalRows) * 100;
            return $nilai;
        } else {
            return null;
        }
    }
}
