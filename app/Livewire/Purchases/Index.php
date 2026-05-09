<?php

namespace App\Livewire\Purchases;

use Livewire\Component;
use App\Models\Purchase;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $purchases = Purchase::with(['supplier', 'user'])
            ->whereHas('supplier', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('reference_number', 'like', '%' . $this->search . '%')
            ->orderBy('purchase_date', 'desc')
            ->paginate(10);

        return view('livewire.purchases.index', [
            'purchases' => $purchases
        ])->layout('layouts.app');
    }
}
