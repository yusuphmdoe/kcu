<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseApiController
{
    public function index(): ResponseInterface
    {
        $resources = [
            'accessors',
            'backups',
            'callbacks',
            'callback-details',
            'clothing-parts',
            'clothings',
            'companies',
            'custom-orders',
            'customer-contacts',
            'customers',
            'cuttings',
            'expense-categories',
            'expenses',
            'fittings',
            'invoices',
            'issue-details',
            'issues',
            'marketing',
            'marketing-categories',
            'materials',
            'measurements',
            'notifications',
            'order-details',
            'orders',
            'parts',
            'payment-modes',
            'product-categories',
            'products',
            'purchase-details',
            'purchases',
            'quotes',
            'receipts',
            'sizes',
            'supplier-contacts',
            'suppliers',
            'tailoring',
            'tailors',
            'units',
            'users',
        ];

        $base = rtrim(base_url('api'), '/') . '/';

        return $this->ok([
            'name'      => 'KCU API',
            'version'   => '1.0',
            'auth'      => [
                'login'  => $base . 'auth/login',
                'me'     => $base . 'auth/me',
                'header' => 'Authorization: Bearer {access_token}',
            ],
            'endpoints' => array_map(static fn (string $r): array => [
                'resource' => $r,
                'list'     => $base . $r,
                'detail'   => $base . $r . '/{id}',
                'methods'  => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
            ], $resources),
        ], 'KCU API');
    }
}
