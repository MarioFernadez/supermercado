<?php

namespace App\Livewire\Purchases;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $supplier_id;
    public $purchase_date;
    public $reference_number;
    public $notes;
    public $search = '';
    public $items = [];
    public $total = 0;

    public function mount()
    {
        $this->purchase_date = date('Y-m-d');
    }

    public function addItem($productId, $variationId = null)
    {
        $product = Product::find($productId);
        if (!$product) return;

        $variation = $variationId ? \App\Models\ProductVariation::find($variationId) : null;
        $key = $variationId ? "p{$productId}v{$variationId}" : "p{$productId}";

        if (isset($this->items[$key])) {
            $this->items[$key]['quantity']++;
        } else {
            $this->items[$key] = [
                'id' => $product->id,
                'variation_id' => $variationId,
                'name' => $product->name . ($variation ? " [{$variation->name}]" : ""),
                'cost_price' => $variation ? ($variation->price_cost ?: $product->price_cost) : $product->price_cost,
                'quantity' => 1,
            ];
        }
        $this->calculateTotal();
        $this->search = '';
    }

    public function removeItem($key)
    {
        unset($this->items[$key]);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->items, function($carry, $item) {
            return $carry + ($item['cost_price'] * $item['quantity']);
        }, 0);
    }

    public function save()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        DB::transaction(function() {
            $purchase = Purchase::create([
                'supplier_id' => $this->supplier_id,
                'user_id' => auth()->id(),
                'purchase_date' => $this->purchase_date,
                'total' => $this->total,
                'reference_number' => $this->reference_number,
                'notes' => $this->notes,
            ]);

            foreach ($this->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['id'],
                    'product_variation_id' => $item['variation_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $item['cost_price'] * $item['quantity'],
                ]);

                $product = Product::find($item['id']);
                if ($product->manage_stock) {
                    if ($item['variation_id']) {
                        $variation = \App\Models\ProductVariation::find($item['variation_id']);
                        if ($variation) {
                            $variation->increment('stock', $item['quantity']);
                            $variation->update(['price_cost' => $item['cost_price']]);
                        }
                    } else {
                        $product->increment('stock', $item['quantity']);
                    }
                }
                
                // Si no tiene variación o si queremos actualizar el precio base también
                if (!$item['variation_id']) {
                    $product->update(['price_cost' => $item['cost_price']]);
                }
            }
        });

        session()->flash('message', 'Compra registrada correctamente. El stock ha sido actualizado.');
        return redirect()->route('purchases.index');
    }

    public function render()
    {
        $suppliers = Supplier::where('active', true)->orderBy('name')->get();
        $productsList = [];
        if (strlen($this->search) > 1) {
            $productsList = Product::with('variations')
                ->where('is_active', true)
                ->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhereHas('variations', function($vq) {
                          $vq->where('sku', 'like', '%' . $this->search . '%');
                      });
                })
                ->take(10)
                ->get();
        }

        return view('livewire.purchases.create', [
            'suppliers' => $suppliers,
            'productsList' => $productsList
        ])->layout('layouts.app');
    }
}
