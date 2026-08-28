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
        Schema::create('sales', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('customer_id', 36)->nullable();
            $table->char('user_id', 36); // Cajero
            $table->bigInteger('total')->default(0);
            $table->bigInteger('tax_10')->default(0);
            $table->bigInteger('tax_5')->default(0);
            $table->bigInteger('tax_exempt')->default(0);
            $table->string('status')->default('completed'); // completed, cancelled
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
