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
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('customer_id', 36);
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->enum('type', ['debit', 'credit']); // debit = increases debt (sale), credit = decreases debt (payment)
            $table->decimal('amount', 15, 0); // PYG
            $table->string('reference_type')->nullable(); // sale, payment
            $table->char('reference_id', 36)->nullable(); 
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->index(['customer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_transactions');
    }
};
