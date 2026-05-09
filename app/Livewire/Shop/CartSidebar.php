<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\WebOrder;
use App\Models\StoreSetting;
use App\Events\NewWebOrderReceived;

class CartSidebar extends Component
{
    public function checkoutFromCart($items, $customerName, $customerPhone, $customerAddress)
    {
        $total = array_reduce($items, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        $order = WebOrder::create([
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_address' => $customerAddress,
            'total' => $total,
            'items_json' => $items,
            'status' => 'Pendiente WhatsApp',
        ]);

        // Trigger Event for Real-time Notification
        event(new NewWebOrderReceived($order));

        // WhatsApp Redirection Logic
        $whatsapp = StoreSetting::where('key', 'shop_whatsapp')->first()?->value ?: '981123456';
        $prefix = "595";
        if (strpos($whatsapp, $prefix) !== 0) {
            $whatsapp = $prefix . $whatsapp;
        }

        $message = "¡Hola! Mi nombre es {$customerName}. Acabo de realizar un pedido web:\n";
        foreach ($items as $item) {
            $message .= "• {$item['quantity']}x {$item['name']} (Gs. " . number_format($item['price'] * $item['quantity'], 0, ',', '.') . ")\n";
        }
        $message .= "💰 *Total: Gs. " . number_format($total, 0, ',', '.') . "*\n";
        $message .= "📍 Dirección: {$customerAddress}\n";
        $message .= "📞 Teléfono: {$customerPhone}";

        return "https://wa.me/{$whatsapp}?text=" . urlencode($message);
    }

    public function render()
    {
        return view('livewire.shop.cart-sidebar');
    }
}
