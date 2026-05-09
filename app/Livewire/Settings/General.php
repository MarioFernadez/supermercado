<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\StoreSetting;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class General extends Component
{
    use WithFileUploads;

    public $store_name;
    public $store_address;
    public $store_phone;
    public $store_ruc;
    public $store_email;
    public $ticket_footer;

    // E-commerce Settings
    public $shop_whatsapp;
    public $shop_logo; // New file
    public $shop_logo_path; // Current path
    public $shop_favicon; // New file
    public $shop_favicon_path; // Current path
    public $shop_facebook;
    public $shop_instagram;
    public $shop_tiktok;
    public $shop_maps_iframe;
    public $shop_description;
    public $shop_schedule;
    public $shop_banner_limit;
    public $shop_show_pricelist = false;
    public $shop_payment_instructions;


    // Discount feature toggles
    public $discount_product_enabled = false;
    public $discount_manual_enabled  = false;

    // Internal property to hold all settings
    private $settingsCollection;

    public function mount()
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

        $this->shop_whatsapp = $this->getSetting('shop_whatsapp', '');
        $this->shop_logo_path = $this->getSetting('shop_logo_path', '');
        $this->shop_favicon_path = $this->getSetting('shop_favicon_path', '');
        $this->shop_facebook = $this->getSetting('shop_facebook', '');
        $this->shop_instagram = $this->getSetting('shop_instagram', '');
        $this->shop_tiktok = $this->getSetting('shop_tiktok', '');
        $this->shop_maps_iframe = $this->getSetting('shop_maps_iframe', '');
        $this->shop_description = $this->getSetting('shop_description', '');
        $this->shop_schedule = $this->getSetting('shop_schedule', '');
        $this->shop_banner_limit = $this->getSetting('shop_banner_limit', '5');
        $this->shop_show_pricelist = $this->getSetting('shop_show_pricelist', '0') === '1';
        $this->shop_payment_instructions = $this->getSetting('shop_payment_instructions', '');
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
            'shop_whatsapp' => 'nullable|string|max:20',
            'shop_logo' => 'nullable|image|max:1024', // Max 1MB
            'shop_favicon' => 'nullable|mimes:jpeg,png,jpg,gif,svg,ico|max:512', // Max 512KB for favicon
            'shop_facebook' => 'nullable|url|max:255',
            'shop_instagram' => 'nullable|url|max:255',
            'shop_tiktok' => 'nullable|url|max:255',
            'shop_maps_iframe' => 'nullable|string',
            'shop_description' => 'nullable|string|max:500',
            'shop_schedule' => 'nullable|string|max:500',
            'shop_banner_limit' => 'required|integer|min:1|max:10',
            'shop_payment_instructions' => 'nullable|string|max:1000',
        ]);

        if ($this->shop_logo) {
            // Delete old logo if exists
            if ($this->shop_logo_path) {
                Storage::disk('public')->delete($this->shop_logo_path);
            }
            $this->shop_logo_path = $this->shop_logo->store('shop', 'public');
        }

        $this->updateSetting('store_name', $this->store_name, 'Nombre del comercio');
        $this->updateSetting('store_address', $this->store_address, 'Dirección física');
        $this->updateSetting('store_phone', $this->store_phone, 'Teléfono de contacto');
        $this->updateSetting('store_ruc', $this->store_ruc, 'RUC o Identificación Tributaria');
        $this->updateSetting('store_email', $this->store_email, 'Email de contacto');
        $this->updateSetting('ticket_footer', $this->ticket_footer, 'Mensaje al pie del ticket');
        $this->updateSetting('discount_product_enabled', $this->discount_product_enabled ? '1' : '0', 'Habilitar descuentos por producto');
        $this->updateSetting('discount_manual_enabled', $this->discount_manual_enabled ? '1' : '0', 'Habilitar descuento manual en POS');
        $this->updateSetting('shop_whatsapp', $this->shop_whatsapp, 'WhatsApp para pedidos e-commerce');
        $this->updateSetting('shop_logo_path', $this->shop_logo_path, 'Logo del e-commerce');

        if ($this->shop_favicon) {
            // Delete old favicon if exists
            if ($this->shop_favicon_path) {
                Storage::disk('public')->delete($this->shop_favicon_path);
            }
            $this->shop_favicon_path = $this->shop_favicon->store('shop', 'public');
        }
        $this->updateSetting('shop_favicon_path', $this->shop_favicon_path, 'Favicon del sitio');
        $this->updateSetting('shop_facebook', $this->shop_facebook, 'Enlace Facebook');
        $this->updateSetting('shop_instagram', $this->shop_instagram, 'Enlace Instagram');
        $this->updateSetting('shop_tiktok', $this->shop_tiktok, 'Enlace TikTok');
        $this->updateSetting('shop_maps_iframe', $this->shop_maps_iframe, 'Código Iframe Google Maps');
        $this->updateSetting('shop_description', $this->shop_description, 'Descripción corta de la tienda');
        $this->updateSetting('shop_schedule', $this->shop_schedule, 'Horario de atención');
        $this->updateSetting('shop_banner_limit', $this->shop_banner_limit, 'Límite de banners en carrusel');
        $this->updateSetting('shop_show_pricelist', $this->shop_show_pricelist ? '1' : '0', 'Mostrar descarga de lista de precios');
        $this->updateSetting('shop_payment_instructions', $this->shop_payment_instructions, 'Instrucciones de pago para pedidos web');
 
        // Sync to public on Windows fallback
        if ($this->shop_logo || $this->shop_favicon) {
            $this->syncToPublic('shop');
        }

        session()->flash('message', 'Ajustes actualizados correctamente.');
    }

    private function syncToPublic($folder)
    {
        $src = storage_path('app/public/' . $folder);
        $dst = public_path('storage/' . $folder);
        
        if (!is_dir($src)) return;
        if (!is_dir($dst)) @mkdir($dst, 0777, true);
        
        $files = @scandir($src);
        if ($files) {
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    @copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
    }

    public function deleteLogo()
    {
        if ($this->shop_logo_path) {
            Storage::disk('public')->delete($this->shop_logo_path);
            $this->shop_logo_path = '';
            $this->updateSetting('shop_logo_path', '', 'Logo del e-commerce');
        }
        $this->shop_logo = null;
        session()->flash('message', 'Logo eliminado correctamente.');
    }

    public function deleteFavicon()
    {
        if ($this->shop_favicon_path) {
            Storage::disk('public')->delete($this->shop_favicon_path);
            $this->shop_favicon_path = '';
            $this->updateSetting('shop_favicon_path', '', 'Favicon del sitio');
        }
        $this->shop_favicon = null;
        session()->flash('message', 'Favicon eliminado correctamente.');
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
