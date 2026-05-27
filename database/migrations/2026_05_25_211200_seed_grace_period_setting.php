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
            ['key' => 'license_grace_period_used'],
            [
                'value' => '0',
                'description' => 'Determina si el comercio ya utilizó el comodín de gracia por emergencia de 3 días en el ciclo actual'
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        StoreSetting::where('key', 'license_grace_period_used')->delete();
    }
};
