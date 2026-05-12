<?php

namespace App\Livewire\Expenses;

use App\Models\ExpenseCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $categoryId;
    public $name = '';
    public $description = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:3|unique:expense_categories,name',
    ];

    public function render()
    {
        $categories = ExpenseCategory::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.expenses.categories', [
            'categories' => $categories
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->description = '';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->categoryId) {
            $rules['name'] = 'required|min:3|unique:expense_categories,name,' . $this->categoryId;
        }

        $this->validate($rules);

        ExpenseCategory::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->categoryId ? 'Categoría actualizada.' : 'Categoría creada.');
        $this->isOpen = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        if ($category->expenses()->count() > 0) {
            session()->flash('error', 'No se puede eliminar una categoría que tiene gastos asociados.');
            return;
        }
        $category->delete();
        session()->flash('message', 'Categoría eliminada.');
    }
}
