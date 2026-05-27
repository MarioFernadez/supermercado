<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar registros previos para evitar duplicados en re-seeds
        User::where('email', 'admin@zonapos.com')->delete();
        
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@zonapos.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Obtener el email del developer desde la configuración (.env)
        $devEmail = config('services.developer.email') ?: 'soteweb@gmail.com';
        
        User::where('email', $devEmail)->delete();
        User::where('role', 'developer')->delete(); // Asegura limpiar cualquier otro rol developer

        User::create([
            'name' => 'Desarrollador Master',
            'email' => $devEmail,
            'password' => Hash::make('developer123'),
            'role' => 'developer',
        ]);

        $this->command->info('Usuarios iniciales creados exitosamente!');
        $this->command->info('Admin - Email: admin@zonapos.com | Password: admin123');
        $this->command->info('Developer - Email: ' . $devEmail . ' | Password: developer123');
    }
}
