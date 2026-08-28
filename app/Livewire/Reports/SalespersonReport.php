<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Seller;

class SalespersonReport extends Component
{
    public $dateFrom;
    public $dateTo;
    public $filterShift = '';

    public function mount()
    {
        $this->dateFrom = Carbon::today()->format('Y-m-d');
        $this->dateTo = Carbon::today()->format('Y-m-d');
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

    public function filterMonth()
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function getSalespersonStatsProperty()
    {
        return Sale::with('seller')
            ->whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo)
            ->where('status', '!=', 'voided')
            ->whereNotNull('seller_id')
            ->when($this->filterShift, function ($q) {
                $q->whereHas('seller', fn($s) => $s->where('shift', $this->filterShift));
            })
            ->selectRaw('seller_id, COUNT(*) as sales_count, SUM(total) as total_amount')
            ->groupBy('seller_id')
            ->orderByDesc('total_amount')
            ->get()
            ->map(function ($row) {
                $row->seller_name  = $row->seller ? $row->seller->name : 'Desconocido';
                $row->seller_code  = $row->seller ? ($row->seller->code ?? '—') : '—';
                $row->seller_shift = $row->seller ? ($row->seller->shift ?? '') : '';
                $row->average_ticket = $row->sales_count > 0 ? $row->total_amount / $row->sales_count : 0;
                return $row;
            });
    }

    public function getSalesTotalProperty()
    {
        return $this->salespersonStats->sum('total_amount');
    }

    public function render()
    {
        return view('livewire.reports.salesperson-report')
            ->layout('layouts.app');
    }
}
