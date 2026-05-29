<?php

namespace App\Controllers;

use App\Models\KematianModel;
use App\Models\PendudukDesaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class KematianController extends BaseController
{
    protected $kematianModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->kematianModel = new KematianModel();
        $this->pendudukModel = new PendudukDesaModel();
    }

    private function getIdDesa()
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return null;
        }

        return $idDesa;
    }

    private function getWargaDesa($nik, $idDesa)
    {
        return $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();
    }

    // 1. TAMPILKAN DAFTAR KEMATIAN SESUAI DESA USER LOGIN
    public function index()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kematian = $this->kematianModel
            ->where('id_desa', $idDesa)
            ->orderBy('id_kematian', 'DESC')
            ->findAll();

        return view('pkk/kematian/index', [
            'title'    => 'Pencatatan Data Kematian Warga',
            'kematian' => $kematian
        ]);
    }

    // 2. FORM INPUT DATA KEMATIAN
    public function create()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $penduduk = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->orderBy('nama', 'ASC')
            ->findAll();

        return view('pkk/kematian/create', [
            'title'    => 'Input Data Kematian',
            'penduduk' => $penduduk
        ]);
    }

    // 3. SIMPAN DATA KEMATIAN
    public function store()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $rules = [
            'nik'             => 'required',
            'tgl_kematian'    => 'required|valid_date',
            'tempat_kematian' => 'required',
            'keterangan'      => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nik = $this->request->getPost('nik');

        $warga = $this->getWargaDesa($nik, $idDesa);

        if (!$warga) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data warga tidak ditemukan atau bukan penduduk desa Anda.');
        }

        $this->kematianModel->insert([
            'id_desa'         => $idDesa,
            'nik'             => $nik,
            'nama_almarhum'   => $warga['nama'],
            'tgl_kematian'    => $this->request->getPost('tgl_kematian'),
            'tempat_kematian' => $this->request->getPost('tempat_kematian'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ]);

        return redirect()
            ->to('/pkk/kematian')
            ->with('success', 'Data kematian berhasil dicatat.');
    }

    // 4. FORM EDIT DATA KEMATIAN
    public function edit($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kematian = $this->kematianModel
            ->where('id_kematian', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$kematian) {
            return redirect()
                ->to('/pkk/kematian')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        return view('pkk/kematian/edit', [
            'title'    => 'Edit Data Kematian',
            'kematian' => $kematian
        ]);
    }

    // 5. UPDATE DATA KEMATIAN
    public function update($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kematian = $this->kematianModel
            ->where('id_kematian', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$kematian) {
            return redirect()
                ->to('/pkk/kematian')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $rules = [
            'tgl_kematian'    => 'required|valid_date',
            'tempat_kematian' => 'required',
            'keterangan'      => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kematianModel->update($id, [
            'tgl_kematian'    => $this->request->getPost('tgl_kematian'),
            'tempat_kematian' => $this->request->getPost('tempat_kematian'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ]);

        return redirect()
            ->to('/pkk/kematian')
            ->with('success', 'Data kematian berhasil diperbarui.');
    }

    // 6. HAPUS DATA KEMATIAN
    public function delete($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $kematian = $this->kematianModel
            ->where('id_kematian', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$kematian) {
            return redirect()
                ->to('/pkk/kematian')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $this->kematianModel->delete($id);

        return redirect()
            ->to('/pkk/kematian')
            ->with('success', 'Data kematian berhasil dihapus.');
    }

    // 7. EXPORT DATA KEMATIAN KE EXCEL
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

        $kematian = $this->kematianModel
            ->where('id_desa', $idDesa)
            ->orderBy('tgl_kematian', 'DESC')
            ->orderBy('id_kematian', 'DESC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Kematian');

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'DATA KEMATIAN WARGA');

        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Desa: ' . $namaDesa);

        $sheet->mergeCells('A3:G3');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d-m-Y H:i'));

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A2:A3')->getFont()->setSize(11);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headerRow = 5;

        $headers = [
            'A' => 'No',
            'B' => 'ID Kematian',
            'C' => 'NIK',
            'D' => 'Nama Almarhum/ah',
            'E' => 'Tanggal Wafat',
            'F' => 'Tempat Wafat',
            'G' => 'Penyebab / Keterangan',
        ];

        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . $headerRow, $header);
        }

        $sheet->getStyle('A5:G5')->applyFromArray([
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

        foreach ($kematian as $row) {
            $tanggalKematian = '-';

            if (!empty($row['tgl_kematian'])) {
                $tanggalKematian = date('d-m-Y', strtotime($row['tgl_kematian']));
            }

            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['id_kematian'] ?? '-');
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) ($row['nik'] ?? ''), DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_almarhum'] ?? '-');
            $sheet->setCellValue('E' . $rowNumber, $tanggalKematian);
            $sheet->setCellValue('F' . $rowNumber, $row['tempat_kematian'] ?? '-');
            $sheet->setCellValue('G' . $rowNumber, !empty($row['keterangan']) ? $row['keterangan'] : '-');

            $rowNumber++;
        }

        $lastRow = max(5, $rowNumber - 1);

        $sheet->getStyle('A5:G' . $lastRow)->applyFromArray([
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

        if ($lastRow >= 6) {
            $sheet->getStyle('A6:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E6:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->freezePane('A6');
        $sheet->setAutoFilter('A5:G' . $lastRow);

        $safeDesaName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower((string) $namaDesa));
        $filename = 'data_kematian_' . $safeDesaName . '_' . date('Ymd_His') . '.xlsx';

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