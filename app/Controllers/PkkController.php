<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PkkController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $desa = $db->table('desa')
            ->where('id_desa', $idDesa)
            ->get()
            ->getRowArray();

        $totalPenduduk = $db->table('PendudukDesa')
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $totalLakiLaki = $db->table('PendudukDesa')
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'L')
            ->countAllResults();

        $totalPerempuan = $db->table('PendudukDesa')
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->countAllResults();

        $totalKelahiran = $db->table('Kelahiran')
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $kelahiranLakiLaki = $db->table('Kelahiran')
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'L')
            ->countAllResults();

        $kelahiranPerempuan = $db->table('Kelahiran')
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->countAllResults();

        $totalKematian = $db->table('Kematian')
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $totalLansia = $db->table('Lansia')
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $totalLansiaProduktif = $db->table('Lansia')
            ->where('id_desa', $idDesa)
            ->where("LOWER(produktifitas) = 'produktif'", null, false)
            ->countAllResults();

        $totalLansiaNonProduktif = max(0, $totalLansia - $totalLansiaProduktif);

        $pendudukPerRtRows = $db->table('PendudukDesa')
            ->select('RT, COUNT(*) AS total')
            ->where('id_desa', $idDesa)
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->get()
            ->getResultArray();

        $labelRt = [];
        $dataRt  = [];

        foreach ($pendudukPerRtRows as $row) {
            $labelRt[] = 'RT ' . ($row['RT'] ?? '-');
            $dataRt[]  = (int) ($row['total'] ?? 0);
        }

        $pendidikanRows = $db->table('PendudukDesa')
            ->select('pendidikan, COUNT(*) AS total')
            ->where('id_desa', $idDesa)
            ->groupBy('pendidikan')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();

        $labelPendidikan = [];
        $dataPendidikan  = [];

        foreach ($pendidikanRows as $row) {
            $labelPendidikan[] = $row['pendidikan'] ?: 'Tidak Diisi';
            $dataPendidikan[]  = (int) ($row['total'] ?? 0);
        }

        $data = [
            'title' => 'Dashboard Ketua PKK',

            'id_desa'   => $idDesa,
            'nama_desa' => $desa['nama_desa'] ?? 'Desa Belum Diketahui',

            'total_penduduk' => $totalPenduduk,
            'total_laki_laki' => $totalLakiLaki,
            'total_perempuan' => $totalPerempuan,

            'total_kelahiran' => $totalKelahiran,
            'kelahiran_laki_laki' => $kelahiranLakiLaki,
            'kelahiran_perempuan' => $kelahiranPerempuan,

            'total_kematian' => $totalKematian,

            'total_lansia' => $totalLansia,
            'total_lansia_produktif' => $totalLansiaProduktif,
            'total_lansia_nonproduktif' => $totalLansiaNonProduktif,

            'chart_gender' => [
                'labels' => ['Laki-laki', 'Perempuan'],
                'data'   => [$totalLakiLaki, $totalPerempuan],
            ],

            'chart_kelahiran' => [
                'labels' => ['Laki-laki', 'Perempuan'],
                'data'   => [$kelahiranLakiLaki, $kelahiranPerempuan],
            ],

            'chart_lansia' => [
                'labels' => ['Produktif', 'Nonproduktif'],
                'data'   => [$totalLansiaProduktif, $totalLansiaNonProduktif],
            ],

            'chart_rt' => [
                'labels' => $labelRt,
                'data'   => $dataRt,
            ],

            'chart_pendidikan' => [
                'labels' => $labelPendidikan,
                'data'   => $dataPendidikan,
            ],
        ];

        return view('pkk/dashboard', $data);
    }

    public function exportAll()
    {
        $db = \Config\Database::connect();

        $idDesa = session()->get('id_desa');

        if (empty($idDesa)) {
            return redirect()
                ->to('/login')
                ->with('error', 'Sesi wilayah tidak ditemukan. Silakan login ulang.');
        }

        $desa = $db->table('desa')
            ->where('id_desa', $idDesa)
            ->get()
            ->getRowArray();

        $namaDesa = $desa['nama_desa'] ?? $idDesa;

        $spreadsheet = new Spreadsheet();

        $this->sheetPenduduk($spreadsheet->getActiveSheet(), $db, $idDesa, $namaDesa);
        $this->sheetKelahiran($spreadsheet->createSheet(), $db, $idDesa, $namaDesa);
        $this->sheetKematian($spreadsheet->createSheet(), $db, $idDesa, $namaDesa);
        $this->sheetLansia($spreadsheet->createSheet(), $db, $idDesa, $namaDesa);

        $spreadsheet->setActiveSheetIndex(0);

        $safeDesaName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower((string) $namaDesa));
        $filename = 'semua_data_desa_' . $safeDesaName . '_' . date('Ymd_His') . '.xlsx';

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

    private function sheetPenduduk($sheet, $db, $idDesa, $namaDesa)
    {
        $sheet->setTitle('Data Penduduk');

        $data = $db->table('PendudukDesa')
            ->where('id_desa', $idDesa)
            ->orderBy('RT', 'ASC')
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        $this->setTitle($sheet, 'DATA PENDUDUK DESA', $namaDesa, 'A1:M1', 'A2:M2', 'A3:M3');

        $headers = [
            'No', 'NIK', 'No. KK', 'Nama Lengkap', 'Jenis Kelamin',
            'Tempat Lahir', 'Tanggal Lahir', 'Usia', 'Alamat', 'RT',
            'Pekerjaan', 'Status Pernikahan', 'Pendidikan'
        ];

        $this->setHeader($sheet, $headers, 5);

        $rowNumber = 6;
        $no = 1;

        foreach ($data as $row) {
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
            $sheet->setCellValue('L' . $rowNumber, ucwords(str_replace('_', ' ', $row['status_pernikahan'] ?? '-')));
            $sheet->setCellValue('M' . $rowNumber, $row['pendidikan'] ?? '-');

            $rowNumber++;
        }

        $this->finishSheet($sheet, 'A', 'M', $rowNumber);
    }

    private function sheetKelahiran($sheet, $db, $idDesa, $namaDesa)
    {
        $sheet->setTitle('Data Kelahiran');

        $data = $db->table('Kelahiran')
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->orderBy('Kelahiran.tgl_lahir', 'DESC')
            ->get()
            ->getResultArray();

        $this->setTitle($sheet, 'DATA KELAHIRAN ANAK', $namaDesa, 'A1:J1', 'A2:J2', 'A3:J3');

        $headers = [
            'No', 'ID Kelahiran', 'Nama Bayi', 'Jenis Kelamin', 'NIK Ibu',
            'Nama Ibu', 'Tempat Lahir', 'Tanggal Lahir', 'Usia', 'Keterangan'
        ];

        $this->setHeader($sheet, $headers, 5);

        $rowNumber = 6;
        $no = 1;

        foreach ($data as $row) {
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

                    $usia = $diff->y > 0
                        ? $diff->y . ' tahun ' . $diff->m . ' bulan'
                        : $diff->m . ' bulan';
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
            $sheet->setCellValue('J' . $rowNumber, !empty($row['keterangan']) ? $row['keterangan'] : '-');

            $rowNumber++;
        }

        $this->finishSheet($sheet, 'A', 'J', $rowNumber);
    }

    private function sheetKematian($sheet, $db, $idDesa, $namaDesa)
    {
        $sheet->setTitle('Data Kematian');

        $data = $db->table('Kematian')
            ->where('id_desa', $idDesa)
            ->orderBy('tgl_kematian', 'DESC')
            ->get()
            ->getResultArray();

        $this->setTitle($sheet, 'DATA KEMATIAN WARGA', $namaDesa, 'A1:G1', 'A2:G2', 'A3:G3');

        $headers = [
            'No', 'ID Kematian', 'NIK', 'Nama Almarhum/ah',
            'Tanggal Wafat', 'Tempat Wafat', 'Penyebab / Keterangan'
        ];

        $this->setHeader($sheet, $headers, 5);

        $rowNumber = 6;
        $no = 1;

        foreach ($data as $row) {
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

        $this->finishSheet($sheet, 'A', 'G', $rowNumber);
    }

    private function sheetLansia($sheet, $db, $idDesa, $namaDesa)
    {
        $sheet->setTitle('Data Lansia');

        $data = $db->table('Lansia')
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
            ->get()
            ->getResultArray();

        $this->setTitle($sheet, 'DATA PEMANTAUAN LANSIA', $namaDesa, 'A1:H1', 'A2:H2', 'A3:H3');

        $headers = [
            'No', 'ID Lansia', 'NIK', 'Nama Lansia',
            'Umur', 'Hobi', 'Produktivitas', 'Catatan / Keterangan'
        ];

        $this->setHeader($sheet, $headers, 5);

        $rowNumber = 6;
        $no = 1;

        foreach ($data as $row) {
            $umur = '-';

            if (isset($row['umur']) && $row['umur'] !== '' && $row['umur'] !== null) {
                $umur = $row['umur'] . ' tahun';
            } elseif (isset($row['umur_lansia']) && $row['umur_lansia'] !== '' && $row['umur_lansia'] !== null) {
                $umur = $row['umur_lansia'] . ' tahun';
            }

            $produktivitas = $row['produktivitas'] ?? $row['produktifitas'] ?? 'Non-Produktif';

            $produktivitas = strtolower((string) $produktivitas) === 'produktif'
                ? 'Produktif'
                : 'Non-Produktif';

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

        $this->finishSheet($sheet, 'A', 'H', $rowNumber);
    }

    private function setTitle($sheet, $title, $namaDesa, $mergeTitle, $mergeDesa, $mergeTanggal)
    {
        $sheet->mergeCells($mergeTitle);
        $sheet->setCellValue(explode(':', $mergeTitle)[0], $title);

        $sheet->mergeCells($mergeDesa);
        $sheet->setCellValue(explode(':', $mergeDesa)[0], 'Desa: ' . $namaDesa);

        $sheet->mergeCells($mergeTanggal);
        $sheet->setCellValue(explode(':', $mergeTanggal)[0], 'Tanggal Unduh: ' . date('d-m-Y H:i'));

        $sheet->getStyle(explode(':', $mergeTitle)[0])->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle(explode(':', $mergeDesa)[0] . ':' . explode(':', $mergeTanggal)[0])->getFont()->setSize(11);
        $sheet->getStyle(explode(':', $mergeTitle)[0] . ':' . explode(':', $mergeTanggal)[0])
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    private function setHeader($sheet, array $headers, $row)
    {
        $column = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($column . $row, $header);
            $column++;
        }

        $lastColumn = chr(ord('A') + count($headers) - 1);

        $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
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
    }

    private function finishSheet($sheet, $startColumn, $endColumn, $nextRow)
    {
        $lastRow = max(5, $nextRow - 1);

        $sheet->getStyle($startColumn . '5:' . $endColumn . $lastRow)->applyFromArray([
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

        foreach (range($startColumn, $endColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->freezePane('A6');
        $sheet->setAutoFilter($startColumn . '5:' . $endColumn . $lastRow);
    }
}