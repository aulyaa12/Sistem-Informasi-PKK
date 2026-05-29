<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendudukDesaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nik' => [
                'type'       => 'CHAR',
                'constraint' => 16,
            ],
            'id_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'no_kk' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tgl_lahir' => [
                'type' => 'DATE',
            ],
            // Usia terhitung otomatis di sisi database MySQL menggunakan fitur Generated Column
            'usia tinyint GENERATED ALWAYS AS (TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE())) STORED',
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => 300,
            ],
            'RT' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'pekerjaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status_pernikahan' => [
                'type'       => 'ENUM',
                'constraint' => ['belum', 'menikah'],
            ],
            'pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('nik', true);
        $this->forge->addForeignKey('id_desa', 'desa', 'id_desa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('PendudukDesa');
    }

    public function down()
    {
        $this->forge->dropTable('PendudukDesa');
    }
}