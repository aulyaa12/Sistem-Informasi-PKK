<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLansiaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lansia' => [
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
            'nama_lansia' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'umur_lansia' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'produktifitas' => [
                'type'       => 'ENUM',
                'constraint' => ['produktif', 'non-produktif'],
            ],
            'hobi' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'keterampilan' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id_lansia', true);
        $this->forge->addForeignKey('id_desa', 'desa', 'id_desa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('nik', 'PendudukDesa', 'nik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Lansia');
    }

    public function down()
    {
        $this->forge->dropTable('Lansia');
    }
}