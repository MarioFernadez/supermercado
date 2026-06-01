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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('amount');
            $table->string('cheque_number')->nullable()->after('bank_name');
            $table->date('due_date')->nullable()->after('cheque_number');
            // We can't easily modify enum in MySQL without raw SQL or doctrine/dbal. 
            // For simplicity and since Laravel enums in migration are just strings on some DBs or fixed on others:
            // If it's MySQL, it validates. 
            // Let's just change the column to string to allow any method, or raw modify.
            // A safer approach for existing data is to just ensure the application logic handles 'cheque'.
            // But if the DB enforces ENUM, we must update it.
            // Let's try to modify the column to string to be flexible, or raw alter.
            
            // For MySQL specifically to add value to ENUM:
            // DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('efectivo', 'tarjeta', 'transferencia', 'qr', 'cheque') NOT NULL DEFAULT 'efectivo'");
        });

        if (\Illuminate\Support\Facades\DB::getDriverName() !== 'sqlite') {
            // Use raw statement to update ENUM if using MySQL/MariaDB
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('efectivo', 'tarjeta', 'transferencia', 'qr', 'multiple', 'cheque') NOT NULL DEFAULT 'efectivo'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'cheque_number', 'due_date']);
        });
        // Revert ENUM if needed, but usually safe to leave extended.
    }
};
