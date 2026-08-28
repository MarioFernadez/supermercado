<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Livewire\BaseCrudComponent;
use Livewire\Attributes\Rule;

class Index extends BaseCrudComponent
{
    public $supplierId;

    #[Rule('required|min:3')]
    public $name;

    public $contact_name;
    public $email;
    public $phone;
    public $address;
    public $notes;
    
    public $active = true;

    public function render()
    {
        $suppliers = Supplier::search($this->search, ['name', 'contact_name', 'email'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.suppliers.index', [
            'suppliers' => $suppliers
        ])->layout('layouts.app');
    }

    protected function resetInputFields()
    {
        $this->supplierId = null;
        $this->name = '';
        $this->contact_name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->notes = '';
        $this->active = true;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'nullable|email',
        ]);

        Supplier::updateOrCreate(['id' => $this->supplierId], [
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'notes' => $this->notes,
            'active' => $this->active
        ]);

        session()->flash('message', $this->supplierId ? 'Proveedor actualizado correctamente.' : 'Proveedor creado correctamente.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplierId = $id;
        $this->name = $supplier->name;
        $this->contact_name = $supplier->contact_name;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->address = $supplier->address;
        $this->notes = $supplier->notes;
        $this->active = $supplier->active;

        $this->openModal();
    }

    public function delete($id)
    {
        Supplier::find($id)->delete();
        session()->flash('message', 'Proveedor eliminado correctamente.');
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;
        
        Supplier::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', 'Proveedores seleccionados eliminados correctamente.');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Supplier::search($this->search, ['name', 'contact_name', 'email'])
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selected = [];
        }
    }
}
