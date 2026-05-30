<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BaseApiController extends BaseController
{
    use ResponseTrait;

    protected function getJsonInput(): array
    {
        $json = $this->request->getJSON(true);

        if (is_array($json)) {
            return $json;
        }

        $rawInput = $this->request->getRawInput();

        if (is_array($rawInput) && !empty($rawInput)) {
            return $rawInput;
        }

        $post = $this->request->getPost();

        if (is_array($post) && !empty($post)) {
            return $post;
        }

        return [];
    }

    protected function getIdDesaFromRequest(): ?string
    {
        $fromSession = session()->get('id_desa');

        if (!empty($fromSession)) {
            return (string) $fromSession;
        }

        $fromHeader = $this->request->getHeaderLine('X-ID-DESA');

        if (!empty($fromHeader)) {
            return trim((string) $fromHeader);
        }

        $fromQuery = $this->request->getGet('id_desa');

        if (!empty($fromQuery)) {
            return trim((string) $fromQuery);
        }

        $input = $this->getJsonInput();

        if (!empty($input['id_desa'])) {
            return trim((string) $input['id_desa']);
        }

        return null;
    }

    protected function ok(string $message, $data = null, int $code = 200)
    {
        return $this->respond([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function failApi(string $message, int $code = 400, $errors = null)
    {
        return $this->respond([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }

    protected function failIdDesa()
    {
        return $this->failApi(
            'id_desa wajib dikirim. Gunakan parameter ?id_desa=..., body JSON id_desa, atau header X-ID-DESA.',
            400
        );
    }

    protected function onlyAllowed(array $input, array $allowedFields): array
    {
        $data = [];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $input)) {
                $data[$field] = $input[$field];
            }
        }

        return $data;
    }

    protected function databaseError(DatabaseException $e)
    {
        return $this->failApi(
            'Operasi database gagal. Pastikan data yang dikirim sudah sesuai relasi database.',
            400,
            ENVIRONMENT === 'development' ? $e->getMessage() : null
        );
    }
}