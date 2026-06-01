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
        Schema::create('payments', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('sale_id', 36);
            if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
                $table->string('method')->default('efectivo');
            } else {
                $table->enum('method', ['efectivo', 'tarjeta', 'transferencia', 'qr'])->default('efectivo');
            }
            $table->bigInteger('amount');
            $table->timestamps();
            
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
