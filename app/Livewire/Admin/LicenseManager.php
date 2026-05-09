<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\StoreSetting;
use App\Services\LicenseService;
use Illuminate\Support\Facades\Artisan;

class LicenseManager extends Component
{
    public $maxUsers;
    public $maxCashRegisters;
    public $tierName;

    public $ecommerceEnabled;

    public function mount()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);

        $this->maxUsers = LicenseService::getMaxUsers();
        $this->maxCashRegisters = LicenseService::getMaxCashRegisters();
        $this->tierName = LicenseService::getTierName();
        $this->ecommerceEnabled = LicenseService::isEcommerceEnabled();
    }

    public function updateLicense()
    {
        abort_unless(auth()->user()->isDeveloper(), 403);

        $this->validate([
            'maxUsers' => 'required|integer|min:1',
            'maxCashRegisters' => 'required|integer|min:1',
            'tierName' => 'required|string|min:2',
            'ecommerceEnabled' => 'boolean',
        ]);

        Artisan::call('licensing:set', [
            '--users' => $this->maxUsers,
            '--registers' => $this->maxCashRegisters,
            '--tier' => $this->tierName,
            '--ecommerce' => $this->ecommerceEnabled ? '1' : '0',
        ]);

        session()->flash('message', 'Licencia actualizada correctamente desde la interfaz Master.');
    }

    public function render()
    {
        return view('livewire.admin.license-manager')
            ->layout('layouts.app');
    }
}
