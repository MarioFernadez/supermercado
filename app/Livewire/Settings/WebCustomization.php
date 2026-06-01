<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\StoreSetting;
use App\Models\Banner;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class WebCustomization extends Component
{
    use WithFileUploads;

    // Tabs control
    public $activeTab = 'info'; // 'info', 'style', 'carrusel'

    // E-commerce Info & Contact (Tab 1)
    public $shop_whatsapp;
    public $shop_logo; // Upload file
    public $shop_logo_path; // DB stored path
    public $shop_favicon; // Upload file
    public $shop_favicon_path; // DB stored path
    public $shop_facebook;
    public $shop_instagram;
    public $shop_tiktok;
    public $shop_maps_iframe;
    public $shop_description;
    public $shop_schedule;
    public $shop_banner_limit;
    public $shop_show_pricelist = false;
    public $shop_payment_instructions;

    // E-commerce Design & Promo Banners (Tab 2)
    public $top_bar_enabled = false;
    public $top_bar_text;
    public $top_bar_bg_color;
    public $top_bar_text_color;
    public $shop_primary_color;
    public $shop_primary_color_hover;

    public $promo_banner_1; // Upload file
    public $promo_banner_1_path;
    public $promo_banner_1_link;
    public $promo_banner_2; // Upload file
    public $promo_banner_2_path;
    public $promo_banner_2_link;

    // Benefits Section (Tab 2)
    public $benefits_enabled = false;
    public $benefit_1_title;
    public $benefit_1_subtitle;
    public $benefit_2_title;
    public $benefit_2_subtitle;
    public $benefit_3_title;
    public $benefit_3_subtitle;
    public $benefit_4_title;
    public $benefit_4_subtitle;

    // Main Swiper Carousel (Tab 3)
    public $title, $subtitle, $link, $order = 0, $image, $mobile_image, $mobile_image_path;
    public $bannerId;
    public $isOpen = false;

    private $settingsCollection;

    public function mount()
    {
        $this->loadSettings();
    }

    private function loadSettings()
    {
        $this->settingsCollection = StoreSetting::all()->pluck('value', 'key');

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

        $this->top_bar_enabled = $this->getSetting('top_bar_enabled', '0') === '1';
        $this->top_bar_text = $this->getSetting('top_bar_text', '¿No querés pagar con tarjeta? ¡No hay problema! Elegí Pago en Puerta para pagar al momento de recibir tu pedido.');
        $this->top_bar_bg_color = $this->getSetting('top_bar_bg_color', '#002f6c');
        $this->top_bar_text_color = $this->getSetting('top_bar_text_color', '#ffffff');
        $this->shop_primary_color = $this->getSetting('shop_primary_color', '#4f46e5');
        $this->shop_primary_color_hover = $this->getSetting('shop_primary_color_hover', '#4338ca');

        $this->promo_banner_1_path = $this->getSetting('promo_banner_1_path', '');
        $this->promo_banner_1_link = $this->getSetting('promo_banner_1_link', '#');
        $this->promo_banner_2_path = $this->getSetting('promo_banner_2_path', '');
        $this->promo_banner_2_link = $this->getSetting('promo_banner_2_link', '#');

        $this->benefits_enabled = $this->getSetting('benefits_enabled', '1') === '1';
        $this->benefit_1_title = $this->getSetting('benefit_1_title', 'Compra segura');
        $this->benefit_1_subtitle = $this->getSetting('benefit_1_subtitle', 'Pago protegido con encriptación SSL');
        $this->benefit_2_title = $this->getSetting('benefit_2_title', 'Envío a todo el país');
        $this->benefit_2_subtitle = $this->getSetting('benefit_2_subtitle', 'Despachamos a todos los departamentos');
        $this->benefit_3_title = $this->getSetting('benefit_3_title', 'Cambios fáciles');
        $this->benefit_3_subtitle = $this->getSetting('benefit_3_subtitle', '15 días para cambiar');
        $this->benefit_4_title = $this->getSetting('benefit_4_title', 'Atención al cliente');
        $this->benefit_4_subtitle = $this->getSetting('benefit_4_subtitle', 'Soporte por WhatsApp');
    }

    public function render()
    {
        $banners = Banner::orderBy('order')->get();
        return view('livewire.settings.web-customization', compact('banners'))->layout('layouts.app');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // Save Settings for Tab 1 & Tab 2
    public function save()
    {
        $this->validate([
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
            'top_bar_text' => 'nullable|string|max:1000',
            'top_bar_bg_color' => 'required|string|max:7',
            'top_bar_text_color' => 'required|string|max:7',
            'shop_primary_color' => 'required|string|max:7',
            'shop_primary_color_hover' => 'required|string|max:7',
            'promo_banner_1' => 'nullable|image|max:2048',
            'promo_banner_1_link' => 'nullable|string|max:255',
            'promo_banner_2' => 'nullable|image|max:2048',
            'promo_banner_2_link' => 'nullable|string|max:255',
            'benefit_1_title' => 'required|string|max:50',
            'benefit_1_subtitle' => 'required|string|max:100',
            'benefit_2_title' => 'required|string|max:50',
            'benefit_2_subtitle' => 'required|string|max:100',
            'benefit_3_title' => 'required|string|max:50',
            'benefit_3_subtitle' => 'required|string|max:100',
            'benefit_4_title' => 'required|string|max:50',
            'benefit_4_subtitle' => 'required|string|max:100',
        ]);

        if ($this->shop_logo) {
            if ($this->shop_logo_path) {
                Storage::disk('public')->delete($this->shop_logo_path);
            }
            $this->shop_logo_path = $this->shop_logo->store('shop', 'public');
        }

        if ($this->shop_favicon) {
            if ($this->shop_favicon_path) {
                Storage::disk('public')->delete($this->shop_favicon_path);
            }
            $this->shop_favicon_path = $this->shop_favicon->store('shop', 'public');
        }

        if ($this->promo_banner_1) {
            if ($this->promo_banner_1_path) {
                Storage::disk('public')->delete($this->promo_banner_1_path);
            }
            $this->promo_banner_1_path = $this->promo_banner_1->store('shop', 'public');
        }

        if ($this->promo_banner_2) {
            if ($this->promo_banner_2_path) {
                Storage::disk('public')->delete($this->promo_banner_2_path);
            }
            $this->promo_banner_2_path = $this->promo_banner_2->store('shop', 'public');
        }

        $this->updateSetting('shop_whatsapp', $this->shop_whatsapp, 'WhatsApp para pedidos e-commerce');
        $this->updateSetting('shop_logo_path', $this->shop_logo_path, 'Logo del e-commerce');
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
        $this->updateSetting('top_bar_enabled', $this->top_bar_enabled ? '1' : '0', 'Habilitar barra superior');
        $this->updateSetting('top_bar_text', $this->top_bar_text, 'Texto de la barra superior');
        $this->updateSetting('top_bar_bg_color', $this->top_bar_bg_color, 'Color de fondo de la barra superior');
        $this->updateSetting('top_bar_text_color', $this->top_bar_text_color, 'Color de texto de la barra superior');
        $this->updateSetting('shop_primary_color', $this->shop_primary_color, 'Color principal de la tienda');
        $this->updateSetting('shop_primary_color_hover', $this->shop_primary_color_hover, 'Color principal hover de la tienda');
        $this->updateSetting('promo_banner_1_path', $this->promo_banner_1_path, 'Imagen del banner promocional izquierdo');
        $this->updateSetting('promo_banner_1_link', $this->promo_banner_1_link, 'Enlace del banner promocional izquierdo');
        $this->updateSetting('promo_banner_2_path', $this->promo_banner_2_path, 'Imagen del banner promocional derecho');
        $this->updateSetting('promo_banner_2_link', $this->promo_banner_2_link, 'Enlace del banner promocional derecho');

        $this->updateSetting('benefits_enabled', $this->benefits_enabled ? '1' : '0', 'Habilitar barra de beneficios de compra');
        $this->updateSetting('benefit_1_title', $this->benefit_1_title, 'Título beneficio 1');
        $this->updateSetting('benefit_1_subtitle', $this->benefit_1_subtitle, 'Subtítulo beneficio 1');
        $this->updateSetting('benefit_2_title', $this->benefit_2_title, 'Título beneficio 2');
        $this->updateSetting('benefit_2_subtitle', $this->benefit_2_subtitle, 'Subtítulo beneficio 2');
        $this->updateSetting('benefit_3_title', $this->benefit_3_title, 'Título beneficio 3');
        $this->updateSetting('benefit_3_subtitle', $this->benefit_3_subtitle, 'Subtítulo beneficio 3');
        $this->updateSetting('benefit_4_title', $this->benefit_4_title, 'Título beneficio 4');
        $this->updateSetting('benefit_4_subtitle', $this->benefit_4_subtitle, 'Subtítulo beneficio 4');

        // Sync uploads to public folder (Windows fallback)
        if ($this->shop_logo || $this->shop_favicon || $this->promo_banner_1 || $this->promo_banner_2) {
            $this->syncToPublic('shop');
        }

        // Reload fresh values
        $this->loadSettings();

        // Clear files from memory
        $this->shop_logo = null;
        $this->shop_favicon = null;
        $this->promo_banner_1 = null;
        $this->promo_banner_2 = null;

        session()->flash('message', 'Configuración de personalización guardada correctamente.');
    }

    // Logo & Favicon & Promo deletion methods
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

    public function deletePromoBanner1()
    {
        if ($this->promo_banner_1_path) {
            Storage::disk('public')->delete($this->promo_banner_1_path);
            $this->promo_banner_1_path = '';
            $this->updateSetting('promo_banner_1_path', '', 'Imagen del banner promocional izquierdo');
        }
        $this->promo_banner_1 = null;
        session()->flash('message', 'Banner promocional izquierdo eliminado.');
    }

    public function deletePromoBanner2()
    {
        if ($this->promo_banner_2_path) {
            Storage::disk('public')->delete($this->promo_banner_2_path);
            $this->promo_banner_2_path = '';
            $this->updateSetting('promo_banner_2_path', '', 'Imagen del banner promocional derecho');
        }
        $this->promo_banner_2 = null;
        session()->flash('message', 'Banner promocional derecho eliminado.');
    }

    // ==========================================
    // PORTED CAROUSEL CRUD METHODS (Tab 3)
    // ==========================================

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->subtitle = '';
        $this->link = '';
        $this->order = 0;
        $this->image = null;
        $this->mobile_image = null;
        $this->mobile_image_path = null;
        $this->bannerId = null;
    }

    public function store()
    {
        $this->validate([
            'image' => $this->bannerId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'mobile_image' => 'nullable|image|max:2048',
            'order' => 'required|integer',
        ]);

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'link' => $this->link,
            'order' => $this->order,
        ];

        $bannerSyncRequired = false;

        if ($this->image) {
            // Delete old desktop image if editing
            if ($this->bannerId) {
                $old = Banner::find($this->bannerId);
                if ($old && $old->image_path) {
                    Storage::disk('public')->delete($old->image_path);
                }
            }
            $data['image_path'] = $this->image->store('banners', 'public');
            $bannerSyncRequired = true;
        }

        if ($this->mobile_image) {
            // Delete old mobile image if editing
            if ($this->bannerId) {
                $old = Banner::find($this->bannerId);
                if ($old && $old->mobile_image_path) {
                    Storage::disk('public')->delete($old->mobile_image_path);
                }
            }
            $data['mobile_image_path'] = $this->mobile_image->store('banners', 'public');
            $bannerSyncRequired = true;
        }

        Banner::updateOrCreate(['id' => $this->bannerId], $data);

        // Sync carousel image directory to public on Windows
        if ($bannerSyncRequired) {
            $this->syncToPublic('banners');
        }

        session()->flash('message', 
            $this->bannerId ? 'Banner del carrusel actualizado correctamente.' : 'Banner del carrusel creado correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $this->bannerId = $id;
        $this->title = $banner->title;
        $this->subtitle = $banner->subtitle;
        $this->link = $banner->link;
        $this->order = $banner->order;
        $this->mobile_image_path = $banner->mobile_image_path;
        $this->openModal();
    }

    public function delete($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            if ($banner->mobile_image_path) {
                Storage::disk('public')->delete($banner->mobile_image_path);
            }
            $banner->delete();
            session()->flash('message', 'Banner eliminado correctamente del carrusel.');
        }
    }

    public function toggleActive($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->is_active = !$banner->is_active;
            $banner->save();
        }
    }

    // ==========================================
    // UTILITY METHODS
    // ==========================================

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
}
