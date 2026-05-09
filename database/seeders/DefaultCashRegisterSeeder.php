<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashRegister;

class DefaultCashRegisterSeeder extends Seeder
{
    public function run(): void
    {
        CashRegister::firstOrCreate(
            ['name' => 'Caja Principal'],
            [
                'active' => true, 
                'description' => 'Caja por defecto del sistema'
            ]
        );
    }
}
