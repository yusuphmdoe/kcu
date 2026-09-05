<?php

namespace App\Controllers\Api;

use App\Models\ReceiptModel;
use CodeIgniter\HTTP\ResponseInterface;

class ReceiptController extends BaseApiController
{
    protected $modelName = ReceiptModel::class;
    protected array $hashFields = [];

    public function index(): ResponseInterface
    {
        /** @var ReceiptModel $model */
        $model = model(ReceiptModel::class);
        $limit  = (int) ($this->request->getGet('limit') ?? 100);
        $offset = (int) ($this->request->getGet('offset') ?? 0);
        $limit  = max(1, min($limit, 500));
        $offset = max(0, $offset);

        return $this->ok($model->findAllSafe($limit, $offset), 'Receipt list');
    }

    public function show($id = null): ResponseInterface
    {
        /** @var ReceiptModel $model */
        $model = model(ReceiptModel::class);
        $row = $model->findSafe($id);

        if ($row === null) {
            return $this->failNotFoundMessage('Receipt not found');
        }

        return $this->ok($row, 'Receipt detail');
    }

    public function create(): ResponseInterface
    {
        /** @var ReceiptModel $model */
        $model = model(ReceiptModel::class);
        $payload = $this->preparePayload($this->requestPayload(), $this->hashFields);

        if ($payload === [] || $payload === null) {
            return $this->failValidation(['body' => 'Request body is required']);
        }

        try {
            $id = $model->insert($payload, true);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        if ($id === false) {
            return $this->failValidation($model->errors());
        }

        return $this->ok($model->findSafe($id), 'Receipt created', 201);
    }

    public function update($id = null): ResponseInterface
    {
        /** @var ReceiptModel $model */
        $model = model(ReceiptModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Receipt not found');
        }

        $payload = $this->preparePayload($this->requestUpdatePayload(), $this->hashFields);

        if ($payload === [] || $payload === null) {
            return $this->failValidation(['body' => 'Request body is required']);
        }

        try {
            $ok = $model->update($id, $payload);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        if ($ok === false) {
            return $this->failValidation($model->errors());
        }

        return $this->ok($model->findSafe($id), 'Receipt updated');
    }

    public function delete($id = null): ResponseInterface
    {
        /** @var ReceiptModel $model */
        $model = model(ReceiptModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Receipt not found');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        return $this->ok(null, 'Receipt deleted');
    }
}