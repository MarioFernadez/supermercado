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
        Schema::create('deboning_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('raw_material_product_id'); // FK to products (Materia Prima)
            $table->uuid('user_id'); // Carnicero/Usuario
            $table->decimal('total_weight_start', 10, 3)->default(0); // Kg of raw material used
            $table->decimal('total_weight_yield', 10, 3)->default(0); // Sum of obtained cuts
            $table->decimal('waste_weight', 10, 3)->default(0); // Merma
            $table->string('status')->default('completed'); // draft, completed
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('raw_material_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deboning_sessions');
    }
};
