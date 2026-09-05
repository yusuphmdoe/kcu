<?php

namespace App\Controllers\Api;

use App\Models\OrderModel;
use CodeIgniter\HTTP\ResponseInterface;

class OrderController extends BaseApiController
{
    protected $modelName = OrderModel::class;
    protected array $hashFields = [];

    public function index(): ResponseInterface
    {
        /** @var OrderModel $model */
        $model = model(OrderModel::class);
        $limit  = (int) ($this->request->getGet('limit') ?? 100);
        $offset = (int) ($this->request->getGet('offset') ?? 0);
        $limit  = max(1, min($limit, 500));
        $offset = max(0, $offset);

        return $this->ok($model->findAllSafe($limit, $offset), 'Order list');
    }

    public function show($id = null): ResponseInterface
    {
        /** @var OrderModel $model */
        $model = model(OrderModel::class);
        $row = $model->findSafe($id);

        if ($row === null) {
            return $this->failNotFoundMessage('Order not found');
        }

        return $this->ok($row, 'Order detail');
    }

    public function create(): ResponseInterface
    {
        /** @var OrderModel $model */
        $model = model(OrderModel::class);
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

        return $this->ok($model->findSafe($id), 'Order created', 201);
    }

    public function update($id = null): ResponseInterface
    {
        /** @var OrderModel $model */
        $model = model(OrderModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Order not found');
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

        return $this->ok($model->findSafe($id), 'Order updated');
    }

    public function delete($id = null): ResponseInterface
    {
        /** @var OrderModel $model */
        $model = model(OrderModel::class);

        if ($model->find($id) === null) {
            return $this->failNotFoundMessage('Order not found');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            return $this->failServer($e->getMessage());
        }

        return $this->ok(null, 'Order deleted');
    }
}