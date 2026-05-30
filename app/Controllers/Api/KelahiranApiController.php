<?php

namespace App\Controllers\Api;

use App\Models\KelahiranModel;
use App\Models\PendudukDesaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class KelahiranApiController extends BaseApiController
{
    protected $kelahiranModel;
    protected $pendudukModel;

    protected array $allowedFields = [
        'id_desa',
        'nik_ibu',
        'nama_bayi',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'keterangan',
    ];

    public function __construct()
    {
        $this->kelahiranModel = new KelahiranModel();
        $this->pendudukModel  = new PendudukDesaModel();
    }

    private function ibuMilikDesa($nikIbu, $idDesa)
    {
        return $this->pendudukModel
            ->where('nik', $nikIbu)
            ->where('id_desa', $idDesa)
            ->where('jenis_kelamin', 'P')
            ->first();
    }

    private function getDetailKelahiran($id, $idDesa)
    {
        return $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_kelahiran', $id)
            ->where('Kelahiran.id_desa', $idDesa)
            ->first();
    }

    public function index()
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->kelahiranModel
            ->select('Kelahiran.*, PendudukDesa.nama AS nama_ibu')
            ->join(
                'PendudukDesa',
                'PendudukDesa.nik = Kelahiran.nik_ibu AND PendudukDesa.id_desa = Kelahiran.id_desa',
                'left'
            )
            ->where('Kelahiran.id_desa', $idDesa)
            ->orderBy('Kelahiran.id_kelahiran', 'DESC')
            ->findAll();

        return $this->ok('Data kelahiran berhasil diambil.', $data);
    }

    public function show($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->getDetailKelahiran($id, $idDesa);

        if (!$data) {
            return $this->failApi('Data kelahiran tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        return $this->ok('Detail kelahiran berhasil diambil.', $data);
    }

    public function create()
    {
        $input  = $this->getJsonInput();
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $input['id_desa'] = $idDesa;

        $rules = [
            'id_desa'       => 'required',
            'nik_ibu'       => 'required',
            'nama_bayi'     => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tgl_lahir'     => 'required|valid_date',
            'tempat_lahir'  => 'required',
            'keterangan'    => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $ibu = $this->ibuMilikDesa($input['nik_ibu'], $idDesa);

        if (!$ibu) {
            return $this->failApi('Data ibu tidak ditemukan, bukan penduduk desa tersebut, atau bukan perempuan.', 404);
        }

        $data = $this->onlyAllowed($input, $this->allowedFields);

        try {
            $id = $this->kelahiranModel->insert($data, true);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok(
            'Data kelahiran berhasil ditambahkan.',
            $this->getDetailKelahiran($id, $idDesa),
            201
        );
    }

    public function update($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->kelahiranModel
            ->where('id_kelahiran', $id)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$existing) {
            return $this->failApi('Data kelahiran tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        $input = $this->getJsonInput();

        $rules = [
            'nik_ibu'       => 'required',
            'nama_bayi'     => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tgl_lahir'     => 'required|valid_date',
            'tempat_lahir'  => 'required',
            'keterangan'    => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $ibu = $this->ibuMilikDesa($input['nik_ibu'], $idDesa);

        if (!$ibu) {
            return $this->failApi('Data ibu tidak ditemukan, bukan penduduk desa tersebut, atau bukan perempuan.', 404);
        }

        $data = $this->onlyAllowed($input, $this->allowedFields);

        unset($data['id_desa']);

        try {
            $this->kelahiranModel->update($id, $data);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok(
            'Data kelahiran berhasil diperbarui.',
            $this->getDetailKelahiran($id, $idDesa)
        );
    }

    public function delete($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->getDetailKelahiran($id, $idDesa);

        if (!$existing) {
            return $this->failApi('Data kelahiran tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        try {
            $this->kelahiranModel->delete($id);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok('Data kelahiran berhasil dihapus.', $existing);
    }
}