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
            'benefits_enabled' => [
                'value' => '1',
                'description' => 'Habilitar barra de beneficios de compra antes del footer'
            ],
            'benefit_1_title' => [
                'value' => 'Compra segura',
                'description' => 'Título del beneficio 1'
            ],
            'benefit_1_subtitle' => [
                'value' => 'Pago protegido con encriptación SSL',
                'description' => 'Subtítulo del beneficio 1'
            ],
            'benefit_2_title' => [
                'value' => 'Envío a todo el país',
                'description' => 'Título del beneficio 2'
            ],
            'benefit_2_subtitle' => [
                'value' => 'Despachamos a todos los departamentos',
                'description' => 'Subtítulo del beneficio 2'
            ],
            'benefit_3_title' => [
                'value' => 'Cambios fáciles',
                'description' => 'Título del beneficio 3'
            ],
            'benefit_3_subtitle' => [
                'value' => '15 días para cambiar',
                'description' => 'Subtítulo del beneficio 3'
            ],
            'benefit_4_title' => [
                'value' => 'Atención al cliente',
                'description' => 'Título del beneficio 4'
            ],
            'benefit_4_subtitle' => [
                'value' => 'Soporte por WhatsApp',
                'description' => 'Subtítulo del beneficio 4'
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
            'benefits_enabled',
            'benefit_1_title',
            'benefit_1_subtitle',
            'benefit_2_title',
            'benefit_2_subtitle',
            'benefit_3_title',
            'benefit_3_subtitle',
            'benefit_4_title',
            'benefit_4_subtitle',
        ])->delete();
    }
};
