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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->char('product_id', 36);
            $table->char('user_id', 36)->nullable(); // User who made the manual adjustment
            $table->enum('type', ['in', 'out'])->default('in'); // 'in' = entrada, 'out' = salida
            $table->integer('quantity'); // Quantity added or removed
            $table->string('reason')->nullable(); // e.g. 'mermas', 'roturas', 'obsequios', 'ingreso manual'
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
