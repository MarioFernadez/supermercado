<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use Carbon\Carbon;

class Sales extends Component
{
    use WithPagination;

    public $dateFrom;
    public $dateTo;
    public $channel = 'all'; // all, pos, web

    // Detail View
    public $showingSaleDetails = false;
    public $selectedSale = null;

    public function mount()
    {
        $this->filterToday();
    }

    public function filterToday()
    {
        $this->dateFrom = Carbon::today()->format('Y-m-d');
        $this->dateTo = Carbon::today()->format('Y-m-d');
    }

    public function filterWeek()
    {
        $this->dateFrom = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfWeek()->format('Y-m-d');
    }

    public function getSoldProductsProperty()
    {
        return \App\Models\SaleItem::whereHas('sale', function($q) {
                $q->whereDate('created_at', '>=', $this->dateFrom)
                  ->whereDate('created_at', '<=', $this->dateTo)
                  ->where('status', '!=', 'voided');
            })
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('
                product_name, 
                SUM(quantity) as total_qty, 
                SUM(subtotal) as total_amount,
                SUM(quantity * products.price_cost) as total_cost
            ')
            ->groupBy('product_name')
            ->orderByDesc('total_amount')
            ->get();
    }

    public function getProfitStatsProperty()
    {
        // Calculate based on the Sold Products aggregation to respect relationships
        $stats = $this->soldProducts;
        
        $totalSales = $stats->sum('total_amount');
        $totalCost = $stats->sum('total_cost');
        $profit = $totalSales - $totalCost;
        
        return [
            'sales' => $totalSales,
            'cost' => $totalCost,
            'profit' => $profit,
            'margin' => $totalSales > 0 ? ($profit / $totalSales) * 100 : 0
        ];
    }

    public function getPaymentMethodsProperty()
    {
        return \App\Models\Payment::whereHas('sale', function($q) {
                $q->whereDate('created_at', '>=', $this->dateFrom)
                  ->whereDate('created_at', '<=', $this->dateTo)
                  ->where('status', '!=', 'voided');
            })
            ->selectRaw('method, SUM(amount) as total')
            ->groupBy('method')
            ->orderByDesc('total')
            ->get();
    }

    public function getSalesBySupplierProperty()
    {
        return \App\Models\SaleItem::whereHas('sale', function($q) {
                $q->whereDate('created_at', '>=', $this->dateFrom)
                  ->whereDate('created_at', '<=', $this->dateTo)
                  ->where('status', '!=', 'voided');
            })
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->selectRaw('
                COALESCE(suppliers.name, \'Sin Proveedor\') as supplier_name,
                SUM(sale_items.subtotal) as total_sales,
                COUNT(sale_items.id) as items_count
            ')
            ->groupBy('supplier_name')
            ->orderByDesc('total_sales')
            ->get();
    }

    public function voidSale($saleId)
    {
        abort_unless(auth()->user()->can('admin') || auth()->user()->can('gerente'), 403);

        \DB::transaction(function () use ($saleId) {
            $sale = Sale::with('items')->find($saleId);

            if (!$sale || $sale->status === 'voided') {
                return;
            }

            // Restore Stock
            foreach ($sale->items as $item) {
                if ($item->product_variation_id) {
                    \App\Models\ProductVariation::where('id', $item->product_variation_id)->increment('stock', $item->quantity);
                } else {
                    \App\Models\Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                }
            }

            // Mark as Voided
            $sale->update(['status' => 'voided']);
        });

        session()->flash('message', 'Venta anulada correctamente. Stock restaurado.');
    }

    public function viewDetails($saleId)
    {
        $this->selectedSale = Sale::with(['items.product', 'payments', 'customer', 'seller'])->findOrFail($saleId);
        $this->showingSaleDetails = true;
    }

    public function closeDetails()
    {
        $this->showingSaleDetails = false;
        $this->selectedSale = null;
    }

    public function reprintReceipt($saleId)
    {
        $this->dispatch('print-ticket', ['saleId' => $saleId]);
        session()->flash('message', 'Comando de impresión enviado para la venta #' . $saleId);
    }

    public function render()
    {
        $sales = Sale::with(['user', 'customer', 'seller'])
            ->whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo)
            ->when($this->channel !== 'all', function($q) {
                if ($this->channel === 'web') {
                    return $q->whereNotNull('web_order_id');
                } else {
                    return $q->whereNull('web_order_id');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalPeriod = Sale::whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo)
            ->when($this->channel !== 'all', function($q) {
                if ($this->channel === 'web') {
                    return $q->whereNotNull('web_order_id');
                } else {
                    return $q->whereNull('web_order_id');
                }
            })
            ->where('status', '!=', 'voided')
            ->sum('total');

        return view('livewire.reports.sales', [
            'sales' => $sales,
            'totalPeriod' => $totalPeriod
        ])->layout('layouts.app');
    }
}
