<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Alquiler', 'description' => 'Pago de local comercial'],
            ['name' => 'Servicios Públicos', 'description' => 'ANDE, ESSAP, Internet'],
            ['name' => 'Sueldos y Jornales', 'description' => 'Pago a personal'],
            ['name' => 'Impuestos', 'description' => 'IVA, IRE, etc.'],
            ['name' => 'Mantenimiento', 'description' => 'Reparaciones y limpieza'],
            ['name' => 'Insumos de Oficina', 'description' => 'Papelería, tinta, etc.'],
            ['name' => 'Marketing', 'description' => 'Publicidad en redes sociales'],
            ['name' => 'Varios', 'description' => 'Otros gastos menores'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
