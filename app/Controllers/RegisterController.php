<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('auth/register', [
            'title' => 'Pendaftaran Akun Ketua PKK Desa'
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah digunakan.',
                ]
            ],
            'username' => [
                'rules'  => 'required|min_length[4]|is_unique[users.username]',
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 4 karakter.',
                    'is_unique'  => 'Username sudah digunakan.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 5 karakter.',
                ]
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak sama.',
                ]
            ],
            'id_desa' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Desa wajib dipilih.',
                ]
            ],
            'nama_desa' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama desa belum terbaca. Pilih ulang desa dari dropdown.',
                ]
            ],
            'no_hp' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nomor HP / WhatsApp wajib diisi.',
                ]
            ],
            'jabatan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                ]
            ],
            'alasan_pengajuan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Alasan pengajuan wajib diisi.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();

            $message = '<ul class="mb-0">';
            foreach ($errors as $error) {
                $message .= '<li>' . esc($error) . '</li>';
            }
            $message .= '</ul>';

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $message);
        }

        $namaLengkap = trim((string) $this->request->getPost('nama_lengkap'));
        $email       = trim((string) $this->request->getPost('email'));
        $username    = trim((string) $this->request->getPost('username'));
        $password    = (string) $this->request->getPost('password');

        $requestedIdDesa   = trim((string) $this->request->getPost('id_desa'));
        $requestedNamaDesa = trim((string) $this->request->getPost('nama_desa'));

        $noHp    = trim((string) $this->request->getPost('no_hp'));
        $jabatan = trim((string) $this->request->getPost('jabatan'));
        $alasan  = trim((string) $this->request->getPost('alasan_pengajuan'));

        $registrationCode = 'REG-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

        try {
            $inserted = $this->userModel->insert([
                'nama_lengkap'        => $namaLengkap,
                'email'               => $email,
                'username'            => $username,
                'password'            => password_hash($password, PASSWORD_DEFAULT),

                // id_desa tetap NULL sampai admin approve.
                'id_desa'             => null,

                // Data wilayah sementara dari pendaftaran.
                'requested_id_desa'   => $requestedIdDesa,
                'requested_nama_desa' => $requestedNamaDesa,

                'role'                => 'ketua_pkk',
                'status'              => 'pending',
                'registration_code'   => $registrationCode,
                'no_hp'               => $noHp,
                'jabatan'             => $jabatan,
                'alasan_pengajuan'    => $alasan,
            ]);

            if (!$inserted) {
                $modelErrors = $this->userModel->errors();

                if (!empty($modelErrors)) {
                    $message = '<ul class="mb-0">';
                    foreach ($modelErrors as $error) {
                        $message .= '<li>' . esc($error) . '</li>';
                    }
                    $message .= '</ul>';
                } else {
                    $message = 'Pendaftaran gagal disimpan. Periksa allowedFields pada UserModel.';
                }

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $message);
            }

            return redirect()
                ->to('/register/success')
                ->with('success', 'Pendaftaran berhasil dikirim.');

        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pendaftaran: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('auth/register_success', [
            'title' => 'Pendaftaran Berhasil'
        ]);
    }
}