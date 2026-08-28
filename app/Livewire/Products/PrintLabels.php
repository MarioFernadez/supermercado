<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class PrintLabels extends Component
{
    public $productIds = [];
    public $products = [];
    public $quantities = [];
    
    public $format = 'a4'; // 'a4' or 'thermal'
    public $include_price = true;
    public $include_name = true;

    public function mount()
    {
        // Receive IDs from query string
        $ids = request()->query('ids', '');
        
        if (empty($ids)) {
            return redirect()->route('products.index')->with('error', 'No se seleccionaron productos.');
        }

        $this->productIds = explode(',', $ids);
        
        $this->products = Product::whereIn('id', $this->productIds)->get();
        
        if ($this->products->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Productos no encontrados.');
        }

        // Initialize default quantity to 1 for each product
        foreach ($this->products as $product) {
            // Check if product has a valid barcode/SKU
            if (empty($product->sku)) {
                // If it doesn't have an SKU, we can't print a barcode
                continue;
            }
            $this->quantities[$product->id] = 1;
        }
    }

    public function render()
    {
        return view('livewire.products.print-labels')->layout('layouts.app');
    }

    public function generate()
    {
        // Filter out empty or zero quantities
        $validQuantities = array_filter($this->quantities, function($q) {
            return is_numeric($q) && $q > 0;
        });

        if (empty($validQuantities)) {
            session()->flash('error', 'Debes especificar al menos 1 cantidad para imprimir.');
            return;
        }

        // Redirect to print view with base64 encoded parameters to avoid long URLs
        $payload = base64_encode(json_encode([
            'quantities' => $validQuantities,
            'format' => $this->format,
            'include_price' => $this->include_price,
            'include_name' => $this->include_name
        ]));

        // We can't redirect with window.open from livewire directly easily, 
        // but we can dispatch an event to open in a new tab.
        $this->dispatch('open-print-tab', url: route('products.print-labels.render', ['p' => $payload]));
    }
}
