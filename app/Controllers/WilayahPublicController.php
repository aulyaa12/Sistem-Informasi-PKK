<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class WilayahPublicController extends BaseController
{
    public function proxy()
    {
        $endpoint = $this->request->getGet('endpoint');
        $id       = $this->request->getGet('id');

        $allowed = ['provinces', 'regencies', 'districts', 'villages'];

        if (!in_array($endpoint, $allowed, true)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'Endpoint tidak valid']);
        }

        $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        if ($endpoint === 'provinces') {
            $url = $baseUrl . '/provinces.json';
        } else {
            if (empty($id)) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['error' => 'ID wilayah wajib diisi']);
            }

            $url = $baseUrl . '/' . $endpoint . '/' . $id . '.json';
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Accept'     => 'application/json',
                    'User-Agent' => 'Mozilla/5.0',
                ],
                'timeout'         => 15,
                'http_errors'     => false,
                'allow_redirects' => true,
            ]);

            $statusCode = $response->getStatusCode();
            $body       = $response->getBody();

            if ($statusCode < 200 || $statusCode >= 300) {
                return $this->response
                    ->setStatusCode(502)
                    ->setJSON([
                        'error'  => 'API wilayah gagal diakses',
                        'status' => $statusCode,
                        'body'   => substr($body, 0, 200),
                    ]);
            }

            json_decode($body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->response
                    ->setStatusCode(502)
                    ->setJSON([
                        'error' => 'Respons API bukan JSON',
                        'body'  => substr($body, 0, 200),
                    ]);
            }

            return $this->response
                ->setContentType('application/json')
                ->setBody($body);

        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'error'   => 'Gagal mengambil data wilayah',
                    'message' => $e->getMessage(),
                ]);
        }
    }
}