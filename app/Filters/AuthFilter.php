<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            $path = trim($request->getUri()->getPath(), '/');

            if (str_starts_with($path, 'admin')) {
                return redirect()
                    ->to('/admin/login')
                    ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
            }

            return redirect()
                ->to('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}