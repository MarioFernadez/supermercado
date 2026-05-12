<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\CashSession;
use App\Models\CashMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom;
    public $dateTo;
    public $categoryId = '';

    // Create/Edit Modal
    public $isOpen = false;
    public $expenseId;
    public $form = [
        'expense_category_id' => '',
        'amount' => '',
        'description' => '',
        'date' => '',
        'payment_method' => 'efectivo',
        'reference' => ''
    ];

    public function mount()
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->form['date'] = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        $expenses = Expense::with(['category', 'user'])
            ->whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->when($this->categoryId, fn($q) => $q->where('expense_category_id', $this->categoryId))
            ->when($this->search, fn($q) => $q->where('description', 'like', '%' . $this->search . '%'))
            ->orderBy('date', 'desc')
            ->paginate(15);

        $categories = ExpenseCategory::where('is_active', true)->orderBy('name')->get();
        
        $totalPeriod = Expense::whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->when($this->categoryId, fn($q) => $q->where('expense_category_id', $this->categoryId))
            ->sum('amount');

        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->orderBy('name')->get();

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
            'categories' => $categories,
            'paymentMethods' => $paymentMethods,
            'totalPeriod' => $totalPeriod
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->expenseId = null;
        $this->form = [
            'expense_category_id' => '',
            'amount' => '',
            'description' => '',
            'date' => Carbon::today()->format('Y-m-d'),
            'payment_method' => 'efectivo',
            'reference' => ''
        ];
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate([
            'form.expense_category_id' => 'required',
            'form.amount' => 'required|numeric|min:1',
            'form.description' => 'required|min:3',
            'form.date' => 'required|date',
            'form.payment_method' => 'required'
        ]);

        try {
            \DB::transaction(function () {
                $isNew = !$this->expenseId;
                
                $data = $this->form;
                $data['user_id'] = auth()->id();

                // If payment is Cash, link to current session if open
                if ($data['payment_method'] === 'efectivo') {
                    $session = CashSession::where('user_id', auth()->id())
                        ->where('status', 'open')
                        ->first();
                    
                    if ($session) {
                        $data['cash_session_id'] = $session->id;
                    }
                }

                $expense = Expense::updateOrCreate(['id' => $this->expenseId], $data);

                // If it's a NEW Cash expense and we have a session, record movement
                if ($isNew && $data['payment_method'] === 'efectivo' && isset($data['cash_session_id'])) {
                    CashMovement::create([
                        'cash_session_id' => $data['cash_session_id'],
                        'type' => 'out',
                        'amount' => $data['amount'],
                        'description' => 'Gasto: ' . $data['description'],
                        'reference' => 'EXP-' . $expense->id
                    ]);
                }
            });

            session()->flash('message', $this->expenseId ? 'Gasto actualizado.' : 'Gasto registrado correctamente.');
            $this->isOpen = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $this->expenseId = $id;
        $this->form = [
            'expense_category_id' => $expense->expense_category_id,
            'amount' => $expense->amount,
            'description' => $expense->description,
            'date' => $expense->date->format('Y-m-d'),
            'payment_method' => $expense->payment_method,
            'reference' => $expense->reference
        ];
        $this->isOpen = true;
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        
        // Note: We don't automatically reverse CashMovements for now to avoid complexity,
        // but it could be added if needed.
        
        $expense->delete();
        session()->flash('message', 'Gasto eliminado.');
    }
}
