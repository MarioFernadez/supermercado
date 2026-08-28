<?php

namespace App\Livewire\Settings;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;

class Units extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    public $showModal = false;
    public $unitId;
    public $name = '';
    public $abbreviation = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2|unique:units,name',
        'abbreviation' => 'nullable|max:5',
    ];

    public function render()
    {
        $units = Unit::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.settings.units', [
            'units' => $units
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->unitId = $id;
        $this->name = $unit->name;
        $this->abbreviation = $unit->abbreviation;
        $this->is_active = $unit->is_active;
        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->unitId = null;
        $this->name = '';
        $this->abbreviation = '';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->unitId) {
            $rules['name'] = 'required|min:2|unique:units,name,' . $this->unitId;
        }

        $this->validate($rules);

        Unit::updateOrCreate(['id' => $this->unitId], [
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->unitId ? 'Unidad actualizada.' : 'Unidad creada.');
        $this->isOpen = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $unit = Unit::findOrFail($id);
        // We could check if it's used in products here
        $unit->delete();
        session()->flash('message', 'Unidad eliminada.');
    }
}
