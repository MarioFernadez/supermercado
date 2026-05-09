<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function printSales(Request $request) {
        $from = $request->query('from', Carbon::today()->format('Y-m-d'));
        $to = $request->query('to', Carbon::today()->format('Y-m-d'));

        // Fetch Sales
        $sales = Sale::with(['user', 'customer', 'seller'])
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPeriod = $sales->sum('total');

        // Fetch Sold Products (Aggregated with Cost)
        $soldProducts = SaleItem::whereHas('sale', function($q) use ($from, $to) {
                $q->whereDate('created_at', '>=', $from)
                  ->whereDate('created_at', '<=', $to);
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

        // Calculate Profit Stats
        $profitStats = [
            'sales' => $soldProducts->sum('total_amount'),
            'cost' => $soldProducts->sum('total_cost'),
            'profit' => $soldProducts->sum('total_amount') - $soldProducts->sum('total_cost'),
            'margin' => $soldProducts->sum('total_amount') > 0 
                ? (($soldProducts->sum('total_amount') - $soldProducts->sum('total_cost')) / $soldProducts->sum('total_amount')) * 100 
                : 0
        ];

        // Payment Methods aggregation
        $paymentMethods = \App\Models\Payment::whereHas('sale', function($q) use ($from, $to) {
                $q->whereDate('created_at', '>=', $from)
                  ->whereDate('created_at', '<=', $to);
            })
            ->selectRaw('method, SUM(amount) as total')
            ->groupBy('method')
            ->orderByDesc('total')
            ->get();

        // Sales by Supplier
        $salesBySupplier = SaleItem::whereHas('sale', function($q) use ($from, $to) {
                $q->whereDate('created_at', '>=', $from)
                  ->whereDate('created_at', '<=', $to);
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

        return view('reports.sales-print', compact('sales', 'totalPeriod', 'soldProducts', 'from', 'to', 'profitStats', 'paymentMethods', 'salesBySupplier'));
    }

    public function printCashSessions(Request $request) {
        $from = $request->query('from', Carbon::today()->startOfMonth()->format('Y-m-d'));
        $to = $request->query('to', Carbon::today()->endOfMonth()->format('Y-m-d'));
        $userId = $request->query('user_id');

        $sessions = \App\Models\CashSession::with('user')
            ->whereDate('opened_at', '>=', $from)
            ->whereDate('opened_at', '<=', $to)
            ->when($userId, function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'closed')
            ->orderBy('opened_at', 'desc')
            ->get();

        return view('reports.cash-sessions-print', compact('sessions', 'from', 'to'));
    }
    public function printInventory(Request $request)
    {
        $filterCategory = $request->query('category', '');
        $filterSupplier = $request->query('supplier', '');
        $filterStock    = $request->query('stock', '');

        $query = \App\Models\Product::with(['category', 'supplier'])
            ->where('is_active', true)
            ->when($filterCategory, fn($q) => $q->where('category_id', $filterCategory))
            ->when($filterSupplier, fn($q) => $q->where('supplier_id', $filterSupplier))
            ->when($filterStock === 'out',  fn($q) => $q->where('manage_stock', true)->where('stock', 0))
            ->when($filterStock === 'low',  fn($q) => $q->where('manage_stock', true)->whereColumn('stock', '<=', 'min_stock')->where('stock', '>', 0))
            ->when($filterStock === 'ok',   fn($q) => $q->where(function($sq) {
                $sq->where('manage_stock', false)->orWhereColumn('stock', '>', 'min_stock');
            }))
            ->orderBy('name');

        $products   = $query->get();
        $categories = \App\Models\Category::all()->keyBy('id');
        $suppliers  = \App\Models\Supplier::all()->keyBy('id');

        return view('reports.inventory-print', compact('products', 'categories', 'suppliers', 'filterCategory', 'filterSupplier'));
    }

    public function printAccountStatement(Request $request, $customerId)
    {
        $customer = \App\Models\Customer::with(['transactions' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->findOrFail($customerId);

        return view('reports.account-statement-print', compact('customer'));
    }
}
