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
        Schema::create('deboning_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('deboning_session_id');
            $table->uuid('product_id'); // The obtained cut (e.g. Asado)
            $table->decimal('weight', 10, 3)->default(0); // Kg obtained
            $table->timestamps();

            $table->foreign('deboning_session_id')->references('id')->on('deboning_sessions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deboning_items');
    }
};
