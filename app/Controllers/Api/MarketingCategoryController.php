<?php

namespace App\Controllers\Api;

use App\Models\MarketingCategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class MarketingCategoryController extends BaseApiController
{
    protected $modelName = MarketingCategoryModel::class;
    protected array $hashFields = [];

    public function index(): ResponseInterface
    {
        /** @var MarketingCategoryModel $model */
        $model = model(MarketingCategoryModel::class);
        $limit  = (int) ($this->request->getGet('limit') ?? 100);
        $offset = (int) ($this->request->getGet('offset') ?? 0);
        $limit  = max(1, min($limit, 500));
        $offset = max(0, $offset);

        return $this->ok($model->findAllSafe($limit, $offset), 'MarketingCategory list');
    }

    public function show($id = null): ResponseInterface
    {
        /** @var MarketingCategoryModel $model */
        $model = model(MarketingCategoryModel::class);
        $row = $model->findSafe($id);

        if ($row === null) {
            return $this->failNotFoundMessage('MarketingCategory not found');
        }

        return $this->ok($row, 'MarketingCategory detail');
    }

    public function create(): ResponseInterface
    {
        /** @var MarketingCategoryModel $model */
        $model = model(MarketingCategoryModel::class);
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

        return $this->ok($model->findSafe($id), 'MarketingCategory created', 201);
    }

    public function update($id = null): ResponseInterface
    {
        /** @var MarketingCategoryModel $model */
        $model = model(MarketingCategoryModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('MarketingCategory not found');
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

        return $this->ok($model->findSafe($id), 'MarketingCategory updated');
    }

    public function delete($id = null): ResponseInterface
    {
        /** @var MarketingCategoryModel $model */
        $model = model(MarketingCategoryModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('MarketingCategory not found');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        return $this->ok(null, 'MarketingCategory deleted');
    }
}