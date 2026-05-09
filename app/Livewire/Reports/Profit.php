<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Expense;
use Carbon\Carbon;

class Profit extends Component
{
    public $dateFrom;
    public $dateTo;

    public function mount()
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        // 1. Sales Revenue (Gross Sales)
        $totalRevenue = Sale::whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
            ->where('status', 'completed') // Assuming 'completed' is the status for final sales
            ->sum('total');

        // 2. Cost of Goods Sold (COGS)
        // We join with products to get the price_cost
        $totalCost = SaleItem::whereHas('sale', function($q) {
                $q->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('SUM(sale_items.quantity * products.price_cost) as cost')
            ->first()->cost ?? 0;

        // 3. Gross Profit
        $grossProfit = $totalRevenue - $totalCost;

        // 4. Operating Expenses
        $totalExpenses = Expense::whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->sum('amount');

        // 5. Net Profit
        $netProfit = $grossProfit - $totalExpenses;

        // 6. Stats for Breakdown
        $salesCount = Sale::whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->count();

        $avgTicket = $salesCount > 0 ? $totalRevenue / $salesCount : 0;
        
        $profitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;

        return view('livewire.reports.profit', [
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'grossProfit' => $grossProfit,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'salesCount' => $salesCount,
            'avgTicket' => $avgTicket,
            'profitMargin' => $profitMargin
        ])->layout('layouts.app');
    }
}
