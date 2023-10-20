<?php

namespace App\Controllers;

use App\Models\ReportProduct;
use App\Models\StoreArea;
use App\Models\ProductBrand;
use CodeIgniter\Controller;

class Home extends Controller
{
    protected $reportProduct;
    protected $storeArea;
    protected $productBrand;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->reportProduct = new ReportProduct();
        $this->storeArea = new StoreArea();
        $this->productBrand = new ProductBrand();
    }

    public function index()
    {
        $daftarBrand = $this->productBrand->getAll();
        $daftarArea = $this->storeArea->getAll();
        $hasilPerhitungan = [];
        $nilaiArea = [];

        $dateStart = $this->request->getVar('date_start');
        $dateEnd = $this->request->getVar('date_end');
        $selectedAreas = $this->request->getVar('selectedAreas');
        if (!empty($selectedAreas)) {
            // Loop melalui area yang dipilih
            foreach ($selectedAreas as $selectedArea) {
                // Loop melalui daftar area

                foreach ($daftarArea as $area) {
                    if ($area->area_id === $selectedArea) { // Cocokkan value dengan kunci area
                        $nilai = $this->reportProduct->getNilaiArea($selectedArea, null, $dateStart, $dateEnd);
                        $nilaiArea[] = [
                            'area' => $area->area_name,
                            'nilai' => $nilai,
                        ];
                        break; // Keluar dari loop daftarArea setelah kecocokan ditemukan
                    }
                }
            }
        } else {
            foreach ($daftarArea as $area) {
                // Hitung dan simpan nilai area untuk setiap area
                $nilai = $this->reportProduct->getNilaiArea($area->area_id, null, $dateStart, $dateEnd);
                $nilaiArea[] = [
                    'area' => $area->area_name,
                    'nilai' => $nilai,
                ];
            }
        }

        foreach ($daftarArea as $area) {
            foreach ($daftarBrand as $brand) {
                $nilai = $this->reportProduct->getNilaiAreaBrand($area->area_id, $brand->brand_id, $dateStart, $dateEnd);
                // Simpan hasil perhitungan ke dalam array asosiatif
                $hasilPerhitungan[] = [
                    'area' => $area->area_name,
                    'brand' => $brand->brand_name,
                    'nilai' => $nilai,
                ];
            }
        }


        $data = [
            'daftar_brand' => $daftarBrand,
            'tgl_awal' => $dateStart,
            'tgl_akhir' => $dateEnd,
            'selectedArea' => $nilaiArea,
            'daftar_area' => $daftarArea,
            'hasil_perhitungan' => $hasilPerhitungan,
            'nilai_area' => $nilaiArea,
        ];
        return view('dashboard', $data);
    }


    // public function index()
    // {
    //     $daftarBrand = $this->productBrand->getAll();
    //     $daftarArea = $this->storeArea->getAll();
    //     $hasilPerhitungan = [];
    //     $nilaiArea = []; // Inisialisasi array untuk nilai area

    //     $dateStart = $this->request->getVar('date_start');
    //     $dateEnd = $this->request->getVar('date_end');
    //     $selectedAreas = $this->request->getVar('selectedAreas');
    //     // dd($selectedAreas[1]);
    //     foreach ($selectedAreas as $selectedArea) {
    //         $i = 0;
    //         foreach ($daftarArea as $area) {
    //             // Hitung dan simpan nilai area untuk setiap area
    //             $nilai = $this->reportProduct->getNilaiArea($selectedArea[$i], null, $dateStart, $dateEnd);
    //             $nilaiArea[] = [
    //                 'area' => $area->area_name,
    //                 'nilai' => $nilai,
    //             ];
    //             foreach ($daftarBrand as $brand) {
    //                 $nilai = $this->reportProduct->getNilaiAreaBrand($selectedArea[$i], $brand->brand_id, $dateStart, $dateEnd);
    //                 // Simpan hasil perhitungan ke dalam array asosiatif
    //                 $hasilPerhitungan[] = [
    //                     'area' => $area->area_name,
    //                     'brand' => $brand->brand_name,
    //                     'nilai' => $nilai,
    //                 ];
    //             }
    //         }
    //         $i++;
    //     }


    //     $data = [
    //         'daftar_brand' => $daftarBrand,
    //         'tgl_awal' => $dateStart,
    //         'tgl_akhir' => $dateEnd,
    //         'daftar_areas' => $daftarArea,
    //         'daftar_area' => $daftarArea,
    //         'hasil_perhitungan' => $hasilPerhitungan,
    //         'nilai_area' => $nilaiArea, // Sekarang ini berisi semua nilai area
    //     ];
    //     return view('dashboard', $data);
    // }
}
