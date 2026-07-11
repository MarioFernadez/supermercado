<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\StoreSetting;

class General extends Component
{
    public $store_name;
    public $store_address;
    public $store_phone;
    public $store_ruc;
    public $store_email;
    public $ticket_footer;

    // Features Bar
    public $shop_feature_1_title;
    public $shop_feature_1_subtitle;
    public $shop_feature_2_title;
    public $shop_feature_2_subtitle;
    public $shop_feature_3_title;
    public $shop_feature_3_subtitle;
    public $shop_feature_4_title;
    public $shop_feature_4_subtitle;

    // Discount feature toggles
    public $discount_product_enabled = false;
    public $discount_manual_enabled  = false;

    // Internal property to hold all settings
    private $settingsCollection;

    public function mount()
    {
        $this->loadSettings();
    }

    private function loadSettings()
    {
        $this->settingsCollection = StoreSetting::all()->pluck('value', 'key');

        $this->store_name = $this->getSetting('store_name', 'ZonaPOS Store');
        $this->store_address = $this->getSetting('store_address', '');
        $this->store_phone = $this->getSetting('store_phone', '');
        $this->store_ruc = $this->getSetting('store_ruc', '');
        $this->store_email = $this->getSetting('store_email', '');
        $this->ticket_footer = $this->getSetting('ticket_footer', 'Gracias por su compra');

        $this->discount_product_enabled = $this->getSetting('discount_product_enabled', '0') === '1';
        $this->discount_manual_enabled = $this->getSetting('discount_manual_enabled', '0') === '1';

        $this->shop_feature_1_title = $this->getSetting('shop_feature_1_title', 'Compra segura');
        $this->shop_feature_1_subtitle = $this->getSetting('shop_feature_1_subtitle', 'Pago protegido con encriptación SSL');
        $this->shop_feature_2_title = $this->getSetting('shop_feature_2_title', 'Envío a todo el país');
        $this->shop_feature_2_subtitle = $this->getSetting('shop_feature_2_subtitle', 'Despachamos a todos los departamentos');
        $this->shop_feature_3_title = $this->getSetting('shop_feature_3_title', 'Cambios fáciles');
        $this->shop_feature_3_subtitle = $this->getSetting('shop_feature_3_subtitle', '15 días para cambiar');
        $this->shop_feature_4_title = $this->getSetting('shop_feature_4_title', 'Atención al cliente');
        $this->shop_feature_4_subtitle = $this->getSetting('shop_feature_4_subtitle', 'Soporte por WhatsApp');
    }

    public function render()
    {
        return view('livewire.settings.general')->layout('layouts.app');
    }

    public function save()
    {
        $this->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string|max:255',
            'store_phone' => 'nullable|string|max:50',
            'store_ruc' => 'nullable|string|max:20',
            'store_email' => 'nullable|email|max:255',
            'ticket_footer' => 'nullable|string|max:255',
            'shop_feature_1_title' => 'nullable|string|max:100',
            'shop_feature_1_subtitle' => 'nullable|string|max:100',
            'shop_feature_2_title' => 'nullable|string|max:100',
            'shop_feature_2_subtitle' => 'nullable|string|max:100',
            'shop_feature_3_title' => 'nullable|string|max:100',
            'shop_feature_3_subtitle' => 'nullable|string|max:100',
            'shop_feature_4_title' => 'nullable|string|max:100',
            'shop_feature_4_subtitle' => 'nullable|string|max:100',
        ]);

        $this->updateSetting('store_name', $this->store_name, 'Nombre del comercio');
        $this->updateSetting('store_address', $this->store_address, 'Dirección física');
        $this->updateSetting('store_phone', $this->store_phone, 'Teléfono de contacto');
        $this->updateSetting('store_ruc', $this->store_ruc, 'RUC o Identificación Tributaria');
        $this->updateSetting('store_email', $this->store_email, 'Email de contacto');
        $this->updateSetting('ticket_footer', $this->ticket_footer, 'Mensaje al pie del ticket');
        $this->updateSetting('discount_product_enabled', $this->discount_product_enabled ? '1' : '0', 'Habilitar descuentos por producto');
        $this->updateSetting('discount_manual_enabled', $this->discount_manual_enabled ? '1' : '0', 'Habilitar descuento manual en POS');

        $this->updateSetting('shop_feature_1_title', $this->shop_feature_1_title, 'Beneficio 1 Título');
        $this->updateSetting('shop_feature_1_subtitle', $this->shop_feature_1_subtitle, 'Beneficio 1 Subtítulo');
        $this->updateSetting('shop_feature_2_title', $this->shop_feature_2_title, 'Beneficio 2 Título');
        $this->updateSetting('shop_feature_2_subtitle', $this->shop_feature_2_subtitle, 'Beneficio 2 Subtítulo');
        $this->updateSetting('shop_feature_3_title', $this->shop_feature_3_title, 'Beneficio 3 Título');
        $this->updateSetting('shop_feature_3_subtitle', $this->shop_feature_3_subtitle, 'Beneficio 3 Subtítulo');
        $this->updateSetting('shop_feature_4_title', $this->shop_feature_4_title, 'Beneficio 4 Título');
        $this->updateSetting('shop_feature_4_subtitle', $this->shop_feature_4_subtitle, 'Beneficio 4 Subtítulo');

        $this->loadSettings();

        session()->flash('message', 'Ajustes comerciales actualizados correctamente.');
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

    private function getSetting($key, $default = '')
    {
        return $this->settingsCollection->get($key, $default);
    }
}
