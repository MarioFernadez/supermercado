<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\LicensePayment;
use App\Services\LicenseService;

class Billing extends Component
{
    public function mount()
    {
        // Administrador o Gerente pueden ver esto. Developer también.
        abort_unless(
            auth()->user()->isAdmin() || 
            auth()->user()->isManager() || 
            auth()->user()->isDeveloper(), 
            403
        );
    }

    public function getPaymentsProperty()
    {
        return LicensePayment::orderBy('payment_date', 'desc')->get();
    }

    public function render()
    {
        $daysRemaining = LicenseService::getDaysRemaining();
        $isExpired = LicenseService::isExpired();
        $isNearExpiration = LicenseService::isNearExpiration();
        
        $enabledAt = LicenseService::getEnabledAt();
        $expiresAt = LicenseService::getExpiresAt();
        $tierName = LicenseService::getTierName();

        return view('livewire.settings.billing', [
            'payments' => $this->payments,
            'daysRemaining' => $daysRemaining,
            'isExpired' => $isExpired,
            'isNearExpiration' => $isNearExpiration,
            'enabledAt' => $enabledAt,
            'expiresAt' => $expiresAt,
            'tierName' => $tierName,
            'isGracePeriodUsed' => LicenseService::isGracePeriodUsed(),
            'canActivateGracePeriod' => LicenseService::canActivateGracePeriod(),
        ])->layout('layouts.app');
    }

    public function activateGracePeriod()
    {
        abort_unless(
            auth()->user()->isAdmin() || 
            auth()->user()->isManager() || 
            auth()->user()->isDeveloper(), 
            403
        );

        if (!LicenseService::canActivateGracePeriod()) {
            session()->flash('error', 'No elegible para activar el tiempo de gracia de emergencia.');
            return;
        }

        \App\Models\StoreSetting::updateOrCreate(
            ['key' => 'license_grace_period_used'],
            ['value' => '1']
        );

        \App\Models\StoreSetting::updateOrCreate(
            ['key' => 'license_expires_at'],
            ['value' => now()->addDays(3)->format('Y-m-d')]
        );

        $msg = "Hola, he activado el Comodín de Emergencia de 3 días de gracia en ZonaPOS. Estaré realizando la transferencia y enviando el comprobante de pago a la brevedad.";
        $whatsappUrl = "https://wa.me/595981762444?text=" . urlencode($msg);

        session()->flash('grace_activated', true);
        session()->flash('whatsapp_url', $whatsappUrl);
        session()->flash('message', 'Tiempo de gracia activado. El sistema se ha desbloqueado temporalmente por 3 días.');

        return redirect()->route('settings.billing');
    }
}
