<?php

namespace App\Controllers;

use App\Models\PendudukDesaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PendudukController extends BaseController
{
    protected $pendudukModel;

    public function __construct()
    {
        $this->pendudukModel = new PendudukDesaModel();
    }

    // 1. TAMPILKAN DATA PENDUDUK SESUAI DESA USER LOGIN
    public function index()
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $keyword = trim((string) $this->request->getGet('keyword'));
        $rt      = trim((string) $this->request->getGet('rt'));
        $jk      = trim((string) $this->request->getGet('jenis_kelamin'));

        $this->pendudukModel->where('id_desa', $idDesa);

        if ($keyword !== '') {
            $this->pendudukModel->groupStart()
                ->like('nama', $keyword)
                ->orLike('nik', $keyword)
                ->orLike('no_kk', $keyword)
                ->groupEnd();
        }

        if ($rt !== '') {
            $this->pendudukModel->where('RT', $rt);
        }

        if ($jk !== '') {
            $this->pendudukModel->where('jenis_kelamin', $jk);
        }

        $data = [
            'title'       => 'Daftar Penduduk Desa',
            'penduduk'    => $this->pendudukModel->paginate(10, 'penduduk'),
            'pager'       => $this->pendudukModel->pager,
            'keyword'     => $keyword,
            'rt_terpilih' => $rt,
            'jk_terpilih' => $jk,
        ];

        return view('pkk/penduduk/index', $data);
    }

    // 2. FORM TAMBAH PENDUDUK
    public function create()
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        return view('pkk/penduduk/create', [
            'title' => 'Tambah Data Penduduk Baru'
        ]);
    }

    // 3. SIMPAN DATA PENDUDUK BARU
    public function store()
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $rules = [
            'nik'               => 'required|numeric|exact_length[16]|is_unique[PendudukDesa.nik]',
            'no_kk'             => 'required|numeric|exact_length[16]',
            'nama'              => 'required|min_length[3]',
            'jenis_kelamin'     => 'required|in_list[L,P]',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|valid_date',
            'alamat'            => 'required',
            'RT'                => 'required|numeric',
            'pekerjaan'         => 'required',
            'status_pernikahan' => 'required',
            'pendidikan'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->pendudukModel->insert([
            'nik'               => $this->request->getPost('nik'),
            'id_desa'           => $idDesa,
            'no_kk'             => $this->request->getPost('no_kk'),
            'nama'              => $this->request->getPost('nama'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir'      => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'         => $this->request->getPost('tgl_lahir'),
            'alamat'            => $this->request->getPost('alamat'),
            'RT'                => $this->request->getPost('RT'),
            'pekerjaan'         => $this->request->getPost('pekerjaan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'pendidikan'        => $this->request->getPost('pendidikan'),
        ]);

        return redirect()
            ->to('/pkk/penduduk')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    // 4. DETAIL PENDUDUK
    public function detail($nik)
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $warga = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$warga) {
            return redirect()
                ->to('/pkk/penduduk')
                ->with('error', 'Data penduduk tidak ditemukan atau Anda tidak memiliki akses.');
        }

        return view('pkk/penduduk/detail', [
            'title' => 'Detail Profil: ' . $warga['nama'],
            'warga' => $warga
        ]);
    }

    // 5. FORM EDIT PENDUDUK
    public function edit($nik)
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $penduduk = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$penduduk) {
            return redirect()
                ->to('/pkk/penduduk')
                ->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        return view('pkk/penduduk/edit', [
            'title'    => 'Edit Data Penduduk',
            'penduduk' => $penduduk
        ]);
    }

    // 6. UPDATE DATA PENDUDUK
    public function update($nik)
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $penduduk = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$penduduk) {
            return redirect()
                ->to('/pkk/penduduk')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $rules = [
            'no_kk'             => 'required|numeric|exact_length[16]',
            'nama'              => 'required|min_length[3]',
            'jenis_kelamin'     => 'required|in_list[L,P]',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|valid_date',
            'alamat'            => 'required',
            'RT'                => 'required|numeric',
            'pekerjaan'         => 'required',
            'status_pernikahan' => 'required',
            'pendidikan'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->pendudukModel->update($nik, [
            'no_kk'             => $this->request->getPost('no_kk'),
            'nama'              => $this->request->getPost('nama'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir'      => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'         => $this->request->getPost('tgl_lahir'),
            'alamat'            => $this->request->getPost('alamat'),
            'RT'                => $this->request->getPost('RT'),
            'pekerjaan'         => $this->request->getPost('pekerjaan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'pendidikan'        => $this->request->getPost('pendidikan'),
        ]);

        return redirect()
            ->to('/pkk/penduduk')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    // 7. HAPUS DATA PENDUDUK
    public function delete($nik)
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $penduduk = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$penduduk) {
            return redirect()
                ->to('/pkk/penduduk')
                ->with('error', 'Data tidak ditemukan atau akses ditolak.');
        }

        $this->pendudukModel->delete($nik);

        return redirect()
            ->to('/pkk/penduduk')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    // 8. EXPORT DATA PENDUDUK KE EXCEL
    public function export()
    {
        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
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

        $penduduk = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->orderBy('RT', 'ASC')
            ->orderBy('nama', 'ASC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penduduk');

        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'DATA PENDUDUK DESA');

        $sheet->mergeCells('A2:M2');
        $sheet->setCellValue('A2', 'Desa: ' . $namaDesa);

        $sheet->mergeCells('A3:M3');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d-m-Y H:i'));

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A2:A3')->getFont()->setSize(11);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headerRow = 5;

        $headers = [
            'A' => 'No',
            'B' => 'NIK',
            'C' => 'No. KK',
            'D' => 'Nama Lengkap',
            'E' => 'Jenis Kelamin',
            'F' => 'Tempat Lahir',
            'G' => 'Tanggal Lahir',
            'H' => 'Usia',
            'I' => 'Alamat',
            'J' => 'RT',
            'K' => 'Pekerjaan',
            'L' => 'Status Pernikahan',
            'M' => 'Pendidikan',
        ];

        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . $headerRow, $header);
        }

        $sheet->getStyle('A5:M5')->applyFromArray([
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

        foreach ($penduduk as $row) {
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
                    $usia = $hariIni->diff($tanggalLahir)->y . ' tahun';
                } catch (\Throwable $e) {
                    $usia = '-';
                }
            }

            $statusPernikahan = ucwords(str_replace('_', ' ', $row['status_pernikahan'] ?? '-'));

            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValueExplicit('B' . $rowNumber, (string) ($row['nik'] ?? ''), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) ($row['no_kk'] ?? ''), DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama'] ?? '-');
            $sheet->setCellValue('E' . $rowNumber, $jenisKelamin);
            $sheet->setCellValue('F' . $rowNumber, $row['tempat_lahir'] ?? '-');
            $sheet->setCellValue('G' . $rowNumber, $row['tgl_lahir'] ?? '-');
            $sheet->setCellValue('H' . $rowNumber, $usia);
            $sheet->setCellValue('I' . $rowNumber, $row['alamat'] ?? '-');
            $sheet->setCellValue('J' . $rowNumber, $row['RT'] ?? '-');
            $sheet->setCellValue('K' . $rowNumber, $row['pekerjaan'] ?? '-');
            $sheet->setCellValue('L' . $rowNumber, $statusPernikahan);
            $sheet->setCellValue('M' . $rowNumber, $row['pendidikan'] ?? '-');

            $rowNumber++;
        }

        $lastRow = max(5, $rowNumber - 1);

        $sheet->getStyle('A5:M' . $lastRow)->applyFromArray([
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

        $sheet->getStyle('A6:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E6:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G6:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J6:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->freezePane('A6');
        $sheet->setAutoFilter('A5:M' . $lastRow);

        $safeDesaName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower((string) $namaDesa));
        $filename = 'data_penduduk_' . $safeDesaName . '_' . date('Ymd_His') . '.xlsx';

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