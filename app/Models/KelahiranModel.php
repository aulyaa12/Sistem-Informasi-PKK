<?php

namespace App\Models;

use CodeIgniter\Model;

class KelahiranModel extends Model
{
    protected $table            = 'Kelahiran';
    protected $primaryKey       = 'id_kelahiran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_desa', 'nik_ibu', 'nama_bayi', 'jenis_kelamin', 
        'tempat_lahir', 'tgl_lahir'
    ]; // Kolom 'umur_bulan' terisi otomatis oleh MySQL

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}