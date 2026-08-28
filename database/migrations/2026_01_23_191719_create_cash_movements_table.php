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
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('cash_session_id', 36);
            $table->string('type'); // in, out
            $table->decimal('amount', 15, 0); // PYG
            $table->string('description')->nullable();
            $table->string('reference')->nullable(); // Optional external ref
            $table->timestamps();

            $table->foreign('cash_session_id')->references('id')->on('cash_sessions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};
