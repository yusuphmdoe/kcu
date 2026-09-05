<?php

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Full KCU schema for API feature tests (SQLite-friendly, no FK constraints).
 */
class CreateKcuApiSchema extends Migration
{
    protected $DBGroup = 'tests';

    public function up(): void
    {
        $timestamps = [
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'fund_teaching' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'unit_cost' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'access_date' => ['type' => 'DATE', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('accessors', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'backup_date' => ['type' => 'DATE', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('backups', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 200],
            'address' => ['type' => 'TEXT', 'null' => true],
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'website' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tin' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'VRN' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'banking_details' => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('companies', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'address' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('customers', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'customer_id' => ['type' => 'INTEGER'],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'gender' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('customer_contacts', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('expense_categories', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('marketing_categories', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'action' => ['type' => 'VARCHAR', 'constraint' => 100],
            'type_of' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('notifications', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('parts', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('payment_modes', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('product_categories', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'abbreviation' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'type' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sizes', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'abbreviation' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('units', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'address' => ['type' => 'TEXT', 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 150],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('suppliers', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'supplier_id' => ['type' => 'INTEGER'],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => 20],
            'gender' => ['type' => 'VARCHAR', 'constraint' => 10],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('supplier_contacts', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'type' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'product_category_id' => ['type' => 'INTEGER', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tailors', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
            'category_id' => ['type' => 'INTEGER'],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('clothings', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'clothing_id' => ['type' => 'INTEGER'],
            'part_id' => ['type' => 'INTEGER'],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('clothing_parts', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'unit_id' => ['type' => 'INTEGER', 'null' => true],
            'reorder_level' => ['type' => 'INTEGER', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('materials', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'clothing_id' => ['type' => 'INTEGER', 'null' => true],
            'material_id' => ['type' => 'INTEGER'],
            'price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'unit_id' => ['type' => 'INTEGER', 'null' => true],
            'size_id' => ['type' => 'INTEGER'],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('products', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'customer_id' => ['type' => 'INTEGER', 'null' => true],
            'customer_conact_id' => ['type' => 'INTEGER'],
            'order_date' => ['type' => 'DATE', 'null' => true],
            'due_date' => ['type' => 'DATE', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'total_amount' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('orders', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'order_id' => ['type' => 'INTEGER', 'null' => true],
            'product_id' => ['type' => 'INTEGER', 'null' => true],
            'quantity' => ['type' => 'INTEGER'],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('order_details', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'order_details_id' => ['type' => 'INTEGER', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('custom_orders', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'custom_order_id' => ['type' => 'INTEGER'],
            'part_id' => ['type' => 'INTEGER'],
            'measurement_value' => ['type' => 'DECIMAL', 'constraint' => '8,2'],
            'unit_id' => ['type' => 'INTEGER'],
            'notes' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('measurements', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'order_id' => ['type' => 'INTEGER', 'null' => true],
            'quote_date' => ['type' => 'DATE', 'null' => true],
            'valid_until' => ['type' => 'DATE', 'null' => true],
            'total_amount' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('quotes', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'quote_id' => ['type' => 'INTEGER', 'null' => true],
            'invoice_date' => ['type' => 'DATE', 'null' => true],
            'due_date' => ['type' => 'DATE', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('invoices', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'invoice_id' => ['type' => 'INTEGER', 'null' => true],
            'amount_paid' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'payment_mode_id' => ['type' => 'INTEGER', 'null' => true],
            'receipt_date' => ['type' => 'DATE', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('receipts', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'supplier_id' => ['type' => 'INTEGER', 'null' => true],
            'purchase_date' => ['type' => 'DATE', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('purchases', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'purchase_id' => ['type' => 'INTEGER', 'null' => true],
            'material_id' => ['type' => 'INTEGER', 'null' => true],
            'quantity' => ['type' => 'INTEGER', 'null' => true],
            'unit_cost' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('purchase_details', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'order_id' => ['type' => 'INTEGER', 'null' => true],
            'tailor_id' => ['type' => 'INTEGER', 'null' => true],
            'quantity_used' => ['type' => 'INTEGER', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('cuttings', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'order_id' => ['type' => 'INTEGER', 'null' => true],
            'fitting_date' => ['type' => 'DATE', 'null' => true],
            'feedback' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('fittings', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'order_id' => ['type' => 'INTEGER', 'null' => true],
            'tailor_id' => ['type' => 'INTEGER', 'null' => true],
            'start_stage' => ['type' => 'DATE', 'null' => true],
            'end_stage' => ['type' => 'DATE', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tailoring', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'material_id' => ['type' => 'INTEGER', 'null' => true],
            'order_id' => ['type' => 'INTEGER', 'null' => true],
            'issue_date' => ['type' => 'DATE', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('issues', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'issue_id' => ['type' => 'INTEGER', 'null' => true],
            'material_id' => ['type' => 'INTEGER', 'null' => true],
            'quantity' => ['type' => 'INTEGER', 'null' => true],
            'tailor_id' => ['type' => 'INTEGER', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('issue_details', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'category_id' => ['type' => 'INTEGER', 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'payment_mode_id' => ['type' => 'INTEGER', 'null' => true],
            'expense_date' => ['type' => 'DATE', 'null' => true],
            'payee' => ['type' => 'VARCHAR', 'constraint' => 50],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('expenses', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'start_stage' => ['type' => 'DATE', 'null' => true],
            'end_stage' => ['type' => 'DATE', 'null' => true],
            'budget' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'marketing_category' => ['type' => 'INTEGER', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('marketing', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'tailor_id' => ['type' => 'INTEGER', 'null' => true],
            'callback_date' => ['type' => 'DATE', 'null' => true],
            'reason' => ['type' => 'TEXT', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('callbacks', true);

        $this->forge->addField(array_merge([
            'id' => ['type' => 'INTEGER', 'auto_increment' => true],
            'material_id' => ['type' => 'INTEGER', 'null' => true],
            'quantity' => ['type' => 'INTEGER', 'null' => true],
            'callback_id' => ['type' => 'INTEGER', 'null' => true],
        ], $timestamps));
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('callback_details', true);
    }

    public function down(): void
    {
        $tables = [
            'callback_details', 'callbacks', 'marketing', 'expenses', 'issue_details', 'issues',
            'tailoring', 'fittings', 'cuttings', 'purchase_details', 'purchases', 'receipts',
            'invoices', 'quotes', 'measurements', 'custom_orders', 'order_details', 'orders',
            'products', 'materials', 'clothing_parts', 'clothings', 'tailors', 'supplier_contacts',
            'suppliers', 'users', 'units', 'sizes', 'product_categories', 'payment_modes', 'parts',
            'notifications', 'marketing_categories', 'expense_categories', 'customer_contacts',
            'customers', 'companies', 'backups', 'accessors',
        ];

        foreach ($tables as $table) {
            $this->forge->dropTable($table, true);
        }
    }
}