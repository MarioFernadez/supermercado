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
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_type', 50)->default('standard')->after('id');
            $table->boolean('is_raw_material')->default(false)->after('product_type');
        });

        // Insert business_type generic if not exists
        \Illuminate\Support\Facades\DB::table('store_settings')->updateOrInsert(
            ['key' => 'business_type'],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'value' => 'generic', 
                'description' => 'Tipo de Negocio del Sistema',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_type', 'is_raw_material']);
        });
    }
};
