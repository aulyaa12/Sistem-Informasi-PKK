<?php

namespace App\Controllers;

use App\Models\LansiaModel;
use App\Models\PendudukDesaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class LansiaController extends BaseController
{
    protected $lansiaModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->lansiaModel   = new LansiaModel();
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

    private function hitungUmur($tglLahir)
    {
        if (empty($tglLahir)) {
            return 0;
        }

        try {
            $birthDate = new \DateTime($tglLahir);
            $today     = new \DateTime('today');

            return $birthDate->diff($today)->y;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    // 1. DAFTAR LANSIA SESUAI DESA USER LOGIN
    public function index()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $lansia = $this->lansiaModel
            ->select('
                Lansia.*,
                Lansia.produktifitas AS produktivitas,
                TIMESTAMPDIFF(YEAR, PendudukDesa.tgl_lahir, CURDATE()) AS umur
            ', false)
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Lansia.nik AND PendudukDesa.id_desa = Lansia.id_desa',
                'left'
            )
            ->where('Lansia.id_desa', $idDesa)
            ->orderBy('Lansia.id_lansia', 'DESC')
            ->findAll();

        return view('pkk/lansia/index', [
            'title'  => 'Data Pemantauan Lansia Desa',
            'lansia' => $lansia
        ]);
    }

    // 2. FORM TAMBAH DATA LANSIA
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

        return view('pkk/lansia/create', [
            'title'    => 'Catat Data Lansia Baru',
            'penduduk' => $penduduk
        ]);
    }

    // 3. SIMPAN DATA LANSIA
    public function store()
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $rules = [
            'nik'           => 'required',
            'hobi'          => 'required',
            'produktivitas' => 'required',
            'keterangan'    => 'permit_empty',
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
                ->with('error', 'Warga tidak ditemukan atau bukan penduduk desa Anda.');
        }

        $sudahTerdaftar = $this->lansiaModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if ($sudahTerdaftar) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Warga ini sudah tercatat dalam data lansia.');
        }

        $umurLansia = $this->hitungUmur($warga['tgl_lahir'] ?? null);

        $this->lansiaModel->insert([
            'id_desa'       => $idDesa,
            'nik'           => $nik,
            'nama_lansia'   => $warga['nama'] ?? $warga['nama_penduduk'] ?? '',
            'umur_lansia'   => $umurLansia,
            'produktifitas' => $this->request->getPost('produktivitas'),
            'hobi'          => $this->request->getPost('hobi'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ]);

        return redirect()
            ->to('/pkk/lansia')
            ->with('success', 'Data pemantauan lansia berhasil ditambahkan.');
    }

    // 4. FORM EDIT DATA LANSIA
    public function edit($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $lansia = $this->lansiaModel
            ->select('Lansia.*, Lansia.produktifitas AS produktivitas')
            ->where('Lansia.id_lansia', $id)
            ->where('Lansia.id_desa', $idDesa)
            ->first();

        if (!$lansia) {
            return redirect()
                ->to('/pkk/lansia')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        return view('pkk/lansia/edit', [
            'title'  => 'Edit Data Pemantauan Lansia',
            'lansia' => $lansia
        ]);
    }

    // 5. UPDATE DATA LANSIA
    public function update($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $lansia = $this->lansiaModel
            ->where('id_lansia', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$lansia) {
            return redirect()
                ->to('/pkk/lansia')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $rules = [
            'hobi'          => 'required',
            'produktivitas' => 'required',
            'keterangan'    => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->lansiaModel->update($id, [
            'hobi'          => $this->request->getPost('hobi'),
            'produktifitas' => $this->request->getPost('produktivitas'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ]);

        return redirect()
            ->to('/pkk/lansia')
            ->with('success', 'Data lansia berhasil diperbarui.');
    }

    // 6. HAPUS DATA LANSIA
    public function delete($id)
    {
        $idDesa = $this->getIdDesa();

        if (!$idDesa) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $lansia = $this->lansiaModel
            ->where('id_lansia', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$lansia) {
            return redirect()
                ->to('/pkk/lansia')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $this->lansiaModel->delete($id);

        return redirect()
            ->to('/pkk/lansia')
            ->with('success', 'Data lansia berhasil dihapus dari daftar pemantauan.');
    }

    // 7. EXPORT DATA LANSIA KE EXCEL
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

        $lansia = $this->lansiaModel
            ->select('
                Lansia.*,
                Lansia.produktifitas AS produktivitas,
                TIMESTAMPDIFF(YEAR, PendudukDesa.tgl_lahir, CURDATE()) AS umur
            ', false)
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Lansia.nik AND PendudukDesa.id_desa = Lansia.id_desa',
                'left'
            )
            ->where('Lansia.id_desa', $idDesa)
            ->orderBy('Lansia.id_lansia', 'DESC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Lansia');

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'DATA PEMANTAUAN LANSIA');

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Desa: ' . $namaDesa);

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d-m-Y H:i'));

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A2:A3')->getFont()->setSize(11);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headerRow = 5;

        $headers = [
            'A' => 'No',
            'B' => 'ID Lansia',
            'C' => 'NIK',
            'D' => 'Nama Lansia',
            'E' => 'Umur',
            'F' => 'Hobi',
            'G' => 'Produktivitas',
            'H' => 'Catatan / Keterangan',
        ];

        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . $headerRow, $header);
        }

        $sheet->getStyle('A5:H5')->applyFromArray([
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

        foreach ($lansia as $row) {
            $umur = '-';

            if (isset($row['umur']) && $row['umur'] !== '' && $row['umur'] !== null) {
                $umur = $row['umur'] . ' tahun';
            } elseif (isset($row['umur_lansia']) && $row['umur_lansia'] !== '' && $row['umur_lansia'] !== null) {
                $umur = $row['umur_lansia'] . ' tahun';
            }

            $produktivitas = $row['produktivitas'] ?? $row['produktifitas'] ?? 'Non-Produktif';

            if (strtolower((string) $produktivitas) === 'produktif') {
                $produktivitas = 'Produktif';
            } else {
                $produktivitas = 'Non-Produktif';
            }

            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['id_lansia'] ?? '-');
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) ($row['nik'] ?? ''), DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_lansia'] ?? '-');
            $sheet->setCellValue('E' . $rowNumber, $umur);
            $sheet->setCellValue('F' . $rowNumber, $row['hobi'] ?? '-');
            $sheet->setCellValue('G' . $rowNumber, $produktivitas);
            $sheet->setCellValue('H' . $rowNumber, !empty($row['keterangan']) ? $row['keterangan'] : '-');

            $rowNumber++;
        }

        $lastRow = max(5, $rowNumber - 1);

        $sheet->getStyle('A5:H' . $lastRow)->applyFromArray([
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
            $sheet->getStyle('G6:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->freezePane('A6');
        $sheet->setAutoFilter('A5:H' . $lastRow);

        $safeDesaName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower((string) $namaDesa));
        $filename = 'data_lansia_' . $safeDesaName . '_' . date('Ymd_His') . '.xlsx';

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