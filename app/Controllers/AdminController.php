<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // 1. DASHBOARD UTAMA ADMIN
    public function index()
    {
        $db = \Config\Database::connect();

        $totalDesaAktif = $db->table('users')
            ->select('COUNT(DISTINCT id_desa) AS total_desa', false)
            ->where('role', 'ketua_pkk')
            ->where('status', 'approved')
            ->where('id_desa IS NOT NULL', null, false)
            ->get()
            ->getRowArray();

        $data = [
            'title' => 'Dashboard Admin Utama',

            'total_desa' => $totalDesaAktif['total_desa'] ?? 0,

            'total_pkk' => $this->userModel
                ->where('role', 'ketua_pkk')
                ->where('status', 'approved')
                ->countAllResults(),

            'total_user_pending' => $this->userModel
                ->where('role', 'ketua_pkk')
                ->where('status', 'pending')
                ->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    // 2. HALAMAN DAFTAR AKUN PKK YANG SUDAH DISETUJUI
    public function users()
    {
        $db = \Config\Database::connect();

        $users = $db->table('users')
            ->select('users.*, desa.nama_desa')
            ->join('desa', 'desa.id_desa = users.id_desa', 'left')
            ->where('users.role', 'ketua_pkk')
            ->where('users.status', 'approved')
            ->orderBy('users.id_user', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/users/index', [
            'title' => 'Akun PKK Aktif',
            'users' => $users
        ]);
    }

    // 3. DETAIL AKUN PKK AKTIF
    public function detailUser($id_user)
    {
        $db = \Config\Database::connect();

        $user = $db->table('users u')
            ->select('
                u.*,
                desa.nama_desa,
                admin.username AS approved_by_username,
                admin.nama_lengkap AS approved_by_nama
            ')
            ->join('desa', 'desa.id_desa = u.id_desa', 'left')
            ->join('users admin', 'admin.id_user = u.approved_by', 'left')
            ->where('u.id_user', $id_user)
            ->where('u.role', 'ketua_pkk')
            ->where('u.status', 'approved')
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()
                ->to(base_url('admin/users'))
                ->with('error', 'Akun PKK tidak ditemukan.');
        }

        return view('admin/users/detail', [
            'title' => 'Detail Akun PKK',
            'user'  => $user
        ]);
    }

    // 4. HALAMAN PENDAFTARAN AKUN YANG MASIH PENDING
    public function pendingUsers()
    {
        $db = \Config\Database::connect();

        $users = $db->table('users')
            ->select('users.*, COALESCE(desa.nama_desa, users.requested_nama_desa) AS nama_desa', false)
            ->join('desa', 'desa.id_desa = users.id_desa', 'left')
            ->where('users.role', 'ketua_pkk')
            ->where('users.status', 'pending')
            ->orderBy('users.id_user', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/users/pending', [
            'title' => 'Persetujuan Pendaftaran Akun PKK',
            'users' => $users
        ]);
    }

    // 5. ADMIN MENYETUJUI PENDAFTARAN USER
    public function approveUser($id_user)
    {
        $db = \Config\Database::connect();

        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'Data user tidak ditemukan.');
        }

        if (($user['role'] ?? null) !== 'ketua_pkk') {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'User ini bukan akun Ketua PKK.');
        }

        if (($user['status'] ?? null) !== 'pending') {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'Akun ini sudah diproses sebelumnya.');
        }

        $requestedIdDesa   = $user['requested_id_desa'] ?? null;
        $requestedNamaDesa = $user['requested_nama_desa'] ?? null;

        if (empty($requestedIdDesa)) {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'Wilayah desa yang diajukan tidak ditemukan. User perlu mendaftar ulang.');
        }

        if (empty($requestedNamaDesa)) {
            $requestedNamaDesa = 'Desa Terdaftar';
        }

        $adminId = session()->get('id_user') ?? null;

        try {
            $db->transBegin();

            $desaAda = $db->table('desa')
                ->where('id_desa', $requestedIdDesa)
                ->countAllResults();

            if ($desaAda == 0) {
                $db->table('desa')->insert([
                    'id_desa'   => $requestedIdDesa,
                    'nama_desa' => $requestedNamaDesa,
                ]);
            }

            $this->userModel->update($id_user, [
                'id_desa'         => $requestedIdDesa,
                'status'          => 'approved',
                'approved_by'     => $adminId,
                'approved_at'     => date('Y-m-d H:i:s'),
                'rejected_reason' => null,
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();

                return redirect()
                    ->to(base_url('admin/users/pending'))
                    ->with('error', 'Akun gagal disetujui. Transaksi database gagal.');
            }

            $db->transCommit();

            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('sukses', 'Akun berhasil disetujui dan desa telah diaktifkan.');

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'Terjadi kesalahan saat menyetujui akun: ' . $e->getMessage());
        }
    }

    // 6. ADMIN MENOLAK PENDAFTARAN USER
    public function rejectUser($id_user)
    {
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'Data user tidak ditemukan.');
        }

        if (($user['role'] ?? null) !== 'ketua_pkk') {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'User ini bukan akun Ketua PKK.');
        }

        if (($user['status'] ?? null) !== 'pending') {
            return redirect()
                ->to(base_url('admin/users/pending'))
                ->with('error', 'Akun ini sudah diproses sebelumnya.');
        }

        $reason = trim((string) $this->request->getPost('rejected_reason'));

        if ($reason === '') {
            $reason = 'Pendaftaran tidak disetujui oleh admin.';
        }

        $this->userModel->update($id_user, [
            'status'          => 'rejected',
            'id_desa'         => null,
            'rejected_reason' => $reason,
        ]);

        return redirect()
            ->to(base_url('admin/users/pending'))
            ->with('sukses', 'Akun berhasil ditolak.');
    }

    // 7. HAPUS AKUN PKK AKTIF
    public function deleteUser($id_user)
    {
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()
                ->to(base_url('admin/users'))
                ->with('error', 'Akun tidak ditemukan.');
        }

        if (($user['role'] ?? null) !== 'ketua_pkk') {
            return redirect()
                ->to(base_url('admin/users'))
                ->with('error', 'Akun ini bukan akun Ketua PKK.');
        }

        $this->userModel->delete($id_user);

        return redirect()
            ->to(base_url('admin/users'))
            ->with('sukses', 'Akun PKK berhasil dihapus.');
    }
}