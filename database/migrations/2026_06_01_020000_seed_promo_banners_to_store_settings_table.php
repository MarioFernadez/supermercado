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
        $settings = [
            'promo_banner_1_path' => [
                'value' => '',
                'description' => 'Ruta de la imagen del banner promocional izquierdo (ancho)'
            ],
            'promo_banner_1_link' => [
                'value' => '#',
                'description' => 'Enlace de redirección del banner promocional izquierdo'
            ],
            'promo_banner_2_path' => [
                'value' => '',
                'description' => 'Ruta de la imagen del banner promocional derecho (angosto)'
            ],
            'promo_banner_2_link' => [
                'value' => '#',
                'description' => 'Enlace de redirección del banner promocional derecho'
            ],
        ];

        foreach ($settings as $key => $data) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'description' => $data['description']
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        StoreSetting::whereIn('key', [
            'promo_banner_1_path',
            'promo_banner_1_link',
            'promo_banner_2_path',
            'promo_banner_2_link',
        ])->delete();
    }
};
