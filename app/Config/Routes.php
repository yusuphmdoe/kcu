<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('api', ['filter' => 'cors'], static function ($routes) {
    $routes->options('(:any)', static function () {
        return service('response')->setStatusCode(204);
    });

    // Public auth endpoints
    $routes->post('auth/login', 'Api\AuthController::login');

    // Protected API
    $routes->group('', ['filter' => 'jwt'], static function ($routes) {
        $routes->get('auth/me', 'Api\AuthController::me');
        $routes->get('/', 'Api\HomeController::index');

        $routes->resource('accessors', ['controller' => 'Api\\AccessorController', 'except' => ['new', 'edit']]);
        $routes->resource('backups', ['controller' => 'Api\\BackupController', 'except' => ['new', 'edit']]);
        $routes->resource('callbacks', ['controller' => 'Api\\CallbackController', 'except' => ['new', 'edit']]);
        $routes->resource('callback-details', ['controller' => 'Api\\CallbackDetailController', 'except' => ['new', 'edit']]);
        $routes->resource('clothing-parts', ['controller' => 'Api\\ClothingPartController', 'except' => ['new', 'edit']]);
        $routes->resource('clothings', ['controller' => 'Api\\ClothingController', 'except' => ['new', 'edit']]);
        $routes->resource('companies', ['controller' => 'Api\\CompanyController', 'except' => ['new', 'edit']]);
        $routes->resource('custom-orders', ['controller' => 'Api\\CustomOrderController', 'except' => ['new', 'edit']]);
        $routes->resource('customer-contacts', ['controller' => 'Api\\CustomerContactController', 'except' => ['new', 'edit']]);
        $routes->resource('customers', ['controller' => 'Api\\CustomerController', 'except' => ['new', 'edit']]);
        $routes->resource('cuttings', ['controller' => 'Api\\CuttingController', 'except' => ['new', 'edit']]);
        $routes->resource('expense-categories', ['controller' => 'Api\\ExpenseCategoryController', 'except' => ['new', 'edit']]);
        $routes->resource('expenses', ['controller' => 'Api\\ExpenseController', 'except' => ['new', 'edit']]);
        $routes->resource('fittings', ['controller' => 'Api\\FittingController', 'except' => ['new', 'edit']]);
        $routes->resource('invoices', ['controller' => 'Api\\InvoiceController', 'except' => ['new', 'edit']]);
        $routes->resource('issue-details', ['controller' => 'Api\\IssueDetailController', 'except' => ['new', 'edit']]);
        $routes->resource('issues', ['controller' => 'Api\\IssueController', 'except' => ['new', 'edit']]);
        $routes->resource('marketing', ['controller' => 'Api\\MarketingController', 'except' => ['new', 'edit']]);
        $routes->resource('marketing-categories', ['controller' => 'Api\\MarketingCategoryController', 'except' => ['new', 'edit']]);
        $routes->resource('materials', ['controller' => 'Api\\MaterialController', 'except' => ['new', 'edit']]);
        $routes->resource('measurements', ['controller' => 'Api\\MeasurementController', 'except' => ['new', 'edit']]);
        $routes->resource('notifications', ['controller' => 'Api\\NotificationController', 'except' => ['new', 'edit']]);
        $routes->resource('order-details', ['controller' => 'Api\\OrderDetailController', 'except' => ['new', 'edit']]);
        $routes->resource('orders', ['controller' => 'Api\\OrderController', 'except' => ['new', 'edit']]);
        $routes->resource('parts', ['controller' => 'Api\\PartController', 'except' => ['new', 'edit']]);
        $routes->resource('payment-modes', ['controller' => 'Api\\PaymentModeController', 'except' => ['new', 'edit']]);
        $routes->resource('product-categories', ['controller' => 'Api\\ProductCategoryController', 'except' => ['new', 'edit']]);
        $routes->resource('products', ['controller' => 'Api\\ProductController', 'except' => ['new', 'edit']]);
        $routes->resource('purchase-details', ['controller' => 'Api\\PurchaseDetailController', 'except' => ['new', 'edit']]);
        $routes->resource('purchases', ['controller' => 'Api\\PurchaseController', 'except' => ['new', 'edit']]);
        $routes->resource('quotes', ['controller' => 'Api\\QuoteController', 'except' => ['new', 'edit']]);
        $routes->resource('receipts', ['controller' => 'Api\\ReceiptController', 'except' => ['new', 'edit']]);
        $routes->resource('sizes', ['controller' => 'Api\\SizeController', 'except' => ['new', 'edit']]);
        $routes->resource('supplier-contacts', ['controller' => 'Api\\SupplierContactController', 'except' => ['new', 'edit']]);
        $routes->resource('suppliers', ['controller' => 'Api\\SupplierController', 'except' => ['new', 'edit']]);
        $routes->resource('tailoring', ['controller' => 'Api\\TailoringController', 'except' => ['new', 'edit']]);
        $routes->resource('tailors', ['controller' => 'Api\\TailorController', 'except' => ['new', 'edit']]);
        $routes->resource('units', ['controller' => 'Api\\UnitController', 'except' => ['new', 'edit']]);
        $routes->resource('users', ['controller' => 'Api\\UserController', 'except' => ['new', 'edit']]);
    });
});
