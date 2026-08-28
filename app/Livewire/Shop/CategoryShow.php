<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;

class CategoryShow extends Component
{
    public $category;
    public $search = '';
    public $sort = 'latest'; // latest, price_asc, price_desc
    public $perPage = 12;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function updatedSearch()
    {
        $this->perPage = 12;
    }

    public function render()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');

        $query = Product::with('category')->where('category_id', $this->category->id)
            ->where('is_active', true)
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->sort === 'price_asc', fn($q) => $q->orderBy('price_sale', 'asc'))
            ->when($this->sort === 'price_desc', fn($q) => $q->orderBy('price_sale', 'desc'))
            ->when($this->sort === 'latest', fn($q) => $q->orderBy('created_at', 'desc'));

        $totalProducts = (clone $query)->count();
        $products = $query->take($this->perPage)->get();

        return view('livewire.shop.category-show', [
            'products' => $products,
            'settings' => $settings,
            'hasMore' => $totalProducts > $this->perPage,
        ])->layout('layouts.shop', ['settings' => $settings]);
    }
}
