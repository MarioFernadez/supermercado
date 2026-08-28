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
            'top_bar_enabled' => [
                'value' => '0',
                'description' => 'Habilitar o deshabilitar la barra superior en el e-commerce'
            ],
            'top_bar_text' => [
                'value' => '¿No querés pagar con tarjeta? ¡No hay problema! Elegí Pago en Puerta para pagar al momento de recibir tu pedido. <a href="#" class="underline hover:opacity-80">Más información sobre formas de pago.</a>',
                'description' => 'Texto que se muestra en la barra superior'
            ],
            'top_bar_bg_color' => [
                'value' => '#002f6c',
                'description' => 'Color de fondo en formato HEX para la barra superior'
            ],
            'top_bar_text_color' => [
                'value' => '#ffffff',
                'description' => 'Color del texto en formato HEX para la barra superior'
            ],
            'shop_primary_color' => [
                'value' => '#4f46e5',
                'description' => 'Color primario de marca para el e-commerce'
            ],
            'shop_primary_color_hover' => [
                'value' => '#4338ca',
                'description' => 'Color de marca primario para el estado hover'
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
            'top_bar_enabled',
            'top_bar_text',
            'top_bar_bg_color',
            'top_bar_text_color',
            'shop_primary_color',
            'shop_primary_color_hover',
        ])->delete();
    }
};
