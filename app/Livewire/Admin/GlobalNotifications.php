<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\WebOrder;
use Livewire\Attributes\On;

class GlobalNotifications extends Component
{
    public $unreadCount = 0;
    public $lowStockCount = 0;
    public $recentOrders = [];

    public function mount()
    {
        $this->loadUnreadData();
    }

    public function loadUnreadData()
    {
        // 1. Unread Web Orders
        $this->unreadCount = WebOrder::where('status', 'Pendiente WhatsApp')
            ->where('created_at', '>=', now()->subDay())
            ->count();
            
        // 2. Low Stock Count
        $this->lowStockCount = \App\Models\Product::where('is_active', true)
            ->where('manage_stock', true)
            ->whereColumn('stock', '<=', 'min_stock')
            ->count();

        $this->recentOrders = WebOrder::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->toArray();
    }

    #[On('echo:orders,NewWebOrderReceived')]
    public function onNewWebOrder($data)
    {
        $this->unreadCount++;
        
        // Add to recent list
        array_unshift($this->recentOrders, $data['order']);
        $this->recentOrders = array_slice($this->recentOrders, 0, 5);

        // Dispatch browser event for sound and toast
        $this->dispatch('play-admin-sound');
        $this->dispatch('show-order-toast', [
            'customer' => $data['order']['customer_name'],
            'total' => number_format($data['order']['total'], 0, ',', '.')
        ]);
    }

    public function clearNotifications()
    {
        $this->unreadCount = 0;
    }

    public function render()
    {
        return view('livewire.admin.global-notifications');
    }
}
