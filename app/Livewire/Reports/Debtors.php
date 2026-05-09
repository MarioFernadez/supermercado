<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Debtors extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $debtors = Customer::query()
            ->with('transactions')
            ->where('is_active', true)
            ->whereHas('transactions')
            ->get()
            ->filter(function($customer) {
                return $customer->balance > 0;
            });

        // Search locally since balance is an accessor
        if (!empty($this->search)) {
            $debtors = $debtors->filter(function($customer) {
                return str_contains(strtolower($customer->name), strtolower($this->search)) || 
                       str_contains(strtolower($customer->ruc), strtolower($this->search));
            });
        }

        $totalDebt = $debtors->sum(function($customer) {
            return $customer->balance;
        });

        return view('livewire.reports.debtors', [
            'debtors' => $debtors->sortByDesc(fn($c) => $c->balance),
            'totalDebt' => $totalDebt
        ])->layout('layouts.app');
    }
}
