<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class WilayahController extends BaseController
{
    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    // 1. Ambil Semua Provinsi (Unik)
    public function getProvinsi() {
        $query = $this->db->table('master_wilayah')
                          ->select('provinsi')
                          ->distinct()
                          ->get()
                          ->getResultArray();
        return $this->response->setJSON($query);
    }

    // 2. Ambil Kabupaten berdasarkan Provinsi yang dipilih
    public function getKabupaten() {
        $provinsi = $this->request->getGet('provinsi');
        $query = $this->db->table('master_wilayah')
                          ->select('kabupaten')
                          ->where('provinsi', $provinsi)
                          ->distinct()
                          ->get()
                          ->getResultArray();
        return $this->response->setJSON($query);
    }

    // 3. Ambil Kecamatan berdasarkan Kabupaten yang dipilih
    public function getKecamatan() {
        $kabupaten = $this->request->getGet('kabupaten');
        $query = $this->db->table('master_wilayah')
                          ->select('kecamatan')
                          ->where('kabupaten', $kabupaten)
                          ->distinct()
                          ->get()
                          ->getResultArray();
        return $this->response->setJSON($query);
    }

    // 4. Ambil Desa berdasarkan Kecamatan yang dipilih
    public function getDesa() {
        $kecamatan = $this->request->getGet('kecamatan');
        $query = $this->db->table('master_wilayah')
                          ->select('nama_desa')
                          ->where('kecamatan', $kecamatan)
                          ->distinct()
                          ->get()
                          ->getResultArray();
        return $this->response->setJSON($query);
    }
}