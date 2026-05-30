<?php

namespace App\Controllers\Api;

use App\Models\PendudukDesaModel;
use App\Models\KelahiranModel;
use App\Models\KematianModel;
use App\Models\LansiaModel;

class StatistikDashboardApiController extends BaseApiController
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
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $bulanSekarang = date('m');
        $tahunSekarang = date('Y');

        $ringkasan = $this->getRingkasan($idDesa, $bulanSekarang, $tahunSekarang);
        $pendudukPerRt = $this->getPendudukPerRt($idDesa);
        $pendidikan = $this->getPendidikan($idDesa);
        $trenKelahiran = $this->getTrenBulanan($this->kelahiranModel, 'tgl_lahir', $idDesa);
        $trenKematian = $this->getTrenBulanan($this->kematianModel, 'tgl_kematian', $idDesa);
        $insight = $this->getInsight($ringkasan, $pendudukPerRt, $trenKelahiran, $trenKematian);

        return $this->ok('Statistik dashboard berhasil diambil.', [
            'ringkasan' => $ringkasan,
            'grafik' => [
                'penduduk_per_rt' => $pendudukPerRt,
                'pendidikan' => $pendidikan,
                'tren_kelahiran' => $trenKelahiran,
                'tren_kematian' => $trenKematian,
            ],
            'insight' => $insight,
            'meta' => [
                'id_desa' => $idDesa,
                'bulan' => (int) $bulanSekarang,
                'tahun' => (int) $tahunSekarang,
                'tanggal_generate' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    private function getRingkasan(string $idDesa, string $bulan, string $tahun): array
    {
        $totalPenduduk = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $totalLakiLaki = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'L')
            ->countAllResults();

        $totalPerempuan = $this->pendudukModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->countAllResults();

        $totalKelahiran = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $kelahiranLaki = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'L')
            ->countAllResults();

        $kelahiranPerempuan = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->countAllResults();

        $kelahiranBulanIni = $this->kelahiranModel
            ->where('id_desa', $idDesa)
            ->where('MONTH(tgl_lahir)', (int) $bulan, false)
            ->where('YEAR(tgl_lahir)', (int) $tahun, false)
            ->countAllResults();

        $totalKematian = $this->kematianModel
            ->where('id_desa', $idDesa)
            ->countAllResults();

        $kematianBulanIni = $this->kematianModel
            ->where('id_desa', $idDesa)
            ->where('MONTH(tgl_kematian)', (int) $bulan, false)
            ->where('YEAR(tgl_kematian)', (int) $tahun, false)
            ->countAllResults();

        $dataLansia = $this->lansiaModel
            ->where('id_desa', $idDesa)
            ->findAll();

        $totalLansia = count($dataLansia);
        $lansiaProduktif = 0;
        $lansiaNonproduktif = 0;

        foreach ($dataLansia as $row) {
            $status = strtolower(trim((string) ($row['produktifitas'] ?? '')));
            $status = str_replace(['_', ' '], '-', $status);

            if ($status === 'produktif') {
                $lansiaProduktif++;
            }

            if ($status === 'non-produktif' || $status === 'nonproduktif') {
                $lansiaNonproduktif++;
            }
        }

        return [
            'total_penduduk' => $totalPenduduk,
            'total_laki_laki' => $totalLakiLaki,
            'total_perempuan' => $totalPerempuan,

            'total_kelahiran' => $totalKelahiran,
            'kelahiran_laki_laki' => $kelahiranLaki,
            'kelahiran_perempuan' => $kelahiranPerempuan,
            'kelahiran_bulan_ini' => $kelahiranBulanIni,

            'total_kematian' => $totalKematian,
            'kematian_bulan_ini' => $kematianBulanIni,

            'total_lansia' => $totalLansia,
            'lansia_produktif' => $lansiaProduktif,
            'lansia_nonproduktif' => $lansiaNonproduktif,
        ];
    }

    private function getPendudukPerRt(string $idDesa): array
    {
        $rows = $this->pendudukModel
            ->select("
                RT,
                SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS laki_laki,
                SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS perempuan,
                COUNT(*) AS total
            ", false)
            ->where('id_desa', $idDesa)
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->findAll();

        $data = [];

        foreach ($rows as $row) {
            $data[] = [
                'rt' => (string) ($row['RT'] ?? '-'),
                'laki_laki' => (int) ($row['laki_laki'] ?? 0),
                'perempuan' => (int) ($row['perempuan'] ?? 0),
                'total' => (int) ($row['total'] ?? 0),
            ];
        }

        return $data;
    }

    private function getPendidikan(string $idDesa): array
    {
        $rows = $this->pendudukModel
            ->select('pendidikan, COUNT(*) AS jumlah')
            ->where('id_desa', $idDesa)
            ->groupBy('pendidikan')
            ->orderBy('jumlah', 'DESC')
            ->findAll();

        $data = [];

        foreach ($rows as $row) {
            $data[] = [
                'pendidikan' => $row['pendidikan'] ?: 'Tidak Diisi',
                'jumlah' => (int) ($row['jumlah'] ?? 0),
            ];
        }

        return $data;
    }

    private function getTrenBulanan($model, string $fieldTanggal, string $idDesa): array
    {
        $bulanIndonesia = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $timestamp = strtotime("-{$i} month");
            $bulan = (int) date('m', $timestamp);
            $tahun = (int) date('Y', $timestamp);

            $jumlah = $model
                ->where('id_desa', $idDesa)
                ->where("MONTH({$fieldTanggal})", $bulan, false)
                ->where("YEAR({$fieldTanggal})", $tahun, false)
                ->countAllResults();

            $data[] = [
                'bulan' => $bulanIndonesia[$bulan],
                'bulan_angka' => $bulan,
                'tahun' => $tahun,
                'jumlah' => $jumlah,
            ];
        }

        return $data;
    }

    private function getInsight(array $ringkasan, array $pendudukPerRt, array $trenKelahiran, array $trenKematian): array
    {
        $insight = [];

        if (!empty($pendudukPerRt)) {
            $rtTerbanyak = $pendudukPerRt[0];

            foreach ($pendudukPerRt as $rt) {
                if ((int) $rt['total'] > (int) $rtTerbanyak['total']) {
                    $rtTerbanyak = $rt;
                }
            }

            $insight[] = [
                'judul' => 'Penduduk Terbanyak',
                'isi' => 'RT ' . $rtTerbanyak['rt'] . ' memiliki jumlah penduduk terbanyak, yaitu ' . $rtTerbanyak['total'] . ' orang.',
                'icon' => 'bi-people-fill',
            ];
        }

        $kelahiranTertinggi = $this->getDataTertinggi($trenKelahiran);

        if ($kelahiranTertinggi && (int) $kelahiranTertinggi['jumlah'] > 0) {
            $insight[] = [
                'judul' => 'Tren Kelahiran',
                'isi' => 'Kelahiran tertinggi dalam 6 bulan terakhir terjadi pada bulan ' . $kelahiranTertinggi['bulan'] . ' ' . $kelahiranTertinggi['tahun'] . ' sebanyak ' . $kelahiranTertinggi['jumlah'] . ' data.',
                'icon' => 'bi-graph-up-arrow',
            ];
        } else {
            $insight[] = [
                'judul' => 'Tren Kelahiran',
                'isi' => 'Belum ada data kelahiran yang tercatat dalam 6 bulan terakhir.',
                'icon' => 'bi-person-plus-fill',
            ];
        }

        $kematianTertinggi = $this->getDataTertinggi($trenKematian);

        if ($kematianTertinggi && (int) $kematianTertinggi['jumlah'] > 0) {
            $insight[] = [
                'judul' => 'Tren Kematian',
                'isi' => 'Kematian tertinggi dalam 6 bulan terakhir terjadi pada bulan ' . $kematianTertinggi['bulan'] . ' ' . $kematianTertinggi['tahun'] . ' sebanyak ' . $kematianTertinggi['jumlah'] . ' data.',
                'icon' => 'bi-activity',
            ];
        } else {
            $insight[] = [
                'judul' => 'Tren Kematian',
                'isi' => 'Belum ada data kematian yang tercatat dalam 6 bulan terakhir.',
                'icon' => 'bi-file-earmark-medical-fill',
            ];
        }

        if ((int) $ringkasan['lansia_nonproduktif'] > 0) {
            $insight[] = [
                'judul' => 'Pemantauan Lansia',
                'isi' => 'Terdapat ' . $ringkasan['lansia_nonproduktif'] . ' lansia nonproduktif yang perlu diperhatikan.',
                'icon' => 'bi-person-standing',
            ];
        }

        return array_slice($insight, 0, 4);
    }

    private function getDataTertinggi(array $data): ?array
    {
        if (empty($data)) {
            return null;
        }

        $tertinggi = $data[0];

        foreach ($data as $row) {
            if ((int) $row['jumlah'] > (int) $tertinggi['jumlah']) {
                $tertinggi = $row;
            }
        }

        return $tertinggi;
    }
}