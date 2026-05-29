<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'no_hp',
        'jabatan',
        'alasan_pengajuan',
        'role',
        'status',
        'registration_code',
        'approved_by',
        'approved_at',
        'rejected_reason',
        'id_desa',
        'requested_id_desa',
        'requested_nama_desa',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}