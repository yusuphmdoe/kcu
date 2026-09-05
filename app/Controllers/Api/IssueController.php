<?php

namespace App\Controllers\Api;

use App\Models\IssueModel;
use CodeIgniter\HTTP\ResponseInterface;

class IssueController extends BaseApiController
{
    protected $modelName = IssueModel::class;
    protected array $hashFields = [];

    public function index(): ResponseInterface
    {
        /** @var IssueModel $model */
        $model = model(IssueModel::class);
        $limit  = (int) ($this->request->getGet('limit') ?? 100);
        $offset = (int) ($this->request->getGet('offset') ?? 0);
        $limit  = max(1, min($limit, 500));
        $offset = max(0, $offset);

        return $this->ok($model->findAllSafe($limit, $offset), 'Issue list');
    }

    public function show($id = null): ResponseInterface
    {
        /** @var IssueModel $model */
        $model = model(IssueModel::class);
        $row = $model->findSafe($id);

        if ($row === null) {
            return $this->failNotFoundMessage('Issue not found');
        }

        return $this->ok($row, 'Issue detail');
    }

    public function create(): ResponseInterface
    {
        /** @var IssueModel $model */
        $model = model(IssueModel::class);
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

        return $this->ok($model->findSafe($id), 'Issue created', 201);
    }

    public function update($id = null): ResponseInterface
    {
        /** @var IssueModel $model */
        $model = model(IssueModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Issue not found');
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

        return $this->ok($model->findSafe($id), 'Issue updated');
    }

    public function delete($id = null): ResponseInterface
    {
        /** @var IssueModel $model */
        $model = model(IssueModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Issue not found');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        return $this->ok(null, 'Issue deleted');
    }
}