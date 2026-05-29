<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiRequestModel extends Model
{
    protected $table            = 'api_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_instansi', 'keperluan', 'api_token', 'status'];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}