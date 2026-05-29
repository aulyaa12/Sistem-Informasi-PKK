<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukDesaModel extends Model
{
    protected $table            = 'PendudukDesa';
    protected $primaryKey       = 'nik';
    protected $useAutoIncrement = false; // NIK berupa CHAR/string
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nik', 'id_desa', 'no_kk', 'nama', 'jenis_kelamin', 
        'tempat_lahir', 'tgl_lahir', 'alamat', 'RT', 
        'pekerjaan', 'status_pernikahan', 'pendidikan'
    ]; // Catatan: Kolom 'usia' tidak dimasukkan ke allowedFields karena diisi otomatis oleh MySQL

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}