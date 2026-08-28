<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\CashSession;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Collections extends Component
{
    use WithPagination;

    public $search = '';
    public $showPaymentModal = false;
    public $selectedCustomer = null;
    public $paymentAmount = 0;
    public $paymentDescription = 'Cobro de cuota/crédito';
    public $paymentMethod = 'efectivo';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openPaymentModal($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->selectedCustomer = [
            'id' => $customer->id,
            'name' => $customer->name,
            'balance' => $customer->balance
        ];
        $this->paymentAmount = $customer->balance;
        $this->showPaymentModal = true;
    }

    public function registerPayment()
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:1',
            'paymentDescription' => 'required|string|max:255',
            'paymentMethod' => 'required|in:efectivo,tarjeta,transferencia,pos',
        ]);

        $session = CashSession::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if (!$session && $this->paymentMethod === 'efectivo') {
            session()->flash('error', 'Debes tener una caja abierta para registrar cobros en efectivo.');
            return;
        }

        DB::transaction(function () use ($session) {
            // 1. Register Transaction (Credit)
            CustomerTransaction::create([
                'customer_id' => $this->selectedCustomer['id'],
                'type' => 'credit',
                'amount' => $this->paymentAmount,
                'reference_type' => 'payment',
                'description' => $this->paymentDescription . ' (' . ucfirst($this->paymentMethod) . ')',
            ]);

            // 2. If it's cash or POS, register as movement in the session
            if ($session && ($this->paymentMethod === 'efectivo' || $this->paymentMethod === 'pos')) {
                $session->movements()->create([
                    'type' => 'in',
                    'category' => 'Cobranza',
                    'amount' => $this->paymentAmount,
                    'description' => 'Cobro a cliente: ' . $this->selectedCustomer['name'],
                ]);
            }
        });

        $this->showPaymentModal = false;
        $this->reset(['selectedCustomer', 'paymentAmount', 'paymentDescription', 'paymentMethod']);
        session()->flash('message', 'Pago registrado correctamente.');
    }

    public function render()
    {
        // Obtener clientes que tengan algún movimiento y filtrar por balance > 0
        $customers = Customer::where('is_active', true)
            ->where('name', 'like', '%' . $this->search . '%')
            ->get()
            ->filter(function ($customer) {
                return $customer->balance > 0;
            });

        return view('livewire.admin.collections', [
            'customers' => $customers
        ])->layout('layouts.app');
    }
}
