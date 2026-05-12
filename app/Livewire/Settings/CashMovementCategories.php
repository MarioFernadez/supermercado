<?php

namespace App\Livewire\Settings;

use App\Models\CashMovementCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CashMovementCategories extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $categoryId;
    public $name = '';
    public $type = 'both';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:3',
        'type' => 'required|in:income,expense,both',
    ];

    public function render()
    {
        $categories = CashMovementCategory::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.settings.cash-movement-categories', [
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
        $category = CashMovementCategory::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->type = $category->type;
        $this->is_active = $category->is_active;
        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->type = 'both';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        CashMovementCategory::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
            'type' => $this->type,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->categoryId ? 'Categoría actualizada.' : 'Categoría creada.');
        $this->isOpen = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $category = CashMovementCategory::findOrFail($id);
        $category->delete();
        session()->flash('message', 'Categoría eliminada.');
    }
}
