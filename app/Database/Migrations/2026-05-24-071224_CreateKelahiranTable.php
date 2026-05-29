<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelahiranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelahiran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nik_ibu' => [
                'type'       => 'CHAR',
                'constraint' => 16,
            ],
            'nama_bayi' => [
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
            // Mengubah umur_bulan menjadi kolom INT biasa yang aman bagi MySQL
            'umur_bulan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        
        $this->forge->addKey('id_kelahiran', true);
        $this->forge->addForeignKey('id_desa', 'desa', 'id_desa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('nik_ibu', 'PendudukDesa', 'nik', 'CASCADE', 'CASCADE');
        
        // 1. Buat tabel Kelahiran terlebih dahulu
        $this->forge->createTable('Kelahiran');

        // 2. Buat TRIGGER untuk menghitung umur_bulan otomatis saat data baru masuk (INSERT)
        $this->db->query("
            CREATE TRIGGER sebelum_tambah_kelahiran
            BEFORE INSERT ON Kelahiran
            FOR EACH ROW
            SET NEW.umur_bulan = TIMESTAMPDIFF(MONTH, NEW.tgl_lahir, CURDATE());
        ");

        // 3. Buat TRIGGER untuk memperbarui umur_bulan otomatis jika tgl_lahir diubah (UPDATE)
        $this->db->query("
            CREATE TRIGGER sebelum_ubah_kelahiran
            BEFORE UPDATE ON Kelahiran
            FOR EACH ROW
            SET NEW.umur_bulan = TIMESTAMPDIFF(MONTH, NEW.tgl_lahir, CURDATE());
        ");
    }

    public function down()
    {
        // Hapus trigger terlebih dahulu sebelum menghapus tabel agar bersih saat rollback
        $this->db->query("DROP TRIGGER IF EXISTS sebelum_tambah_kelahiran");
        $this->db->query("DROP TRIGGER IF EXISTS sebelum_ubah_kelahiran");
        
        $this->forge->dropTable('Kelahiran');
    }
}