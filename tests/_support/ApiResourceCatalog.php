<?php

namespace Tests\Support;

final class ApiResourceCatalog
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return array (
  'accessors' => 
  array (
    'create' => 
    array (
      'fund_teaching' => 'Training Fund',
      'unit_cost' => 10.5,
      'access_date' => '2026-01-01',
      'status' => 'active',
    ),
    'update' => 
    array (
      'status' => 'inactive',
    ),
    'depends' => 
    array (
    ),
  ),
  'backups' => 
  array (
    'create' => 
    array (
      'backup_date' => '2026-01-01',
    ),
    'update' => 
    array (
      'backup_date' => '2026-01-02',
    ),
    'depends' => 
    array (
    ),
  ),
  'companies' => 
  array (
    'create' => 
    array (
      'name' => 'KCU Co',
      'address' => 'Dar',
      'phone_number' => '0700',
      'email' => 'co@test.com',
      'website' => NULL,
      'logo' => NULL,
      'tin' => '123',
      'VRN' => '456',
      'banking_details' => 'Bank',
    ),
    'update' => 
    array (
      'name' => 'KCU Updated',
    ),
    'depends' => 
    array (
    ),
  ),
  'customers' => 
  array (
    'create' => 
    array (
      'phone_number' => '0711111111',
      'address' => 'Arusha',
      'email' => 'cust@test.com',
    ),
    'update' => 
    array (
      'address' => 'Moshi',
    ),
    'depends' => 
    array (
    ),
  ),
  'expense-categories' => 
  array (
    'create' => 
    array (
      'name' => 'Office',
      'description' => 'Office costs',
    ),
    'update' => 
    array (
      'name' => 'Ops',
    ),
    'depends' => 
    array (
    ),
  ),
  'marketing-categories' => 
  array (
    'create' => 
    array (
      'name' => 'Digital',
      'description' => 'Online',
    ),
    'update' => 
    array (
      'name' => 'Social',
    ),
    'depends' => 
    array (
    ),
  ),
  'notifications' => 
  array (
    'create' => 
    array (
      'action' => 'order.created',
      'type_of' => 'info',
    ),
    'update' => 
    array (
      'type_of' => 'alert',
    ),
    'depends' => 
    array (
    ),
  ),
  'parts' => 
  array (
    'create' => 
    array (
      'name' => 'Sleeve',
      'description' => 'Arm sleeve',
    ),
    'update' => 
    array (
      'name' => 'Cuff',
    ),
    'depends' => 
    array (
    ),
  ),
  'payment-modes' => 
  array (
    'create' => 
    array (
      'name' => 'Cash',
      'description' => 'Cash payment',
    ),
    'update' => 
    array (
      'name' => 'MPesa',
    ),
    'depends' => 
    array (
    ),
  ),
  'product-categories' => 
  array (
    'create' => 
    array (
      'name' => 'Uniforms',
      'description' => 'School',
    ),
    'update' => 
    array (
      'name' => 'Corporate',
    ),
    'depends' => 
    array (
    ),
  ),
  'sizes' => 
  array (
    'create' => 
    array (
      'name' => 'Large',
      'abbreviation' => 'L',
      'type' => 'alpha',
    ),
    'update' => 
    array (
      'abbreviation' => 'XL',
    ),
    'depends' => 
    array (
    ),
  ),
  'units' => 
  array (
    'create' => 
    array (
      'name' => 'Meter',
      'abbreviation' => 'm',
    ),
    'update' => 
    array (
      'abbreviation' => 'mtr',
    ),
    'depends' => 
    array (
    ),
  ),
  'users' => 
  array (
    'create' => 
    array (
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'user@test.com',
      'password' => 'Secret123!',
      'role' => 'staff',
      'status' => 'active',
    ),
    'update' => 
    array (
      'first_name' => 'Updated',
    ),
    'depends' => 
    array (
    ),
    'assert_hidden' => 
    array (
      0 => 'password',
    ),
  ),
  'suppliers' => 
  array (
    'create' => 
    array (
      'name' => 'Fabric Ltd',
      'phone' => '0722',
      'password' => 'Secret123!',
      'email' => 'sup@test.com',
      'address' => 'Nairobi',
      'location' => 'Kenya',
    ),
    'update' => 
    array (
      'location' => 'TZ',
    ),
    'depends' => 
    array (
    ),
    'assert_hidden' => 
    array (
      0 => 'password',
    ),
  ),
  'tailors' => 
  array (
    'create' => 
    array (
      'first_name' => 'Ali',
      'last_name' => 'Tailor',
      'phone_number' => '0733',
      'email' => 'tailor@test.com',
      'type' => 'tailor',
      'product_category_id' => NULL,
      'status' => 'active',
    ),
    'update' => 
    array (
      'status' => 'inactive',
    ),
    'depends' => 
    array (
    ),
  ),
  'customer-contacts' => 
  array (
    'create' => 
    array (
      'customer_id' => '{{customers}}',
      'first_name' => 'Jane',
      'last_name' => 'Doe',
      'phone_number' => '0744',
      'email' => 'jane@test.com',
      'gender' => 'female',
    ),
    'update' => 
    array (
      'last_name' => 'Smith',
    ),
    'depends' => 
    array (
      0 => 'customers',
    ),
  ),
  'clothings' => 
  array (
    'create' => 
    array (
      'name' => 'Shirt',
      'description' => 'Formal',
      'category_id' => '{{product-categories}}',
    ),
    'update' => 
    array (
      'name' => 'Blouse',
    ),
    'depends' => 
    array (
      0 => 'product-categories',
    ),
  ),
  'materials' => 
  array (
    'create' => 
    array (
      'name' => 'Cotton',
      'description' => 'Soft',
      'unit_id' => '{{units}}',
      'reorder_level' => 5,
    ),
    'update' => 
    array (
      'reorder_level' => 10,
    ),
    'depends' => 
    array (
      0 => 'units',
    ),
  ),
  'supplier-contacts' => 
  array (
    'create' => 
    array (
      'supplier_id' => '{{suppliers}}',
      'first_name' => 'Sam',
      'last_name' => 'Supplier',
      'email' => 'sam@test.com',
      'phone_number' => '0755',
      'gender' => 'male',
    ),
    'update' => 
    array (
      'last_name' => 'Lead',
    ),
    'depends' => 
    array (
      0 => 'suppliers',
    ),
  ),
  'clothing-parts' => 
  array (
    'create' => 
    array (
      'clothing_id' => '{{clothings}}',
      'part_id' => '{{parts}}',
    ),
    'update' => 
    array (
    ),
    'depends' => 
    array (
      0 => 'clothings',
      1 => 'parts',
    ),
    'skip_update_assert' => true,
  ),
  'products' => 
  array (
    'create' => 
    array (
      'name' => 'School Shirt',
      'description' => 'White',
      'clothing_id' => '{{clothings}}',
      'material_id' => '{{materials}}',
      'price' => 25000,
      'unit_id' => '{{units}}',
      'size_id' => '{{sizes}}',
    ),
    'update' => 
    array (
      'price' => 30000,
    ),
    'depends' => 
    array (
      0 => 'clothings',
      1 => 'materials',
      2 => 'units',
      3 => 'sizes',
    ),
  ),
  'orders' => 
  array (
    'create' => 
    array (
      'customer_id' => '{{customers}}',
      'customer_conact_id' => '{{customer-contacts}}',
      'order_date' => '2026-01-10',
      'due_date' => '2026-01-20',
      'status' => 'pending',
      'total_amount' => 50000,
    ),
    'update' => 
    array (
      'status' => 'processing',
    ),
    'depends' => 
    array (
      0 => 'customers',
      1 => 'customer-contacts',
    ),
  ),
  'order-details' => 
  array (
    'create' => 
    array (
      'order_id' => '{{orders}}',
      'product_id' => '{{products}}',
      'quantity' => 2,
    ),
    'update' => 
    array (
      'quantity' => 3,
    ),
    'depends' => 
    array (
      0 => 'orders',
      1 => 'products',
    ),
  ),
  'custom-orders' => 
  array (
    'create' => 
    array (
      'name' => 'Custom Fit',
      'order_details_id' => '{{order-details}}',
    ),
    'update' => 
    array (
      'name' => 'Custom Fit 2',
    ),
    'depends' => 
    array (
      0 => 'order-details',
    ),
  ),
  'measurements' => 
  array (
    'create' => 
    array (
      'custom_order_id' => '{{custom-orders}}',
      'part_id' => '{{parts}}',
      'measurement_value' => 42.5,
      'unit_id' => '{{units}}',
      'notes' => 'Chest',
    ),
    'update' => 
    array (
      'measurement_value' => 43,
    ),
    'depends' => 
    array (
      0 => 'custom-orders',
      1 => 'parts',
      2 => 'units',
    ),
  ),
  'quotes' => 
  array (
    'create' => 
    array (
      'order_id' => '{{orders}}',
      'quote_date' => '2026-01-11',
      'valid_until' => '2026-01-18',
      'total_amount' => 50000,
      'status' => 'pending',
    ),
    'update' => 
    array (
      'status' => 'approved',
    ),
    'depends' => 
    array (
      0 => 'orders',
    ),
  ),
  'invoices' => 
  array (
    'create' => 
    array (
      'quote_id' => '{{quotes}}',
      'invoice_date' => '2026-01-12',
      'due_date' => '2026-01-25',
    ),
    'update' => 
    array (
      'due_date' => '2026-01-30',
    ),
    'depends' => 
    array (
      0 => 'quotes',
    ),
  ),
  'receipts' => 
  array (
    'create' => 
    array (
      'invoice_id' => '{{invoices}}',
      'amount_paid' => 20000,
      'payment_mode_id' => '{{payment-modes}}',
      'receipt_date' => '2026-01-13',
    ),
    'update' => 
    array (
      'amount_paid' => 25000,
    ),
    'depends' => 
    array (
      0 => 'invoices',
      1 => 'payment-modes',
    ),
  ),
  'purchases' => 
  array (
    'create' => 
    array (
      'supplier_id' => '{{suppliers}}',
      'purchase_date' => '2026-01-05',
      'status' => 'pending',
    ),
    'update' => 
    array (
      'status' => 'approved',
    ),
    'depends' => 
    array (
      0 => 'suppliers',
    ),
  ),
  'purchase-details' => 
  array (
    'create' => 
    array (
      'purchase_id' => '{{purchases}}',
      'material_id' => '{{materials}}',
      'quantity' => 10,
      'unit_cost' => 1500,
    ),
    'update' => 
    array (
      'quantity' => 12,
    ),
    'depends' => 
    array (
      0 => 'purchases',
      1 => 'materials',
    ),
  ),
  'cuttings' => 
  array (
    'create' => 
    array (
      'order_id' => '{{orders}}',
      'tailor_id' => '{{tailors}}',
      'quantity_used' => 3,
    ),
    'update' => 
    array (
      'quantity_used' => 4,
    ),
    'depends' => 
    array (
      0 => 'orders',
      1 => 'tailors',
    ),
  ),
  'fittings' => 
  array (
    'create' => 
    array (
      'order_id' => '{{orders}}',
      'fitting_date' => '2026-01-15',
      'feedback' => 'Good',
    ),
    'update' => 
    array (
      'feedback' => 'Needs tweak',
    ),
    'depends' => 
    array (
      0 => 'orders',
    ),
  ),
  'tailoring' => 
  array (
    'create' => 
    array (
      'order_id' => '{{orders}}',
      'tailor_id' => '{{tailors}}',
      'start_stage' => '2026-01-14',
      'end_stage' => '2026-01-16',
      'status' => 'pending',
    ),
    'update' => 
    array (
      'status' => 'in_progress',
    ),
    'depends' => 
    array (
      0 => 'orders',
      1 => 'tailors',
    ),
  ),
  'issues' => 
  array (
    'create' => 
    array (
      'material_id' => '{{materials}}',
      'order_id' => '{{orders}}',
      'issue_date' => '2026-01-14',
    ),
    'update' => 
    array (
      'issue_date' => '2026-01-15',
    ),
    'depends' => 
    array (
      0 => 'materials',
      1 => 'orders',
    ),
  ),
  'issue-details' => 
  array (
    'create' => 
    array (
      'issue_id' => '{{issues}}',
      'material_id' => '{{materials}}',
      'quantity' => 1,
      'tailor_id' => '{{tailors}}',
    ),
    'update' => 
    array (
      'quantity' => 2,
    ),
    'depends' => 
    array (
      0 => 'issues',
      1 => 'materials',
      2 => 'tailors',
    ),
  ),
  'expenses' => 
  array (
    'create' => 
    array (
      'category_id' => '{{expense-categories}}',
      'description' => 'Transport',
      'amount' => 5000,
      'payment_mode_id' => '{{payment-modes}}',
      'expense_date' => '2026-01-09',
      'payee' => 'Driver',
    ),
    'update' => 
    array (
      'amount' => 6000,
    ),
    'depends' => 
    array (
      0 => 'expense-categories',
      1 => 'payment-modes',
    ),
  ),
  'marketing' => 
  array (
    'create' => 
    array (
      'name' => 'Promo',
      'start_stage' => '2026-01-01',
      'end_stage' => '2026-01-31',
      'budget' => 100000,
      'type' => 'campaign',
      'marketing_category' => '{{marketing-categories}}',
    ),
    'update' => 
    array (
      'budget' => 120000,
    ),
    'depends' => 
    array (
      0 => 'marketing-categories',
    ),
  ),
  'callbacks' => 
  array (
    'create' => 
    array (
      'tailor_id' => '{{tailors}}',
      'callback_date' => '2026-01-17',
      'reason' => 'Return fabric',
    ),
    'update' => 
    array (
      'reason' => 'Excess fabric',
    ),
    'depends' => 
    array (
      0 => 'tailors',
    ),
  ),
  'callback-details' => 
  array (
    'create' => 
    array (
      'material_id' => '{{materials}}',
      'quantity' => 2,
      'callback_id' => '{{callbacks}}',
    ),
    'update' => 
    array (
      'quantity' => 3,
    ),
    'depends' => 
    array (
      0 => 'materials',
      1 => 'callbacks',
    ),
  ),
);
    }

    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return array_keys(self::all());
    }
}
