<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // 1. Masukkan Data Desa Contoh Terlebih Dahulu
        $dataDesa = [
            'id_desa'   => 'DESA001',
            'nama_desa' => 'Desa Sukamaju'
        ];
        
        // Menggunakan query builder untuk insert ke tabel desa
        $this->db->table('desa')->insert($dataDesa);

        // 2. Masukkan Data Users (Admin & Ketua PKK)
        // Password kita amankan menggunakan password_hash bawaan PHP
        $dataUsers = [
            [
                'username' => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'id_desa'  => null // Admin pusat tidak terikat desa tertentu
            ],
            [
                'username' => 'pkk_sukamaju',
                'email'    => 'pkk.sukamaju@gmail.com',
                'password' => password_hash('pkk123', PASSWORD_DEFAULT),
                'role'     => 'ketua_pkk',
                'id_desa'  => 'DESA001' // Terikat dengan Desa Sukamaju
            ]
        ];

        // insertBatch digunakan untuk memasukkan banyak data sekaligus
        $this->db->table('users')->insertBatch($dataUsers);
    }
}