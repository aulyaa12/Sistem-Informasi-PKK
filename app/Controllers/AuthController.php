<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Halaman ini khusus form login Ketua PKK.
        // Tetap tampilkan form meskipun sebelumnya ada session,
        // supaya tidak otomatis loncat ke dashboard admin saat tombol Masuk diklik dari homepage.
        return view('login');
    }

    public function adminLogin()
    {
        // Halaman ini khusus form login Admin Pusat.
        return view('admin/login');
    }

    public function attemptLogin()
    {
        $userModel = new UserModel();

        $login    = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($login === '' || $password === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username/email dan password wajib diisi.');
        }

        $user = $this->findUserByUsernameOrEmail($userModel, $login);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username/email atau password salah.');
        }

        // /login hanya untuk Ketua PKK
        if ($user['role'] !== 'ketua_pkk') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Halaman ini khusus untuk Ketua PKK. Admin masuk melalui halaman login admin.');
        }

        $statusCheck = $this->checkAccountStatus($user);

        if ($statusCheck !== true) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $statusCheck);
        }

        $this->setLoginSession($user);

        return redirect()
            ->to('/pkk/dashboard')
            ->with('success', 'Selamat datang kembali, ' . $user['username'] . '!');
    }

    public function attemptAdminLogin()
    {
        $userModel = new UserModel();

        $login    = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($login === '' || $password === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username/email dan password wajib diisi.');
        }

        $user = $this->findUserByUsernameOrEmail($userModel, $login);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username/email atau password salah.');
        }

        // /admin/login hanya untuk Admin Pusat
        if ($user['role'] !== 'admin') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Akun ini tidak memiliki akses admin.');
        }

        $statusCheck = $this->checkAccountStatus($user);

        if ($statusCheck !== true) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $statusCheck);
        }

        $this->setLoginSession($user);

        return redirect()
            ->to('/admin/dashboard')
            ->with('success', 'Selamat datang, Admin.');
    }

    public function logout()
    {
        $role = session()->get('role');

        session()->destroy();

        if ($role === 'admin') {
            return redirect()
                ->to('/admin/login')
                ->with('success', 'Anda berhasil logout.');
        }

        return redirect()
            ->to('/login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function findUserByUsernameOrEmail($userModel, $login)
    {
        $user = $userModel
            ->where('username', $login)
            ->first();

        if ($user) {
            return $user;
        }

        return $userModel
            ->where('email', $login)
            ->first();
    }

    private function checkAccountStatus($user)
    {
        $status = $user['status'] ?? 'pending';

        if ($status === 'approved') {
            return true;
        }

        if ($status === 'pending') {
            return 'Akun Anda masih menunggu persetujuan admin.';
        }

        if ($status === 'rejected') {
            return 'Akun Anda ditolak. Silakan hubungi admin.';
        }

        if ($status === 'inactive') {
            return 'Akun Anda tidak aktif. Silakan hubungi admin.';
        }

        return 'Akun Anda belum dapat digunakan.';
    }

    private function setLoginSession($user)
    {
        // Hindari session lama bercampur saat ganti akun.
        session()->destroy();
        session()->start();
        session()->regenerate(true);

        session()->set([
            'id_user'      => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap'] ?? null,
            'username'     => $user['username'],
            'email'        => $user['email'],
            'role'         => $user['role'],
            'id_desa'      => $user['id_desa'],
            'isLoggedIn'   => true,
        ]);
    }
}