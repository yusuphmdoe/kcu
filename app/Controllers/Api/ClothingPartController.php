<?php

namespace App\Controllers\Api;

use App\Models\ClothingPartModel;
use CodeIgniter\HTTP\ResponseInterface;

class ClothingPartController extends BaseApiController
{
    protected $modelName = ClothingPartModel::class;
    protected array $hashFields = [];

    public function index(): ResponseInterface
    {
        /** @var ClothingPartModel $model */
        $model = model(ClothingPartModel::class);
        $limit  = (int) ($this->request->getGet('limit') ?? 100);
        $offset = (int) ($this->request->getGet('offset') ?? 0);
        $limit  = max(1, min($limit, 500));
        $offset = max(0, $offset);

        return $this->ok($model->findAllSafe($limit, $offset), 'ClothingPart list');
    }

    public function show($id = null): ResponseInterface
    {
        /** @var ClothingPartModel $model */
        $model = model(ClothingPartModel::class);
        $row = $model->findSafe($id);

        if ($row === null) {
            return $this->failNotFoundMessage('ClothingPart not found');
        }

        return $this->ok($row, 'ClothingPart detail');
    }

    public function create(): ResponseInterface
    {
        /** @var ClothingPartModel $model */
        $model = model(ClothingPartModel::class);
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

        return $this->ok($model->findSafe($id), 'ClothingPart created', 201);
    }

    public function update($id = null): ResponseInterface
    {
        /** @var ClothingPartModel $model */
        $model = model(ClothingPartModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('ClothingPart not found');
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

        return $this->ok($model->findSafe($id), 'ClothingPart updated');
    }

    public function delete($id = null): ResponseInterface
    {
        /** @var ClothingPartModel $model */
        $model = model(ClothingPartModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('ClothingPart not found');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        return $this->ok(null, 'ClothingPart deleted');
    }
}