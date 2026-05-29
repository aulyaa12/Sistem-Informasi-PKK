<?php

namespace App\Models;

use CodeIgniter\Model;

class DesaModel extends Model
{
    protected $table            = 'desa';
    protected $primaryKey       = 'id_desa';
    protected $useAutoIncrement = false; // Karena id_desa berupa VARCHAR/string inputan sendiri
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_desa', 'nama_desa'];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}