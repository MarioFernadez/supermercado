<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StoreSetting;

class ManageLicense extends Command
{
    protected $signature = 'licensing:set {--users=3 : Maximum number of users} {--registers=1 : Maximum number of cash registers} {--tier=Básico : Name of the plan} {--ecommerce=0 : Enable Ecommerce/Online Catalog}';

    protected $description = 'Set system licensing limits and tier name';

    public function handle()
    {
        $users = $this->option('users');
        $registers = $this->option('registers');
        $tier = $this->option('tier');
        $ecommerce = $this->option('ecommerce');

        $this->updateSetting('license_max_users', $users, 'Límite máximo de usuarios permitidos');
        $this->updateSetting('license_max_cash_registers', $registers, 'Límite máximo de cajas registradoras permitidas');
        $this->updateSetting('license_tier_name', $tier, 'Nombre del plan/tier contratado');
        $this->updateSetting('license_ecommerce_enabled', $ecommerce, 'Habilitar Catálogo Online / E-commerce');

        $this->info("Licencia actualizada correctamente:");
        $this->line("- Plan: <info>{$tier}</info>");
        $this->line("- Catálogo E-commerce: <info>" . ($ecommerce ? 'Habilitado' : 'Deshabilitado') . "</info>");
        $this->line("- Máx Usuarios: <info>{$users}</info>");
        $this->line("- Máx Cajas: <info>{$registers}</info>");
        
        return Command::SUCCESS;
    }

    private function updateSetting($key, $value, $description)
    {
        StoreSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description
            ]
        );
    }
}
