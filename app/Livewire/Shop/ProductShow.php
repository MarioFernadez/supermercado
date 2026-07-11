<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Models\StoreSetting;

class ProductShow extends Component
{
    public $product;
    public $selectedVariation = null;

    public function mount(Product $product)
    {
        $this->product = $product;
        // Default to first variation if exists
        if ($this->product->has_variations && $this->product->variations->count() > 0) {
            $this->selectedVariation = $this->product->variations->first();
        }
    }

    public function selectVariation($variationId)
    {
        $this->selectedVariation = \App\Models\ProductVariation::find($variationId);
    }

    public function render()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        
        // Fetch related products from the same category
        $relatedProducts = Product::with('category')->where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('livewire.shop.product-show', [
            'settings' => $settings,
            'relatedProducts' => $relatedProducts,
        ])->layout('layouts.shop', ['settings' => $settings]);
    }
}
