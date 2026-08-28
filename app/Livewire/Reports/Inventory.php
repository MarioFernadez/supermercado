<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class Inventory extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $filterSupplier = '';
    public $filterStock = ''; // 'low', 'out', 'ok'

    public function updatingSearch()    { $this->resetPage(); }
    public function updatingFilterCategory()  { $this->resetPage(); }
    public function updatingFilterSupplier()  { $this->resetPage(); }
    public function updatingFilterStock()     { $this->resetPage(); }

    public function getTotalsProperty()
    {
        $query = $this->buildQuery();
        // Load variations for accurate calculation
        $products = $query->with('variations')->get();

        $totalValue = 0;
        $totalItems = 0;
        $lowStockCount = 0;
        $outOfStockCount = 0;

        foreach ($products as $p) {
            if ($p->has_variations) {
                foreach ($p->variations as $v) {
                    $totalItems += $v->stock;
                    $totalValue += $v->stock * ($v->price_cost ?: $p->price_cost);
                    if ($p->manage_stock) {
                        if ($v->stock == 0) $outOfStockCount++;
                        elseif ($v->stock <= $p->min_stock) $lowStockCount++;
                    }
                }
            } else {
                $totalItems += $p->stock;
                $totalValue += $p->stock * $p->price_cost;
                if ($p->manage_stock) {
                    if ($p->stock == 0) $outOfStockCount++;
                    elseif ($p->stock <= $p->min_stock) $lowStockCount++;
                }
            }
        }

        return [
            'total_value'    => $totalValue,
            'total_items'    => $totalItems,
            'low_stock'      => $lowStockCount,
            'out_of_stock'   => $outOfStockCount,
            'products_count' => $products->count(),
        ];
    }

    private function buildQuery()
    {
        return Product::with(['category', 'supplier'])
            ->where('is_active', true)
            ->when($this->search, fn($q) => $q->where(function($sq) {
                $sq->where('name', 'like', '%' . $this->search . '%')
                   ->orWhere('sku', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterSupplier, fn($q) => $q->where('supplier_id', $this->filterSupplier))
            ->when($this->filterStock === 'out',  fn($q) => $q->where('manage_stock', true)->where('stock', 0))
            ->when($this->filterStock === 'low',  fn($q) => $q->where('manage_stock', true)->whereColumn('stock', '<=', 'min_stock')->where('stock', '>', 0))
            ->when($this->filterStock === 'ok',   fn($q) => $q->where(function($sq) {
                $sq->where('manage_stock', false)->orWhereColumn('stock', '>', 'min_stock');
            }))
            ->orderBy('name');
    }

    public function adjustStock($productId, $newStock)
    {
        $product = Product::findOrFail($productId);
        $product->update(['stock' => $newStock]);
        
        session()->flash('message', 'Stock de ' . $product->name . ' ajustado correctamente.');
    }

    public function render()

    {
        $products = $this->buildQuery()->paginate(20);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $suppliers  = Supplier::where('active', true)->orderBy('name')->get();

        return view('livewire.reports.inventory', [
            'products'   => $products,
            'categories' => $categories,
            'suppliers'  => $suppliers,
        ])->layout('layouts.app');
    }
}
