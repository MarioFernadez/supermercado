<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\CashSession;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today()->format('Y-m-d');

        // 1. KPI Stats
        // Fetch Today's Sales - Optimized to use DB sum directly
        $totalSalesToday = Sale::whereDate('created_at', $today)->sum('total');

        // Estimate Profit (Basic Calculation: Sales - Cost of items sold today)
        // We use a join for efficiency
        $costToday = SaleItem::whereHas('sale', function($q) use ($today) {
                $q->whereDate('created_at', $today);
                $q->where('status', '!=', 'voided'); // Only non-voided sales
            })
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->sum(\DB::raw('quantity * products.price_cost'));

        $estimatedProfit = $totalSalesToday - $costToday;

        // Open Sessions
        $openSessionsCount = CashSession::where('status', 'open')
            ->whereHas('user', function($query) {
                $query->whereNull('deleted_at');
            })->count();

        // 2. Low Stock Alerts
        // Check products where stock <= min_stock AND is_active
        $lowStockProducts = Product::where('is_active', true)
            ->where('manage_stock', true) // Added condition to ensure only stock-managed products appear
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->take(10)
            ->get();

        // 3. Recent Sales
        $recentSales = Sale::with(['user', 'customer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Sales Chart (Last 7 Days)
        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesLabels[] = $date->isoFormat('ddd D');
            $salesData[] = Sale::whereDate('created_at', $date->format('Y-m-d'))
                ->where('status', '!=', 'voided')
                ->sum('total');
        }

        // 5. Pending Web Orders
        $pendingWebOrdersCount = \App\Models\WebOrder::where('status', 'Pendiente WhatsApp')->count();

        // 6. Total Active Customers
        $totalCustomers = \App\Models\Customer::where('is_active', true)->count();

        // 7. Top Selling Products (Last 30 Days)
        $topProducts = SaleItem::select('product_name', \DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('sale', function($q) {
                $q->where('created_at', '>=', Carbon::now()->subDays(30));
                $q->where('status', '!=', 'voided');
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'totalSalesToday' => $totalSalesToday,
            'estimatedProfit' => $estimatedProfit,
            'openSessionsCount' => $openSessionsCount,
            'lowStockProducts' => $lowStockProducts,
            'recentSales' => $recentSales,
            'salesLabels' => $salesLabels,
            'salesData' => $salesData,
            'pendingWebOrdersCount' => $pendingWebOrdersCount,
            'totalCustomers' => $totalCustomers,
            'topProducts' => $topProducts
        ])->layout('layouts.app');
    }
}
