<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_salesperson')->default(false)->after('role');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->char('salesperson_id', 36)->nullable()->after('user_id');
            $table->foreign('salesperson_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['salesperson_id']);
            $table->dropColumn('salesperson_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_salesperson');
        });
    }
};
