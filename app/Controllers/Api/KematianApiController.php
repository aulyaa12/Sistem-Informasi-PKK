<?php

namespace App\Controllers\Api;

use App\Models\KematianModel;
use App\Models\PendudukDesaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class KematianApiController extends BaseApiController
{
    protected $kematianModel;
    protected $pendudukModel;

    protected array $allowedFields = [
        'id_desa',
        'nik',
        'nama_almarhum',
        'tgl_kematian',
        'tempat_kematian',
        'keterangan',
    ];

    public function __construct()
    {
        $this->kematianModel = new KematianModel();
        $this->pendudukModel = new PendudukDesaModel();
    }

    private function getWargaDesa($nik, $idDesa)
    {
        return $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();
    }

    private function getDetailKematian($id, $idDesa)
    {
        return $this->kematianModel
            ->where('id_kematian', $id)
            ->where('id_desa', $idDesa)
            ->first();
    }

    public function index()
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->kematianModel
            ->where('id_desa', $idDesa)
            ->orderBy('id_kematian', 'DESC')
            ->findAll();

        return $this->ok('Data kematian berhasil diambil.', $data);
    }

    public function show($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->getDetailKematian($id, $idDesa);

        if (!$data) {
            return $this->failApi('Data kematian tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        return $this->ok('Detail kematian berhasil diambil.', $data);
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
            'id_desa'         => 'required',
            'nik'             => 'required',
            'tgl_kematian'    => 'required|valid_date',
            'tempat_kematian' => 'required',
            'keterangan'      => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $warga = $this->getWargaDesa($input['nik'], $idDesa);

        if (!$warga) {
            return $this->failApi('Data warga tidak ditemukan atau bukan penduduk desa tersebut.', 404);
        }

        $data = [
            'id_desa'         => $idDesa,
            'nik'             => $input['nik'],
            'nama_almarhum'   => $warga['nama'],
            'tgl_kematian'    => $input['tgl_kematian'],
            'tempat_kematian' => $input['tempat_kematian'],
            'keterangan'      => $input['keterangan'] ?? null,
        ];

        try {
            $id = $this->kematianModel->insert($data, true);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok(
            'Data kematian berhasil ditambahkan.',
            $this->getDetailKematian($id, $idDesa),
            201
        );
    }

    public function update($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->getDetailKematian($id, $idDesa);

        if (!$existing) {
            return $this->failApi('Data kematian tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        $input = $this->getJsonInput();

        $rules = [
            'tgl_kematian'    => 'required|valid_date',
            'tempat_kematian' => 'required',
            'keterangan'      => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $data = [
            'tgl_kematian'    => $input['tgl_kematian'],
            'tempat_kematian' => $input['tempat_kematian'],
            'keterangan'      => $input['keterangan'] ?? null,
        ];

        try {
            $this->kematianModel->update($id, $data);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok(
            'Data kematian berhasil diperbarui.',
            $this->getDetailKematian($id, $idDesa)
        );
    }

    public function delete($id)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->getDetailKematian($id, $idDesa);

        if (!$existing) {
            return $this->failApi('Data kematian tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        try {
            $this->kematianModel->delete($id);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok('Data kematian berhasil dihapus.', $existing);
    }
}