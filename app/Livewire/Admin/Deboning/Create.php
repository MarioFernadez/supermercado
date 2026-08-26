<?php

namespace App\Livewire\Admin\Deboning;

use Livewire\Component;
use App\Models\Product;
use App\Models\DeboningSession;
use App\Models\DeboningItem;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $raw_material_product_id = '';
    public $total_weight_start = 0;
    
    // Items array: [['product_id' => '', 'weight' => 0]]
    public $items = [];
    
    public $notes = '';

    public function mount()
    {
        abort_unless(auth()->user()->can('admin') || auth()->user()->can('manager'), 403);
        abort_unless(hasModule('meat_deboning'), 404);
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'weight' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function getRawMaterialsProperty()
    {
        return Product::where('is_raw_material', true)->where('is_active', true)->orderBy('name')->get();
    }

    public function getCutProductsProperty()
    {
        return Product::where('is_raw_material', false)
            ->where('unit_type', 'kg')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getTotalYieldProperty()
    {
        return collect($this->items)->sum(function ($item) {
            return floatval($item['weight'] ?? 0);
        });
    }

    public function getWasteWeightProperty()
    {
        $start = floatval($this->total_weight_start);
        $yield = $this->total_yield;
        return max(0, $start - $yield);
    }

    public function save(\App\Services\DeboningService $deboningService)
    {
        $this->validate([
            'raw_material_product_id' => 'required|exists:products,id',
            'total_weight_start'      => 'required|numeric|min:0.1',
            'items'                   => 'required|array|min:1',
            'items.*.product_id'      => 'required|exists:products,id',
            'items.*.weight'          => 'required|numeric|min:0.01',
        ]);

        try {
            $deboningService->createSession([
                'raw_material_product_id' => $this->raw_material_product_id,
                'total_weight_start'      => $this->total_weight_start,
                'items'                   => $this->items,
                'notes'                   => $this->notes,
                'user_id'                 => auth()->id(),
            ]);

            session()->flash('message', 'Desposte registrado con éxito. Stock actualizado.');
            return redirect()->route('admin.deboning.index');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.deboning.create')->layout('layouts.app');
    }
}
