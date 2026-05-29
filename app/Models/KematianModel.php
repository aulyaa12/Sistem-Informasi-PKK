<?php

namespace App\Models;

use CodeIgniter\Model;

class KematianModel extends Model
{
    protected $table            = 'Kematian';
    protected $primaryKey       = 'id_kematian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // Sesuai ERD Anda, kolom 'nama_almarhum' didaftarkan secara fisik di sini
    protected $allowedFields    = [
        'id_desa', 'nik', 'nama_almarhum', 'tempat_kematian', 'tgl_kematian', 'keterangan'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}