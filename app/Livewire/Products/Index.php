<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Livewire\BaseCrudComponent;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class Index extends BaseCrudComponent
{
    use WithFileUploads;

    public $productId;

    protected function resetInputFields()
    {
        // No necesario en esta vista, pero requerido por BaseCrudComponent
    }

    public function render()
    {
        $discountProductEnabled = \App\Models\StoreSetting::where('key', 'discount_product_enabled')->value('value') === '1';

        $products = Product::with(['category', 'supplier'])
            ->search($this->search, ['name', 'sku'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('active', true)->orderBy('name')->get();
        $units = \App\Models\Unit::where('is_active', true)->orderBy('name')->get();
        $branches = \App\Models\Branch::where('is_active', true)->orderBy('name')->get();

        return view('livewire.products.index', [
            'products'               => $products,
            'categories'             => $categories,
            'suppliers'              => $suppliers,
            'units'                  => $units,
            'branches'               => $branches,
            'discountProductEnabled' => $discountProductEnabled,
        ])->layout('layouts.app');
    }



    public function delete($id)
    {
        $product = Product::findOrFail($id);
        
        // Authorization check
        $this->authorize('delete', $product);
        
        $product->delete();
        session()->flash('message', 'Producto eliminado correctamente.');
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;
        
        // Authorization check - verify user can delete products
        $this->authorize('delete', Product::class);
        
        Product::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', 'Productos seleccionados eliminados correctamente.');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Product::search($this->search, ['name', 'sku'])
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selected = [];
        }
    }
}
