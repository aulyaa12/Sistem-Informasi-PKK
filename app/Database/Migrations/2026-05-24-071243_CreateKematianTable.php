<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKematianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kematian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nik' => [
                'type'       => 'CHAR',
                'constraint' => 16,
            ],
            'nama_almarhum' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tempat_kematian' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tgl_kematian' => [
                'type' => 'DATE',
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id_kematian', true);
        $this->forge->addForeignKey('id_desa', 'desa', 'id_desa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('nik', 'PendudukDesa', 'nik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Kematian');
    }

    public function down()
    {
        $this->forge->dropTable('Kematian');
    }
}