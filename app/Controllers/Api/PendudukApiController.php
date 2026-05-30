<?php

namespace App\Controllers\Api;

use App\Models\PendudukDesaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PendudukApiController extends BaseApiController
{
    protected PendudukDesaModel $pendudukModel;

    protected array $allowedFields = [
        'nik',
        'id_desa',
        'no_kk',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'RT',
        'pekerjaan',
        'status_pernikahan',
        'pendidikan',
    ];

    public function __construct()
    {
        $this->pendudukModel = new PendudukDesaModel();
    }

    public function index()
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $keyword = trim((string) $this->request->getGet('keyword'));
        $rt      = trim((string) $this->request->getGet('rt'));
        $jk      = trim((string) $this->request->getGet('jenis_kelamin'));

        $builder = $this->pendudukModel->where('id_desa', $idDesa);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('nama', $keyword)
                ->orLike('nik', $keyword)
                ->orLike('no_kk', $keyword)
                ->groupEnd();
        }

        if ($rt !== '') {
            $builder->where('RT', $rt);
        }

        if ($jk !== '') {
            $builder->where('jenis_kelamin', $jk);
        }

        $data = $builder
            ->orderBy('RT', 'ASC')
            ->orderBy('nama', 'ASC')
            ->findAll();

        return $this->ok('Data penduduk berhasil diambil.', $data);
    }

    public function show($nik)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $data = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$data) {
            return $this->failApi('Data penduduk tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        return $this->ok('Detail penduduk berhasil diambil.', $data);
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
            'nik'               => 'required|numeric|exact_length[16]|is_unique[PendudukDesa.nik]',
            'id_desa'           => 'required',
            'no_kk'             => 'required|numeric|exact_length[16]',
            'nama'              => 'required|min_length[3]',
            'jenis_kelamin'     => 'required|in_list[L,P]',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|valid_date',
            'alamat'            => 'required',
            'RT'                => 'required|numeric',
            'pekerjaan'         => 'required',
            'status_pernikahan' => 'required|in_list[belum,menikah]',
            'pendidikan'        => 'required',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        $data = $this->onlyAllowed($input, $this->allowedFields);

        try {
            $this->pendudukModel->insert($data);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok('Data penduduk berhasil ditambahkan.', $this->pendudukModel->find($input['nik']), 201);
    }

    public function update($nik)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$existing) {
            return $this->failApi('Data penduduk tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        $input = $this->getJsonInput();
        $data  = $this->onlyAllowed($input, $this->allowedFields);

        unset($data['nik'], $data['id_desa']);

        $rules = [
            'no_kk'             => 'required|numeric|exact_length[16]',
            'nama'              => 'required|min_length[3]',
            'jenis_kelamin'     => 'required|in_list[L,P]',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|valid_date',
            'alamat'            => 'required',
            'RT'                => 'required|numeric',
            'pekerjaan'         => 'required',
            'status_pernikahan' => 'required|in_list[belum,menikah]',
            'pendidikan'        => 'required',
        ];

        if (!$this->validateData($data, $rules)) {
            return $this->failApi('Validasi data gagal.', 422, $this->validator->getErrors());
        }

        try {
            $this->pendudukModel->update($nik, $data);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        $updated = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        return $this->ok('Data penduduk berhasil diperbarui.', $updated);
    }

    public function delete($nik)
    {
        $idDesa = $this->getIdDesaFromRequest();

        if (!$idDesa) {
            return $this->failIdDesa();
        }

        $existing = $this->pendudukModel
            ->where('nik', $nik)
            ->where('id_desa', $idDesa)
            ->first();

        if (!$existing) {
            return $this->failApi('Data penduduk tidak ditemukan atau bukan milik desa tersebut.', 404);
        }

        try {
            $this->pendudukModel->delete($nik);
        } catch (DatabaseException $e) {
            return $this->databaseError($e);
        }

        return $this->ok('Data penduduk berhasil dihapus.', $existing);
    }
}