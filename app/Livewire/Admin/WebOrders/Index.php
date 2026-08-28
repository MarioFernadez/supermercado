<?php

namespace App\Livewire\Admin\WebOrders;

use Livewire\Component;
use App\Models\WebOrder;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedOrder = null;
    public $showDetailsModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function viewOrder($orderId)
    {
        $this->selectedOrder = WebOrder::with('product')->find($orderId);
        $this->showDetailsModal = true;
    }

    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedOrder = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($orderId, $newStatus)
    {
        $order = WebOrder::find($orderId);
        if ($order) {
            $order->update(['status' => $newStatus]);
            session()->flash('message', 'Estado del pedido actualizado correctamente.');
        }
    }

    public function deleteOrder($orderId)
    {
        $order = WebOrder::find($orderId);
        if ($order) {
            $order->delete();
            session()->flash('message', 'Pedido eliminado.');
        }
    }

    public function render()
    {
        $query = WebOrder::with('product')
            ->when($this->search, function ($q) {
                $q->where('customer_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.admin.web-orders.index', [
            'orders' => $query->paginate(10)
        ])->layout('layouts.app');
    }
}
