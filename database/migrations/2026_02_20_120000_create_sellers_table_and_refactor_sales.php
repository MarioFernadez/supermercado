<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create sellers table
        Schema::create('sellers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Add seller_id to sales and drop old salesperson_id
        Schema::table('sales', function (Blueprint $table) {
            $table->uuid('seller_id')->nullable()->after('user_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->nullOnDelete();
        });

        // Drop old salesperson FK + column (if exists)
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'salesperson_id')) {
                if (\Illuminate\Support\Facades\DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign(['salesperson_id']);
                }
                $table->dropColumn('salesperson_id');
            }
        });

        // 3. Remove is_salesperson from users (if exists)
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_salesperson')) {
                $table->dropColumn('is_salesperson');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_salesperson')->default(false)->after('role');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn('seller_id');
            $table->char('salesperson_id', 36)->nullable()->after('user_id');
            $table->foreign('salesperson_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::dropIfExists('sellers');
    }
};
