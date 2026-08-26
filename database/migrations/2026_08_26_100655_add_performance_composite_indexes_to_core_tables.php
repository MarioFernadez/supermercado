<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Sales Indexes
        Schema::table('sales', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'idx_sales_status_created');
            $table->index(['branch_id', 'status', 'created_at'], 'idx_sales_branch_status_created');
            $table->index(['user_id', 'created_at'], 'idx_sales_user_created');
        });

        // 2. Sale Items Indexes
        Schema::table('sale_items', function (Blueprint $table) {
            $table->index(['sale_id', 'product_id'], 'idx_sale_items_sale_product');
        });

        // 3. Products Indexes
        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'category_id'], 'idx_products_active_category');
            $table->index(['is_active', 'manage_stock', 'stock'], 'idx_products_stock_alerts');
        });

        // 4. Customers Indexes
        Schema::table('customers', function (Blueprint $table) {
            $table->index(['is_active', 'name'], 'idx_customers_active_name');
        });

        // 5. Cash Sessions Indexes
        Schema::table('cash_sessions', function (Blueprint $table) {
            $table->index(['status', 'user_id'], 'idx_cash_sessions_status_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex('idx_sales_status_created');
            $table->dropIndex('idx_sales_branch_status_created');
            $table->dropIndex('idx_sales_user_created');
        });

        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropIndex('idx_sale_items_sale_product');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_active_category');
            $table->dropIndex('idx_products_stock_alerts');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('idx_customers_active_name');
        });

        Schema::table('cash_sessions', function (Blueprint $table) {
            $table->dropIndex('idx_cash_sessions_status_user');
        });
    }
};
