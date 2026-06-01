<?php

namespace App\Livewire\Branches;

use App\Models\Branch;
use App\Livewire\BaseCrudComponent;
use Livewire\Attributes\Rule;

class Index extends BaseCrudComponent
{
    public $branchId;

    #[Rule('required|min:3')]
    public $name;

    public $address;
    public $phone;
    public $is_active = true;

    public function render()
    {
        $branches = Branch::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('livewire.branches.index', [
            'branches' => $branches,
        ])->layout('layouts.app');
    }

    protected function resetInputFields()
    {
        $this->name = '';
        $this->address = '';
        $this->phone = '';
        $this->is_active = true;
        $this->branchId = null;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        if (!$this->branchId && !\App\Services\LicenseService::canAddBranch()) {
            session()->flash('error', 'Límite de sucursales alcanzado para tu plan (' . \App\Services\LicenseService::getMaxBranches() . ').');
            $this->closeModal();
            return;
        }

        Branch::updateOrCreate(['id' => $this->branchId], [
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->branchId ? 'Sucursal actualizada correctamente.' : 'Sucursal creada correctamente.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $this->branchId = $id;
        $this->name = $branch->name;
        $this->address = $branch->address;
        $this->phone = $branch->phone;
        $this->is_active = $branch->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        $branch = Branch::find($id);
        
        try {
            $branch->delete();
            session()->flash('message', 'Sucursal eliminada correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se puede eliminar porque tiene historial. Intenta desactivarla.');
        }
    }
}
