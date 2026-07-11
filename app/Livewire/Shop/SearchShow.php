<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Models\StoreSetting;
use Livewire\Attributes\Url;

class SearchShow extends Component
{
    #[Url(as: 'q')]
    public $query = '';
    public $perPage = 12;

    public function mount()
    {
        if (empty($this->query)) {
            return redirect()->route('shop.index');
        }
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function render()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        
        $productsQuery = Product::with('category')->where('is_active', true)
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->query . '%')
                  ->orWhere('sku', 'like', '%' . $this->query . '%');
            })
            ->orderBy('created_at', 'desc');

        $totalResults = (clone $productsQuery)->count();
        $results = $productsQuery->take($this->perPage)->get();

        return view('livewire.shop.search-show', [
            'results' => $results,
            'totalResults' => $totalResults,
            'settings' => $settings,
            'hasMore' => $totalResults > $this->perPage,
        ])->layout('layouts.shop', ['settings' => $settings]);
    }
}
