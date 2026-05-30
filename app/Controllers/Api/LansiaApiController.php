<?php

namespace App\Controllers\Api;

use App\Models\LansiaModel;
use App\Models\PendudukDesaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class LansiaApiController extends BaseApiController
{
    protected $lansiaModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->lansiaModel   = new LansiaModel();
        $this->pendudukModel = new PendudukDesaModel();
    }

    private function getWargaDesa($nik, $idDesa)
    {
        return $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();
    }

    private function hitungUmur($tglLahir): int
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

    private function normalisasiProduktifitas($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = strtolower(trim((string) $value));
        $value = str_replace(['_', ' '], '-', $value);

        if ($value === 'produktif') {
            return 'produktif';
        }

        if (
            $value === 'non-produktif' ||
            $value === 'nonproduktif' ||
            $value === 'tidak-produktif'
        ) {
            return 'non-produktif';
        }

        return null;
    }

    private function getDetailLansia($id, $idDesa)
    {
        return $this->lansiaModel
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
            ->where('Lansia.id_lansia', $id)
            ->where('Lansia.id_desa', $idDesa)
            ->first();
    }

    public function index()
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->lansiaModel
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

        return $this->ok('Data lansia berhasil diambil.', $data);
    }

    public function show($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->getDetailLansia($id, $idDesa);

        if (!$data) {
            return $this->failApi('Data lansia tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        return $this->ok('Detail lansia berhasil diambil.', $data);
    }

    public function create()
    {
        $input  = $this->getJsonInput();
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $input['id_desa'] = $idDesa;

        if (isset($input['produktivitas']) && !isset($input['produktifitas'])) {
            $input['produktifitas'] = $input['produktivitas'];
        }

        $input['produktifitas'] = $this->normalisasiProduktifitas($input['produktifitas'] ?? null);

        $rules = [
            'id_desa'       => 'required',
            'nik'           => 'required',
            'hobi'          => 'required',
            'produktifitas' => 'required|in_list[produktif,non-produktif]',
            'keterangan'    => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $nik = $input['nik'];

        $warga = $this->getWargaDesa($nik, $idDesa);

        if (!$warga) {
            return $this->failApi('Warga tidak ditemukan atau bukan penduduk desa tersebut.', 404);
        }

        $sudahTerdaftar = $this->lansiaModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if ($sudahTerdaftar) {
            return $this->failApi('Warga ini sudah tercatat dalam data lansia.', 409);
        }

        $umurLansia = $this->hitungUmur($warga['tgl_lahir'] ?? null);

        $data = [
            'id_desa'       => $idDesa,
            'nik'           => $nik,
            'nama_lansia'   => $warga['nama'] ?? $warga['nama_penduduk'] ?? '',
            'umur_lansia'   => $umurLansia,
            'produktifitas' => $input['produktifitas'],
            'hobi'          => $input['hobi'],
            'keterangan'    => $input['keterangan'] ?? null,
        ];

        try {
            $id = $this->lansiaModel->insert($data, true);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok(
            'Data lansia berhasil ditambahkan.',
            $this->getDetailLansia($id, $idDesa),
            201
        );
    }

    public function update($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->lansiaModel
            ->where('id_lansia', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$existing) {
            return $this->failApi('Data lansia tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        $input = $this->getJsonInput();

        if (isset($input['produktivitas']) && !isset($input['produktifitas'])) {
            $input['produktifitas'] = $input['produktivitas'];
        }

        $input['produktifitas'] = $this->normalisasiProduktifitas($input['produktifitas'] ?? null);

        $rules = [
            'hobi'          => 'required',
            'produktifitas' => 'required|in_list[produktif,non-produktif]',
            'keterangan'    => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $data = [
            'hobi'          => $input['hobi'],
            'produktifitas' => $input['produktifitas'],
            'keterangan'    => $input['keterangan'] ?? null,
        ];

        try {
            $this->lansiaModel->update($id, $data);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok(
            'Data lansia berhasil diperbarui.',
            $this->getDetailLansia($id, $idDesa)
        );
    }

    public function delete($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->getDetailLansia($id, $idDesa);

        if (!$existing) {
            return $this->failApi('Data lansia tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        try {
            $this->lansiaModel->delete($id);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok('Data lansia berhasil dihapus.', $existing);
    }
}