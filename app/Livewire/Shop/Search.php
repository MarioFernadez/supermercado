<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Url;

class Search extends Component
{
    #[Url]
    public $query = '';
    public $showDropdown = false;

    public function clear()
    {
        $this->query = '';
        $this->showDropdown = false;
    }

    public function selectProduct($slug)
    {
        $this->query = '';
        $this->showDropdown = false;
        return redirect()->route('shop.product', $slug);
    }

    public function search()
    {
        if (strlen($this->query) >= 2) {
            return redirect()->route('shop.search', ['q' => $this->query]);
        }
    }

    public function render()
    {
        $results = [];
        
        if (strlen($this->query) >= 2) {
            $results = Product::where('is_active', true)
                ->where(function($q) {
                    $q->where('name', 'like', '%' . $this->query . '%')
                      ->orWhere('sku', 'like', '%' . $this->query . '%');
                })
                ->take(6)
                ->get();
            $this->showDropdown = true;
        } else {
            $this->showDropdown = false;
        }

        return view('livewire.shop.search', [
            'results' => $results
        ]);
    }
}
