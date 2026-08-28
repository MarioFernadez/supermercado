<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add discount_percentage to products
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedTinyInteger('discount_percentage')->default(0)->after('price_sale');
        });

        // Add discount tracking to sales
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('subtotal_before_discount')->default(0)->after('total');
            $table->unsignedBigInteger('discount_amount')->default(0)->after('subtotal_before_discount');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('discount_percentage');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['subtotal_before_discount', 'discount_amount']);
        });
    }
};
