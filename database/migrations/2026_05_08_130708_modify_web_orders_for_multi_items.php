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
        Schema::table('web_orders', function (Blueprint $table) {
            $table->uuid('product_id')->nullable()->change();
            $table->json('items_json')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('web_orders', function (Blueprint $table) {
            $table->uuid('product_id')->nullable(false)->change();
            $table->dropColumn(['items_json', 'notes']);
        });
    }
};
