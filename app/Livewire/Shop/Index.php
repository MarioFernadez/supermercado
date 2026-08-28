<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\StoreSetting;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class Index extends Component
{
    #[Url]
    public $search = '';
    public $perPage = 12;
    public $customer_name = '';
    public $customer_phone = '';
    public $customer_address = '';
    public $payment_method = 'efectivo';

    public function updatedSearch($value)
    {
        $this->dispatch('search-updated', query: $value);
        $this->perPage = 12;
    }

    #[On('search-updated')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->perPage = 12;
    }

    public function processOrder($items, $singleProductId = null)
    {
        $total = array_reduce($items, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        $order = \App\Models\WebOrder::create([
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'product_id' => $singleProductId,
            'total' => $total,
            'items_json' => $items,
            'payment_method' => $this->payment_method,
        ]);

        // Trigger Event for Real-time Notification
        event(new \App\Events\NewWebOrderReceived($order));

        // WhatsApp Redirection
        $whatsapp = StoreSetting::where('key', 'shop_whatsapp')->first()?->value ?: '981123456';
        $prefix = "595"; // Default for Paraguay
        if (strpos($whatsapp, $prefix) !== 0) {
            $whatsapp = $prefix . $whatsapp;
        }

        $message = "¡Hola! Mi nombre es {$this->customer_name}. Acabo de realizar un pedido web:\n";
        foreach ($items as $item) {
            $message .= "• {$item['quantity']}x {$item['name']} (Gs. " . number_format($item['price'] * $item['quantity'], 0, ',', '.') . ")\n";
        }
        $message .= "💰 *Total: Gs. " . number_format($total, 0, ',', '.') . "*\n";
        $message .= "📍 Dirección: {$this->customer_address}\n";
        $message .= "📞 Teléfono: {$this->customer_phone}\n";
        $message .= "💳 Método de Pago: " . ucfirst($this->payment_method);

        $url = "https://wa.me/{$whatsapp}?text=" . urlencode($message);

        $this->reset(['customer_name', 'customer_phone', 'customer_address']);
        $this->dispatch('order-submitted');

        return $url;
    }

    #[On('request-cart-checkout')]
    public function checkoutFromCart($items, $customerName, $customerPhone, $customerAddress, $paymentMethod)
    {
        // 1. Validate Stock
        foreach ($items as $item) {
            $product = \App\Models\Product::find($item['id']);
            if (!$product || !$product->is_active) {
                $this->dispatch('checkout-error', message: "El producto '{$item['name']}' ya no está disponible.");
                return;
            }

            if ($product->manage_stock) {
                if (!empty($item['variation_id'])) {
                    $variation = \App\Models\ProductVariation::find($item['variation_id']);
                    if (!$variation || $variation->stock < $item['quantity']) {
                        $this->dispatch('checkout-error', message: "No hay stock suficiente para '{$item['name']}'. (Requerido: {$item['quantity']})");
                        return;
                    }
                } else {
                    if ($product->stock < $item['quantity']) {
                        $this->dispatch('checkout-error', message: "No hay stock suficiente para '{$item['name']}'. (Requerido: {$item['quantity']})");
                        return;
                    }
                }
            }
        }

        $this->customer_name = $customerName;
        $this->customer_phone = $customerPhone;
        $this->customer_address = $customerAddress;
        $this->payment_method = $paymentMethod;

        $url = $this->processOrder($items);
        $this->dispatch('checkout-processed', url: $url);
    }

    public function loadMore()
    {
        $this->perPage += 12;
        $this->dispatch('products-loaded');
    }

    public function render()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        
        $bannerLimit = intval($settings->get('shop_banner_limit', 5));
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->take($bannerLimit)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();

        $query = Product::with('category')->where('is_active', true)
            ->when($this->search, function($q) {
                $q->where(function($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc');

        $totalProducts = (clone $query)->count();
        $recentProducts = $query->take($this->perPage)->get();

        return view('livewire.shop.index', [
            'banners' => $banners,
            'categories' => $categories,
            'recentProducts' => $recentProducts,
            'settings' => $settings,
            'hasMore' => $totalProducts > $this->perPage,
        ])->layout('layouts.shop', ['settings' => $settings]);
    }
}
