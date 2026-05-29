<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/admin/login')
                ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()
                ->to('/login')
                ->with('error', 'Akses ditolak. Halaman ini khusus Admin Pusat.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}