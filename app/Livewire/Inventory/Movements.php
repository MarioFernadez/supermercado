<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Movements extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = '';

    // Create Form variables
    public $showModal = false;
    public $productId = '';
    public $type = 'in';
    public $quantity = 1;
    public $reason = '';
    public $notes = '';

    public function rules()
    {
        return [
            'productId' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function openModal()
    {
        $this->reset(['productId', 'type', 'quantity', 'reason', 'notes']);
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            InventoryMovement::create([
                'product_id' => $this->productId,
                'user_id' => Auth::id(),
                'type' => $this->type,
                'quantity' => $this->quantity,
                'reason' => $this->reason,
                'notes' => $this->notes,
            ]);

            $product = Product::find($this->productId);
            if ($this->type === 'in') {
                $product->increment('stock', $this->quantity);
            } else {
                $product->decrement('stock', $this->quantity);
            }
        });

        $this->reset(['showModal', 'productId', 'type', 'quantity', 'reason', 'notes']);
        session()->flash('message', 'Movimiento registrado correctamente y stock actualizado.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = InventoryMovement::with(['product', 'user'])
            ->when($this->search, function ($q) {
                $q->whereHas('product', function ($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%')
                       ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($q) {
                $q->where('type', $this->typeFilter);
            })
            ->orderBy('created_at', 'desc');

        $movements = $query->paginate(15);
        
        // Load products for the select input
        $products = Product::orderBy('name')->get();

        return view('livewire.inventory.movements', [
            'movements' => $movements,
            'products' => $products,
        ])->layout('layouts.app');
    }
}
