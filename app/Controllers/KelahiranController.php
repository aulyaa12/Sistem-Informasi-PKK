<?php

namespace App\Controllers;

use App\Models\KelahiranModel;
use App\Models\PendudukDesaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class KelahiranController extends BaseController
{
    protected $kelahiranModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->kelahiranModel = new KelahiranModel();
        $this->pendudukModel  = new PendudukDesaModel();
    }

    private function getIdDesa()
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return null;
        }

        return $idDesa;
    }

    private function ibuMilikDesa($nikIbu, $idDesa)
    {
        return $this->pendudukModel
            ->where('nik', $nikIbu)
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->first();
    }

    // 1. TAMPILKAN DAFTAR KELAHIRAN SESUAI DESA USER LOGIN
    public function index()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kelahiran = $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->orderBy('Kelahiran.id_kelahiran', 'DESC')
            ->findAll();

        return view('pkk/kelahiran/index', [
            'title'     => 'Pencatatan Data Kelahiran Anak',
            'kelahiran' => $kelahiran
        ]);
    }

    // 2. FORM TAMBAH KELAHIRAN
    public function create()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $paraIbu = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->orderBy('nama', 'ASC')
            ->findAll();

        return view('pkk/kelahiran/create', [
            'title'    => 'Input Data Kelahiran Baru',
            'para_ibu' => $paraIbu
        ]);
    }

    // 3. SIMPAN DATA KELAHIRAN
    public function store()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $rules = [
            'nik_ibu'       => 'required',
            'nama_bayi'     => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tgl_lahir'     => 'required|valid_date',
            'tempat_lahir'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nikIbu = $this->request->getPost('nik_ibu');

        $ibu = $this->ibuMilikDesa($nikIbu, $idDesa);

        if (!$ibu) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data ibu tidak ditemukan atau bukan penduduk desa Anda.');
        }

        $this->kelahiranModel->insert([
            'id_desa'       => $idDesa,
            'nik_ibu'       => $nikIbu,
            'nama_bayi'     => $this->request->getPost('nama_bayi'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ]);

        return redirect()
            ->to('/pkk/kelahiran')
            ->with('success', 'Data kelahiran anak berhasil dicatat.');
    }

    // 4. DETAIL KELAHIRAN
    public function detail($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kelahiran = $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_kelahiran', $id)
            ->where('Kelahiran.id_desa', $idDesa)
            ->first();

        if (!$kelahiran) {
            return redirect()
                ->to('/pkk/kelahiran')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        return view('pkk/kelahiran/detail', [
            'title'     => 'Detail Riwayat Kelahiran',
            'kelahiran' => $kelahiran
        ]);
    }

    // 5. FORM EDIT KELAHIRAN
    public function edit($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kelahiran = $this->kelahiranModel
            ->where('id_kelahiran', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$kelahiran) {
            return redirect()
                ->to('/pkk/kelahiran')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $paraIbu = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->orderBy('nama', 'ASC')
            ->findAll();

        return view('pkk/kelahiran/edit', [
            'title'     => 'Edit Data Kelahiran Anak',
            'kelahiran' => $kelahiran,
            'para_ibu'  => $paraIbu
        ]);
    }

    // 6. UPDATE DATA KELAHIRAN
    public function update($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kelahiran = $this->kelahiranModel
            ->where('id_kelahiran', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$kelahiran) {
            return redirect()
                ->to('/pkk/kelahiran')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $rules = [
            'nik_ibu'       => 'required',
            'nama_bayi'     => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tgl_lahir'     => 'required|valid_date',
            'tempat_lahir'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nikIbu = $this->request->getPost('nik_ibu');

        $ibu = $this->ibuMilikDesa($nikIbu, $idDesa);

        if (!$ibu) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data ibu tidak ditemukan atau bukan penduduk desa Anda.');
        }

        $this->kelahiranModel->update($id, [
            'nik_ibu'       => $nikIbu,
            'nama_bayi'     => $this->request->getPost('nama_bayi'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ]);

        return redirect()
            ->to('/pkk/kelahiran')
            ->with('success', 'Data kelahiran berhasil diperbarui.');
    }

    // 7. HAPUS DATA KELAHIRAN
    public function delete($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kelahiran = $this->kelahiranModel
            ->where('id_kelahiran', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$kelahiran) {
            return redirect()
                ->to('/pkk/kelahiran')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $this->kelahiranModel->delete($id);

        return redirect()
            ->to('/pkk/kelahiran')
            ->with('success', 'Data pencatatan kelahiran berhasil dihapus.');
    }

    // 8. EXPORT DATA KELAHIRAN KE EXCEL
    public function export()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $db = \Config\Database::connect();

        $desa = $db->table('desa')
            ->where('id_desa', $idDesa)
            ->get()
            ->getRowArray();

        $namaDesa = $desa['nama_desa'] ?? $idDesa;

        $kelahiran = $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->orderBy('Kelahiran.tgl_lahir', 'DESC')
            ->orderBy('Kelahiran.id_kelahiran', 'DESC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Kelahiran');

        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'DATA KELAHIRAN ANAK');

        $sheet->mergeCells('A2:J2');
        $sheet->setCellValue('A2', 'Desa: ' . $namaDesa);

        $sheet->mergeCells('A3:J3');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d-m-Y H:i'));

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A2:A3')->getFont()->setSize(11);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headerRow = 5;

        $headers = [
            'A' => 'No',
            'B' => 'ID Kelahiran',
            'C' => 'Nama Bayi',
            'D' => 'Jenis Kelamin',
            'E' => 'NIK Ibu',
            'F' => 'Nama Ibu',
            'G' => 'Tempat Lahir',
            'H' => 'Tanggal Lahir',
            'I' => 'Usia',
            'J' => 'Keterangan',
        ];

        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . $headerRow, $header);
        }

        $sheet->getStyle('A5:J5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '26313C'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9E2EC'],
                ],
            ],
        ]);

        $rowNumber = 6;
        $no = 1;

        foreach ($kelahiran as $row) {
            $jenisKelamin = '-';

            if (($row['jenis_kelamin'] ?? '') === 'L') {
                $jenisKelamin = 'Laki-laki';
            } elseif (($row['jenis_kelamin'] ?? '') === 'P') {
                $jenisKelamin = 'Perempuan';
            }

            $usia = '-';

            if (!empty($row['tgl_lahir'])) {
                try {
                    $tanggalLahir = new \DateTime($row['tgl_lahir']);
                    $hariIni = new \DateTime('today');
                    $diff = $hariIni->diff($tanggalLahir);

                    if ($diff->y > 0) {
                        $usia = $diff->y . ' tahun ' . $diff->m . ' bulan';
                    } else {
                        $usia = $diff->m . ' bulan';
                    }
                } catch (\Throwable $e) {
                    $usia = '-';
                }
            }

            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['id_kelahiran'] ?? '-');
            $sheet->setCellValue('C' . $rowNumber, $row['nama_bayi'] ?? '-');
            $sheet->setCellValue('D' . $rowNumber, $jenisKelamin);
            $sheet->setCellValueExplicit('E' . $rowNumber, (string) ($row['nik_ibu'] ?? ''), DataType::TYPE_STRING);
            $sheet->setCellValue('F' . $rowNumber, $row['nama_ibu'] ?? '-');
            $sheet->setCellValue('G' . $rowNumber, $row['tempat_lahir'] ?? '-');
            $sheet->setCellValue('H' . $rowNumber, $row['tgl_lahir'] ?? '-');
            $sheet->setCellValue('I' . $rowNumber, $usia);
            $sheet->setCellValue('J' . $rowNumber, $row['keterangan'] ?? '-');

            $rowNumber++;
        }

        $lastRow = max(5, $rowNumber - 1);

        $sheet->getStyle('A5:J' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9E2EC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A6:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D6:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H6:I' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->freezePane('A6');
        $sheet->setAutoFilter('A5:J' . $lastRow);

        $safeDesaName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower((string) $namaDesa));
        $filename = 'data_kelahiran_' . $safeDesaName . '_' . date('Ymd_His') . '.xlsx';

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}