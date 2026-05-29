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
        Schema::create('branch_stocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->uuidMorphs('stockable'); // creates stockable_id and stockable_type
            $table->decimal('stock', 12, 3)->default(0);
            $table->timestamps();

            $table->unique(['branch_id', 'stockable_id', 'stockable_type'], 'branch_stock_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_stocks');
    }
};
