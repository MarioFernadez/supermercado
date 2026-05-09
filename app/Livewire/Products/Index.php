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


    #[Rule('required|min:3')]
    public $name;

    #[Rule('nullable|unique:products,sku')]
    public $sku;

    public $description;

    #[Rule('required')]
    public $price_cost;

    #[Rule('required')]
    public $price_sale;

    #[Rule('required|numeric|min:0')]
    public $stock = 0;

    #[Rule('required|numeric|min:0')]
    public $min_stock = 5;

    #[Rule('nullable|exists:categories,id')]
    public $category_id;

    #[Rule('nullable|exists:suppliers,id')]
    public $supplier_id;

    #[Rule('required|in:unit,kg,liter,meter')]
    public $unit_type = 'unit';

    public $manage_stock = true;
    public $is_active = true;
    public $discount_percentage = 0;
    
    public $product_image;
    public $product_image_path;

    // Variations
    public $has_variations = false;
    public $variations = []; // Each: ['name' => '', 'sku' => '', 'price_cost' => '', 'price_sale' => '', 'stock' => 0]


    public function render()
    {
        $discountProductEnabled = \App\Models\StoreSetting::where('key', 'discount_product_enabled')->value('value') === '1';

        $products = Product::with(['category', 'supplier'])
            ->search($this->search, ['name', 'sku'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('active', true)->orderBy('name')->get();

        return view('livewire.products.index', [
            'products'               => $products,
            'categories'             => $categories,
            'suppliers'              => $suppliers,
            'discountProductEnabled' => $discountProductEnabled,
        ])->layout('layouts.app');
    }

    protected function resetInputFields()
    {
        $this->productId = null;
        $this->name = '';
        $this->sku = '';
        $this->description = '';
        $this->price_cost = '';
        $this->price_sale = '';
        $this->stock = 0;
        $this->min_stock = 5;
        $this->category_id = null;
        $this->supplier_id = null;
        $this->unit_type = 'unit';
        $this->manage_stock = true;
        $this->is_active = true;
        $this->discount_percentage = 0;
        $this->product_image = null;
        $this->product_image_path = null;
        $this->has_variations = false;
        $this->variations = [];
        $this->resetValidation();

    }

    public function store()
    {
        $id = $this->productId ?: null;

        // Authorization check
        if ($id) {
            // Updating existing product
            $product = Product::findOrFail($id);
            $this->authorize('update', $product);
        } else {
            // Creating new product
            $this->authorize('create', Product::class);
        }

        $rules = [
            'name'       => 'required|min:3',
            'sku'        => 'nullable|unique:products,sku' . ($id ? ',' . $id : ''),
            'description'=> 'nullable|string',
            'price_cost' => 'required',
            'price_sale' => 'required',
            'stock'      => $this->manage_stock ? 'required|numeric|min:0' : 'nullable',
            'min_stock'  => $this->manage_stock ? 'required|numeric|min:0' : 'nullable',
            'unit_type'  => 'required|in:unit,kg,liter,meter',
            'discount_percentage' => 'integer|min:0|max:100',
            'product_image' => 'nullable|image|max:1024',
        ];

        $this->validate($rules);

        if ($this->product_image) {
            // Delete old if exists
            if ($this->product_image_path) {
                Storage::disk('public')->delete($this->product_image_path);
            }
            $this->product_image_path = $this->product_image->store('products', 'public');
        }

        // Auto-generate SKU if empty
        if (empty($this->sku)) {
            do {
                $this->sku = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            } while (Product::where('sku', $this->sku)->exists());
        }

        $product = Product::updateOrCreate(['id' => $id], [
            'name'       => $this->name,
            'sku'        => $this->sku,
            'description'=> $this->description,
            'price_cost' => $this->price_cost,
            'price_sale' => $this->price_sale,
            'discount_percentage' => (int) $this->discount_percentage,
            'stock'      => $this->manage_stock ? $this->stock : 0,
            'min_stock'  => $this->manage_stock ? $this->min_stock : 0,
            'category_id' => $this->category_id ?: null,
            'supplier_id' => $this->supplier_id ?: null,
            'unit_type'  => $this->unit_type,
            'manage_stock' => $this->manage_stock,
            'has_variations' => $this->has_variations,
            'is_active'  => $this->is_active,
            'image_path' => $this->product_image_path
        ]);

        // Handle Variations
        if ($this->has_variations) {
            $existingIds = [];
            foreach ($this->variations as $var) {
                $v = $product->variations()->updateOrCreate(
                    ['id' => $var['id'] ?? null],
                    [
                        'name' => $var['name'],
                        'sku' => $var['sku'] ?: $product->sku . '-' . \Illuminate\Support\Str::random(4),
                        'price_cost' => $var['price_cost'],
                        'price_sale' => $var['price_sale'],
                        'stock' => $var['stock'],
                        'is_active' => true
                    ]
                );
                $existingIds[] = $v->id;
            }
            // Delete removed variations
            $product->variations()->whereNotIn('id', $existingIds)->delete();
        } else {
            // If switched to simple, maybe delete variations? 
            // Better to keep them but they won't be used. For safety, we can delete.
            $product->variations()->delete();
        }


        session()->flash('message', $this->productId ? 'Producto actualizado correctamente.' : 'Producto creado correctamente.');

        $this->closeModal();
    }

    public function addVariation()
    {
        $this->variations[] = [
            'id' => null,
            'name' => '',
            'sku' => '',
            'price_cost' => $this->price_cost,
            'price_sale' => $this->price_sale,
            'stock' => 0
        ];
    }

    public function removeVariation($index)
    {
        unset($this->variations[$index]);
        $this->variations = array_values($this->variations);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId   = $id;
        $this->name        = $product->name;
        $this->sku         = $product->sku;
        $this->description = $product->description;
        $this->price_cost  = $product->formatPyg($product->price_cost);
        $this->price_sale  = $product->formatPyg($product->price_sale);
        $this->stock       = $product->stock;
        $this->min_stock   = $product->min_stock;
        $this->category_id = $product->category_id;
        $this->supplier_id = $product->supplier_id;
        $this->unit_type   = $product->unit_type;
        $this->manage_stock = $product->manage_stock;
        $this->is_active   = $product->is_active;
        $this->discount_percentage = $product->discount_percentage;
        $this->product_image_path = $product->image_path;
        $this->has_variations = $product->has_variations;
        
        $this->variations = $product->variations->map(fn($v) => [
            'id' => $v->id,
            'name' => $v->name,
            'sku' => $v->sku,
            'price_cost' => $v->formatPyg($v->price_cost),
            'price_sale' => $v->formatPyg($v->price_sale),
            'stock' => $v->stock
        ])->toArray();


        $this->openModal();
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
