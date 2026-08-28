<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CashSession;
use Carbon\Carbon;

class CashSessions extends Component
{
    use WithPagination;

    public $dateFrom;
    public $dateTo;

    public $users;
    public $selectedUser = '';

    public function mount()
    {
        $this->filterToday(); // Default to today or start of month? User asked for buttons "like Sales", Sales defaults to Today.
        $this->users = \App\Models\User::orderBy('name')->get();
    }

    public function filterToday()
    {
        $this->dateFrom = Carbon::today()->format('Y-m-d');
        $this->dateTo = Carbon::today()->format('Y-m-d');
        $this->resetPage();
    }

    public function filterWeek()
    {
        $this->dateFrom = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfWeek()->format('Y-m-d');
        $this->resetPage();
    }

    public function render()
    {
        $sessions = CashSession::with('user')
            ->whereDate('opened_at', '>=', $this->dateFrom)
            ->whereDate('opened_at', '<=', $this->dateTo)
            ->when($this->selectedUser, function($query) {
                $query->where('user_id', $this->selectedUser);
            })
            ->where('status', 'closed')
            ->orderBy('opened_at', 'desc')
            ->paginate(15);

        return view('livewire.reports.cash-sessions', [
            'sessions' => $sessions
        ])->layout('layouts.app');
    }




    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }
}
