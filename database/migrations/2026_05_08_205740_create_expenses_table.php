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
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('expense_category_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('cash_session_id')->nullable()->constrained();
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->date('date');
            $table->string('payment_method'); // efectivo, transferencia, tarjeta, etc.
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
