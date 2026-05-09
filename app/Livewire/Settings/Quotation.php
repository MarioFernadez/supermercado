<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\StoreSetting;

class Quotation extends Component
{
    public $usd;
    public $brl;
    public $ars;
    public $eur;

    public function mount()
    {
        $settings = StoreSetting::whereIn('key', ['currency_usd', 'currency_brl', 'currency_ars', 'currency_eur'])
            ->pluck('value', 'key');

        $this->usd = $settings->get('currency_usd', '0');
        $this->brl = $settings->get('currency_brl', '0');
        $this->ars = $settings->get('currency_ars', '0');
        $this->eur = $settings->get('currency_eur', '0');
    }

    public function render()
    {
        return view('livewire.settings.quotation')->layout('layouts.app');
    }

    public function save()
    {
        $this->validate([
            'usd' => 'required|numeric|min:0',
            'brl' => 'required|numeric|min:0',
            'ars' => 'required|numeric|min:0',
            'eur' => 'required|numeric|min:0',
        ]);

        $this->updateSetting('currency_usd', $this->usd, 'Cotización Dólar Americano');
        $this->updateSetting('currency_brl', $this->brl, 'Cotización Real Brasileño');
        $this->updateSetting('currency_ars', $this->ars, 'Cotización Peso Argentino');
        $this->updateSetting('currency_eur', $this->eur, 'Cotización Euro');

        session()->flash('message', 'Cotizaciones actualizadas correctamente.');
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
