<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendudukDesaModel;
use App\Models\KelahiranModel;
use App\Models\KematianModel;
use App\Models\LansiaModel;

class LaporanController extends BaseController
{
    protected $pendudukModel;
    protected $kelahiranModel;
    protected $kematianModel;
    protected $lansiaModel;

    public function __construct()
    {
        $this->pendudukModel  = new PendudukDesaModel();
        $this->kelahiranModel = new KelahiranModel();
        $this->kematianModel  = new KematianModel();
        $this->lansiaModel    = new LansiaModel();
    }

    public function index()
    {
        $idDesa = session()->get('id_desa');

        if (!$idDesa) {
            return redirect()
                ->to(base_url('pkk/dashboard'))
                ->with('error', 'Data desa tidak ditemukan pada session.');
        }

        $bulan = (int) ($this->request->getGet('bulan') ?? date('m'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));
        $rt = trim((string) ($this->request->getGet('rt') ?? ''));

        if ($bulan < 1 || $bulan > 12) {
            $bulan = (int) date('m');
        }

        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = (int) date('Y');
        }

        $namaBulan = $this->getNamaBulan($bulan);
        $namaDesa = $this->getNamaDesaAktif($idDesa);

        $summary = [
            'total_penduduk' => $this->countPenduduk($idDesa, $rt),
            'total_laki_laki' => $this->countPenduduk($idDesa, $rt, 'L'),
            'total_perempuan' => $this->countPenduduk($idDesa, $rt, 'P'),
            'total_kelahiran' => $this->countKelahiran($idDesa, $bulan, $tahun, $rt),
            'total_kematian' => $this->countKematian($idDesa, $bulan, $tahun, $rt),
        ];

        $lansiaData = $this->getLansiaData($idDesa, $rt);

        $summary['total_lansia'] = count($lansiaData);
        $summary['lansia_produktif'] = $this->countStatusLansia($lansiaData, 'produktif');
        $summary['lansia_nonproduktif'] = $this->countStatusLansia($lansiaData, 'non-produktif');

        $data = [
            'title' => 'Laporan Bulanan PKK',
            'nama_desa' => $namaDesa,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'rt' => $rt,
            'nama_bulan' => $namaBulan,
            'bulan_list' => $this->getBulanList(),
            'tahun_list' => $this->getTahunList(),
            'rt_list' => $this->getRtList($idDesa),
            'summary' => $summary,
            'rekap_rt' => $this->getRekapRt($idDesa, $rt),
            'kelahiran' => $this->getDataKelahiran($idDesa, $bulan, $tahun, $rt),
            'kematian' => $this->getDataKematian($idDesa, $bulan, $tahun, $rt),
            'lansia' => $lansiaData,
            'chart_summary' => [
                'labels' => ['Penduduk', 'Kelahiran', 'Kematian', 'Lansia'],
                'data' => [
                    $summary['total_penduduk'],
                    $summary['total_kelahiran'],
                    $summary['total_kematian'],
                    $summary['total_lansia'],
                ],
            ],
            'chart_lansia' => [
                'labels' => ['Produktif', 'Nonproduktif'],
                'data' => [
                    $summary['lansia_produktif'],
                    $summary['lansia_nonproduktif'],
                ],
            ],
        ];

        return view('pkk/laporan/index', $data);
    }

    public function exportExcel()
    {
        $idDesa = session()->get('id_desa');

        if (!$idDesa) {
            return redirect()
                ->to(base_url('pkk/dashboard'))
                ->with('error', 'Data desa tidak ditemukan pada session.');
        }

        $bulan = (int) ($this->request->getGet('bulan') ?? date('m'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));
        $rt = trim((string) ($this->request->getGet('rt') ?? ''));

        if ($bulan < 1 || $bulan > 12) {
            $bulan = (int) date('m');
        }

        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = (int) date('Y');
        }

        $namaDesa = $this->getNamaDesaAktif($idDesa);
        $namaBulan = $this->getNamaBulan($bulan);
        $wilayah = $rt !== '' ? 'RT ' . $rt : 'Semua RT';

        $judulLaporan = 'LAPORAN BULANAN PKK DESA';
        if ($namaDesa !== '') {
            $judulLaporan .= ' ' . strtoupper($namaDesa);
        }

        $summary = [
            'total_penduduk' => $this->countPenduduk($idDesa, $rt),
            'total_laki_laki' => $this->countPenduduk($idDesa, $rt, 'L'),
            'total_perempuan' => $this->countPenduduk($idDesa, $rt, 'P'),
            'total_kelahiran' => $this->countKelahiran($idDesa, $bulan, $tahun, $rt),
            'total_kematian' => $this->countKematian($idDesa, $bulan, $tahun, $rt),
        ];

        $lansiaData = $this->getLansiaData($idDesa, $rt);

        $summary['total_lansia'] = count($lansiaData);
        $summary['lansia_produktif'] = $this->countStatusLansia($lansiaData, 'produktif');
        $summary['lansia_nonproduktif'] = $this->countStatusLansia($lansiaData, 'non-produktif');

        $rekapRt = $this->getRekapRt($idDesa, $rt);
        $kelahiran = $this->getDataKelahiran($idDesa, $bulan, $tahun, $rt);
        $kematian = $this->getDataKematian($idDesa, $bulan, $tahun, $rt);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $spreadsheet->getProperties()
            ->setCreator('Sistem PKK Desa')
            ->setTitle('Laporan Bulanan PKK')
            ->setSubject('Laporan Bulanan PKK')
            ->setDescription('Laporan bulanan data PKK desa.');

        // ==================================================
        // SHEET 1: RINGKASAN
        // ==================================================
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ringkasan');

        $sheet->setCellValue('A1', $judulLaporan);
        $sheet->setCellValue('A3', 'Desa');
        $sheet->setCellValue('B3', $namaDesa !== '' ? $namaDesa : '-');
        $sheet->setCellValue('A4', 'Periode');
        $sheet->setCellValue('B4', $namaBulan . ' ' . $tahun);
        $sheet->setCellValue('A5', 'Wilayah');
        $sheet->setCellValue('B5', $wilayah);
        $sheet->setCellValue('A6', 'Tanggal Export');
        $sheet->setCellValue('B6', date('d-m-Y H:i'));

        $sheet->setCellValue('A8', 'Kategori');
        $sheet->setCellValue('B8', 'Jumlah');

        $ringkasanRows = [
            ['Total Penduduk', $summary['total_penduduk']],
            ['Penduduk Laki-laki', $summary['total_laki_laki']],
            ['Penduduk Perempuan', $summary['total_perempuan']],
            ['Kelahiran Bulan Ini', $summary['total_kelahiran']],
            ['Kematian Bulan Ini', $summary['total_kematian']],
            ['Total Lansia', $summary['total_lansia']],
            ['Lansia Produktif', $summary['lansia_produktif']],
            ['Lansia Nonproduktif', $summary['lansia_nonproduktif']],
        ];

        $row = 9;
        foreach ($ringkasanRows as $item) {
            $sheet->setCellValue('A' . $row, $item[0]);
            $sheet->setCellValue('B' . $row, $item[1]);
            $row++;
        }

        $this->styleSheet($sheet, 'A1:B' . ($row - 1), 'A1:B1', 'A8:B8');

        // ==================================================
        // SHEET 2: REKAP RT
        // ==================================================
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Rekap RT');

        $sheet->fromArray([
            ['RT', 'Laki-laki', 'Perempuan', 'Total']
        ], null, 'A1');

        $row = 2;
        foreach ($rekapRt as $item) {
            $sheet->setCellValue('A' . $row, 'RT ' . ($item['RT'] ?? '-'));
            $sheet->setCellValue('B' . $row, (int) ($item['laki_laki'] ?? 0));
            $sheet->setCellValue('C' . $row, (int) ($item['perempuan'] ?? 0));
            $sheet->setCellValue('D' . $row, (int) ($item['total'] ?? 0));
            $row++;
        }

        $this->styleSheet($sheet, 'A1:D' . max($row - 1, 1), null, 'A1:D1');

        // ==================================================
        // SHEET 3: KELAHIRAN
        // ==================================================
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Kelahiran');

        $sheet->fromArray([
            ['No', 'Nama Bayi', 'Nama Ibu', 'Jenis Kelamin', 'RT', 'Tanggal Lahir', 'Tempat Lahir', 'Keterangan']
        ], null, 'A1');

        $row = 2;
        foreach ($kelahiran as $i => $item) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $item['nama_bayi'] ?? '-');
            $sheet->setCellValue('C' . $row, $item['nama_ibu'] ?? '-');
            $sheet->setCellValue('D' . $row, $item['jenis_kelamin'] ?? '-');
            $sheet->setCellValue('E' . $row, $item['RT'] ?? '-');
            $sheet->setCellValue('F' . $row, $this->formatTanggalExcel($item['tgl_lahir'] ?? null));
            $sheet->setCellValue('G' . $row, $item['tempat_lahir'] ?? '-');
            $sheet->setCellValue('H' . $row, $item['keterangan'] ?? '-');
            $row++;
        }

        $this->styleSheet($sheet, 'A1:H' . max($row - 1, 1), null, 'A1:H1');

        // ==================================================
        // SHEET 4: KEMATIAN
        // ==================================================
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Kematian');

        $sheet->fromArray([
            ['No', 'Nama Almarhum/ah', 'NIK', 'RT', 'Tanggal Kematian', 'Tempat Kematian', 'Keterangan']
        ], null, 'A1');

        $row = 2;
        foreach ($kematian as $i => $item) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValueExplicit('B' . $row, $item['nama_almarhum'] ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $row, $item['nik'] ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $item['RT'] ?? '-');
            $sheet->setCellValue('E' . $row, $this->formatTanggalExcel($item['tgl_kematian'] ?? null));
            $sheet->setCellValue('F' . $row, $item['tempat_kematian'] ?? '-');
            $sheet->setCellValue('G' . $row, $item['keterangan'] ?? '-');
            $row++;
        }

        $this->styleSheet($sheet, 'A1:G' . max($row - 1, 1), null, 'A1:G1');

        // ==================================================
        // SHEET 5: LANSIA
        // ==================================================
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Lansia');

        $sheet->fromArray([
            ['No', 'Nama Lansia', 'NIK', 'RT', 'Umur', 'Produktivitas', 'Hobi', 'Keterangan']
        ], null, 'A1');

        $row = 2;
        foreach ($lansiaData as $i => $item) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $item['nama_lansia'] ?? '-');
            $sheet->setCellValueExplicit('C' . $row, $item['nik'] ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $item['RT'] ?? '-');
            $sheet->setCellValue('E' . $row, $item['umur_lansia'] ?? '-');
            $sheet->setCellValue('F' . $row, $item['produktifitas'] ?? '-');
            $sheet->setCellValue('G' . $row, $item['hobi'] ?? '-');
            $sheet->setCellValue('H' . $row, $item['keterangan'] ?? '-');
            $row++;
        }

        $this->styleSheet($sheet, 'A1:H' . max($row - 1, 1), null, 'A1:H1');

        $spreadsheet->setActiveSheetIndex(0);

        $namaFileDesa = $namaDesa !== '' ? strtolower($namaDesa) : 'desa';
        $namaFileDesa = preg_replace('/[^a-z0-9]+/i', '_', $namaFileDesa);
        $namaFileDesa = trim($namaFileDesa, '_');

        $filename = 'laporan_pkk_' . $namaFileDesa . '_' . strtolower($namaBulan) . '_' . $tahun;

        if ($rt !== '') {
            $filename .= '_rt_' . $rt;
        }

        $filename .= '.xlsx';

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($excelOutput);
    }

    private function countPenduduk(string $idDesa, string $rt = '', ?string $jenisKelamin = null): int
    {
        $query = $this->pendudukModel
            ->where('id_desa', $idDesa);

        if ($rt !== '') {
            $query->where('RT', $rt);
        }

        if ($jenisKelamin !== null) {
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        return $query->countAllResults();
    }

    private function countKelahiran(string $idDesa, int $bulan, int $tahun, string $rt = ''): int
    {
        $query = $this->kelahiranModel
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->where('MONTH(Kelahiran.tgl_lahir)', $bulan, false)
            ->where('YEAR(Kelahiran.tgl_lahir)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query->countAllResults();
    }

    private function countKematian(string $idDesa, int $bulan, int $tahun, string $rt = ''): int
    {
        $query = $this->kematianModel
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kematian.nik AND PendudukDesa.id_desa = Kematian.id_desa',
                'left'
            )
            ->where('Kematian.id_desa', $idDesa)
            ->where('MONTH(Kematian.tgl_kematian)', $bulan, false)
            ->where('YEAR(Kematian.tgl_kematian)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query->countAllResults();
    }

    private function getDataKelahiran(string $idDesa, int $bulan, int $tahun, string $rt = ''): array
    {
        $query = $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu, PendudukDesa.RT')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->where('MONTH(Kelahiran.tgl_lahir)', $bulan, false)
            ->where('YEAR(Kelahiran.tgl_lahir)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query
            ->orderBy('Kelahiran.tgl_lahir', 'ASC')
            ->findAll();
    }

    private function getDataKematian(string $idDesa, int $bulan, int $tahun, string $rt = ''): array
    {
        $query = $this->kematianModel
            ->select('Kematian.*, PendudukDesa.RT')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kematian.nik AND PendudukDesa.id_desa = Kematian.id_desa',
                'left'
            )
            ->where('Kematian.id_desa', $idDesa)
            ->where('MONTH(Kematian.tgl_kematian)', $bulan, false)
            ->where('YEAR(Kematian.tgl_kematian)', $tahun, false);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query
            ->orderBy('Kematian.tgl_kematian', 'ASC')
            ->findAll();
    }

    private function getLansiaData(string $idDesa, string $rt = ''): array
    {
        $query = $this->lansiaModel
            ->select('Lansia.*, PendudukDesa.RT')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Lansia.nik AND PendudukDesa.id_desa = Lansia.id_desa',
                'left'
            )
            ->where('Lansia.id_desa', $idDesa);

        if ($rt !== '') {
            $query->where('PendudukDesa.RT', $rt);
        }

        return $query
            ->orderBy('Lansia.nama_lansia', 'ASC')
            ->findAll();
    }

    private function getRekapRt(string $idDesa, string $rt = ''): array
    {
        $query = $this->pendudukModel
            ->select("
                RT,
                SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS perempuan,
                COUNT(*) AS total
            ", false)
            ->where('id_desa', $idDesa);

        if ($rt !== '') {
            $query->where('RT', $rt);
        }

        return $query
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->findAll();
    }

    private function getRtList(string $idDesa): array
    {
        return $this->pendudukModel
            ->select('RT')
            ->where('id_desa', $idDesa)
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->findAll();
    }

    private function countStatusLansia(array $data, string $target): int
    {
        $count = 0;

        foreach ($data as $row) {
            $status = strtolower(trim((string) ($row['produktifitas'] ?? '')));
            $status = str_replace(['_', ' '], '-', $status);

            if ($target === 'produktif' && $status === 'produktif') {
                $count++;
            }

            if ($target === 'non-produktif' && ($status === 'non-produktif' || $status === 'nonproduktif')) {
                $count++;
            }
        }

        return $count;
    }

    private function getBulanList(): array
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    private function getNamaBulan(int $bulan): string
    {
        $list = $this->getBulanList();

        return $list[$bulan] ?? '-';
    }

    private function getTahunList(): array
    {
        $now = (int) date('Y');
        $years = [];

        for ($year = $now - 3; $year <= $now + 1; $year++) {
            $years[] = $year;
        }

        return $years;
    }

    private function styleSheet($sheet, string $range, ?string $titleRange = null, ?string $headerRange = null): void
    {
        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getStyle($range)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle($range)->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ->getColor()->setARGB('FFD9E2EC');

        if ($titleRange) {
            $sheet->mergeCells($titleRange);
            $sheet->getStyle($titleRange)->getFont()
                ->setBold(true)
                ->setSize(14)
                ->getColor()->setARGB('FF0F172A');

            $sheet->getStyle($titleRange)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        if ($headerRange) {
            $sheet->getStyle($headerRange)->getFont()
                ->setBold(true)
                ->getColor()->setARGB('FFFFFFFF');

            $sheet->getStyle($headerRange)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF26313C');

            $sheet->getStyle($headerRange)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }
    }

    private function formatTanggalExcel($date): string
    {
        if (empty($date)) {
            return '-';
        }

        return date('d-m-Y', strtotime($date));
    }

    private function getNamaDesaAktif(?string $idDesa = null): string
    {
        /*
         * Ambil dari session terlebih dahulu.
         * Kolom wilayah dimasukkan karena di tabel akun kamu
         * nama desa tampil pada kolom Wilayah.
         */
        $sessionCandidates = [
            session()->get('wilayah'),
            session()->get('nama_wilayah'),
            session()->get('nama_desa'),
            session()->get('desa'),
            session()->get('nama_kelurahan'),
            session()->get('kelurahan'),
            session()->get('desa_kelurahan'),
            session()->get('domisili'),
            session()->get('domisili_desa'),
            session()->get('nama_domisili'),
        ];

        foreach ($sessionCandidates as $value) {
            $value = $this->bersihkanNamaDesa((string) $value);

            if ($this->isNamaDesaValid($value)) {
                return $value;
            }
        }

        /*
         * Kalau session belum ada, cari di semua tabel yang punya id_desa.
         * Ini dibuat fleksibel supaya tetap jalan walaupun nama tabel akun berbeda.
         */
        try {
            $db = \Config\Database::connect();

            $nameColumns = [
                'wilayah',
                'nama_wilayah',
                'nama_desa',
                'desa',
                'nama_kelurahan',
                'kelurahan',
                'desa_kelurahan',
                'domisili',
                'domisili_desa',
                'nama_domisili',
            ];

            foreach ($db->listTables() as $table) {
                if (!$db->fieldExists('id_desa', $table)) {
                    continue;
                }

                $row = $db->table($table)
                    ->where('id_desa', $idDesa)
                    ->get()
                    ->getRowArray();

                if (!$row) {
                    continue;
                }

                foreach ($nameColumns as $column) {
                    if (!array_key_exists($column, $row)) {
                        continue;
                    }

                    $value = $this->bersihkanNamaDesa((string) $row[$column]);

                    if ($this->isNamaDesaValid($value)) {
                        return $value;
                    }
                }
            }
        } catch (\Throwable $e) {
            /*
             * Jika gagal membaca database, laporan tetap berjalan.
             */
        }

        return '';
    }

    private function bersihkanNamaDesa(string $value): string
    {
        $value = trim($value);

        /*
         * Kalau isi kolomnya "Desa Sukamaju",
         * hasilnya dibuat "Sukamaju" supaya tidak menjadi:
         * "Laporan Bulanan PKK Desa Desa Sukamaju".
         */
        $value = preg_replace('/ID\s*Desa\s*:.*$/i', '', $value);
        $value = preg_replace('/\bDESA[0-9]+\b/i', '', $value);
        $value = preg_replace('/^desa\s+/i', '', $value);

        return trim((string) $value);
    }

    private function isNamaDesaValid(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        if (preg_match('/^DESA[0-9]+$/i', $value)) {
            return false;
        }

        if (preg_match('/^[0-9]+$/', $value)) {
            return false;
        }

        return true;
    }
}