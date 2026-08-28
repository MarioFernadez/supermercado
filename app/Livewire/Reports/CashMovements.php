<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CashMovement;
use App\Models\User;
use Carbon\Carbon;

class CashMovements extends Component
{
    use WithPagination;

    // Filters
    public $startDate;
    public $endDate;
    public $filterType = 'all'; // all, in, out
    public $filterCategory = '';
    public $filterUser = '';

    // Totals
    public $totalIn = 0;
    public $totalOut = 0;
    public $netTotal = 0;

    public function mount()
    {
        // Default to current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function updatedFilterUser()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Build query
        $query = CashMovement::with(['session.user'])
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);

        // Apply filters
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterUser) {
            $query->whereHas('session', function($q) {
                $q->where('user_id', $this->filterUser);
            });
        }

        // Get movements
        $movements = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate totals for the filtered period
        $totalsQuery = CashMovement::whereBetween('created_at', [
            Carbon::parse($this->startDate)->startOfDay(),
            Carbon::parse($this->endDate)->endOfDay()
        ]);

        if ($this->filterUser) {
            $totalsQuery->whereHas('session', function($q) {
                $q->where('user_id', $this->filterUser);
            });
        }

        $this->totalIn = $totalsQuery->where('type', 'in')->sum('amount');
        $this->totalOut = $totalsQuery->where('type', 'out')->sum('amount');
        $this->netTotal = $this->totalIn - $this->totalOut;

        // Get users for filter
        $users = User::orderBy('name')->get();

        // Get all categories
        $categories = CashMovement::CATEGORIES;

        return view('livewire.reports.cash-movements', [
            'movements' => $movements,
            'users' => $users,
            'categories' => $categories
        ])->layout('layouts.app');
    }
}
