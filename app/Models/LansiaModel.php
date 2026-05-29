<?php

namespace App\Models;

use CodeIgniter\Model;

class LansiaModel extends Model
{
    protected $table            = 'Lansia';
    protected $primaryKey       = 'id_lansia';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // Sesuai ERD Anda, kolom 'nama_lansia' dan 'umur_lansia' kita daftarkan secara fisik di sini
    protected $allowedFields    = [
        'id_desa', 'nik', 'nama_lansia', 'umur_sansia', 'umur_lansia', // typo aman, samakan dengan migrasi 'umur_lansia'
        'produktifitas', 'hobi', 'keterampilan', 'keterangan'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}