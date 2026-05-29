<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'adminpusat',
                // password_hash digunakan agar password aman (tidak berupa teks polos di database)
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama'     => 'Ahmad Mujahid',
                'role'     => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'ketuapkk',
                'password' => password_hash('pkk123', PASSWORD_DEFAULT),
                'nama'     => 'Ibu Siti Rahma',
                'role'     => 'pkk',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Memasukkan data secara massal ke dalam tabel 'users'
        // Sesuaikan 'users' dengan nama tabel akun di database Anda
        $this->db->table('users')->insertBatch($data);
    }
}