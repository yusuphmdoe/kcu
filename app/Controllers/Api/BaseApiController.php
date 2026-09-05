<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

abstract class BaseApiController extends ResourceController
{
    protected $format = 'json';

    protected function ok($data = null, string $message = 'Success', int $code = 200): ResponseInterface
    {
        return $this->respond([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function failNotFoundMessage(string $message = 'Resource not found'): ResponseInterface
    {
        return $this->respond([
            'status'  => false,
            'message' => $message,
            'data'    => null,
        ], 404);
    }

    protected function failValidation(array $errors): ResponseInterface
    {
        return $this->respond([
            'status'  => false,
            'message' => 'Validation failed',
            'errors'  => $errors,
            'data'    => null,
        ], 422);
    }

    protected function failServer(string $message = 'Server error'): ResponseInterface
    {
        return $this->respond([
            'status'  => false,
            'message' => $message,
            'data'    => null,
        ], 500);
    }

    /**
     * Hash password fields when present in payload.
     *
     * @param list<string> $hashFields
     */
    protected function preparePayload(array $data, array $hashFields = []): array
    {
        foreach ($hashFields as $field) {
            if (array_key_exists($field, $data) && $data[$field] !== null && $data[$field] !== '') {
                $data[$field] = password_hash((string) $data[$field], PASSWORD_DEFAULT);
            } else {
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    protected function requestPayload(): array
    {
        try {
            $json = $this->request->getJSON(true);
            if (is_array($json)) {
                return $json;
            }
        } catch (\Throwable) {
            // Fall through to form/post body.
        }

        $post = $this->request->getPost();

        return is_array($post) ? $post : [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function requestUpdatePayload(): array
    {
        try {
            $json = $this->request->getJSON(true);
            if (is_array($json)) {
                return $json;
            }
        } catch (\Throwable) {
            // Fall through to raw input.
        }

        $raw = $this->request->getRawInput();

        return is_array($raw) ? $raw : [];
    }
}