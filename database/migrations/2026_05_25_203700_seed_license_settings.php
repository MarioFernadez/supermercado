<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\StoreSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        StoreSetting::updateOrCreate(
            ['key' => 'license_enabled_at'],
            [
                'value' => now()->format('Y-m-d'),
                'description' => 'Fecha de habilitación inicial del sistema'
            ]
        );

        StoreSetting::updateOrCreate(
            ['key' => 'license_expires_at'],
            [
                'value' => now()->addMonth()->format('Y-m-d'),
                'description' => 'Fecha de vencimiento actual de la licencia del sistema'
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        StoreSetting::whereIn('key', ['license_enabled_at', 'license_expires_at'])->delete();
    }
};
