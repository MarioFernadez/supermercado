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
        Schema::create('cash_sessions', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36); // Who opened usage
            $table->decimal('opening_amount', 15, 0); // Using 0 decimals for PYG
            $table->decimal('closing_amount', 15, 0)->nullable(); // Actual cash counted
            $table->decimal('calculated_amount', 15, 0)->nullable(); // System calculated total
            $table->decimal('difference', 15, 0)->nullable(); // closing - calculated
            $table->timestamp('opened_at');
            $table->timestamp('closed_at')->nullable();
            $table->string('status')->default('open'); // open, closed
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_sessions');
    }
};
