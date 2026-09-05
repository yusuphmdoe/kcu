<?php

namespace App\Controllers\Api;

use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends BaseApiController
{
    protected $modelName = SupplierModel::class;
    protected array $hashFields = ['password'];

    public function index(): ResponseInterface
    {
        /** @var SupplierModel $model */
        $model = model(SupplierModel::class);
        $limit  = (int) ($this->request->getGet('limit') ?? 100);
        $offset = (int) ($this->request->getGet('offset') ?? 0);
        $limit  = max(1, min($limit, 500));
        $offset = max(0, $offset);

        return $this->ok($model->findAllSafe($limit, $offset), 'Supplier list');
    }

    public function show($id = null): ResponseInterface
    {
        /** @var SupplierModel $model */
        $model = model(SupplierModel::class);
        $row = $model->findSafe($id);

        if ($row === null) {
            return $this->failNotFoundMessage('Supplier not found');
        }

        return $this->ok($row, 'Supplier detail');
    }

    public function create(): ResponseInterface
    {
        /** @var SupplierModel $model */
        $model = model(SupplierModel::class);
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

        return $this->ok($model->findSafe($id), 'Supplier created', 201);
    }

    public function update($id = null): ResponseInterface
    {
        /** @var SupplierModel $model */
        $model = model(SupplierModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Supplier not found');
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

        return $this->ok($model->findSafe($id), 'Supplier updated');
    }

    public function delete($id = null): ResponseInterface
    {
        /** @var SupplierModel $model */
        $model = model(SupplierModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Supplier not found');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        return $this->ok(null, 'Supplier deleted');
    }
}