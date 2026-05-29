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

    public function updatedDateFrom() { $this->dispatch('update-profit-chart', ['data' => $this->getEvolutionData()]); }
    public function updatedDateTo() { $this->dispatch('update-profit-chart', ['data' => $this->getEvolutionData()]); }

    // Helper to get raw evolution data for live updates
    private function getEvolutionData() {
        // Redundant logic for Alpine update payload
        $revenueByDay = Sale::whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')->orderBy('date')->get()->keyBy('date');

        $costByDay = SaleItem::whereHas('sale', function($q) {
                $q->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('DATE(sale_items.created_at) as date, SUM(sale_items.quantity * products.price_cost) as cost')
            ->groupBy('date')->orderBy('date')->get()->keyBy('date');

        $evolutionData = [];
        $currentDate = Carbon::parse($this->dateFrom);
        $endDate = Carbon::parse($this->dateTo);

        while ($currentDate->lte($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            $rev = $revenueByDay->get($dateStr)->total ?? 0;
            $cst = $costByDay->get($dateStr)->cost ?? 0;
            $evolutionData[] = [
                'date' => $currentDate->format('d/m'),
                'revenue' => (float)$rev,
                'profit' => (float)($rev - $cst)
            ];
            $currentDate->addDay();
        }
        return $evolutionData;
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

        // 7. Evolution Data for Chart
        // Group revenue by date
        $revenueByDay = Sale::whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Group cost by date
        $costByDay = SaleItem::whereHas('sale', function($q) {
                $q->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('DATE(sale_items.created_at) as date, SUM(sale_items.quantity * products.price_cost) as cost')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Merge into an evolution array
        $evolutionData = [];
        $currentDate = Carbon::parse($this->dateFrom);
        $endDate = Carbon::parse($this->dateTo);

        while ($currentDate->lte($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            $rev = $revenueByDay->get($dateStr)->total ?? 0;
            $cst = $costByDay->get($dateStr)->cost ?? 0;
            $evolutionData[] = [
                'date' => $currentDate->format('d/m'),
                'revenue' => (float)$rev,
                'profit' => (float)($rev - $cst)
            ];
            $currentDate->addDay();
        }

        return view('livewire.reports.profit', [
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'grossProfit' => $grossProfit,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'salesCount' => $salesCount,
            'avgTicket' => $avgTicket,
            'profitMargin' => $profitMargin,
            'evolutionData' => $evolutionData
        ])->layout('layouts.app');
    }
}
