<?php

namespace App\Livewire\CashRegisters;

use App\Models\CashRegister;
use App\Livewire\BaseCrudComponent;
use Livewire\Attributes\Rule;

class Index extends BaseCrudComponent
{
    public $registerId;

    #[Rule('required|min:3')]
    public $name;

    public $description;
    public $active = true;

    public function render()
    {
        $registers = CashRegister::search($this->search, ['name'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('livewire.cash-registers.index', [
            'registers' => $registers,
        ])->layout('layouts.app');
    }

    protected function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->active = true;
        $this->registerId = null;
        $this->resetValidation();
    }

    public function store()
    {
        if (!$this->registerId && !\App\Services\LicenseService::canAddCashRegister()) {
            session()->flash('error', 'Límite de cajas registradoras alcanzado para su plan (' . \App\Services\LicenseService::getMaxCashRegisters() . ').');
            $this->closeModal();
            return;
        }

        $this->validate();

        CashRegister::updateOrCreate(['id' => $this->registerId], [
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
        ]);

        session()->flash('message', $this->registerId ? 'Caja actualizada correctamente.' : 'Caja creada correctamente.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $register = CashRegister::findOrFail($id);
        $this->registerId = $id;
        $this->name = $register->name;
        $this->description = $register->description;
        $this->active = $register->active;

        $this->openModal();
    }

    public function delete($id)
    {
        // Prevent deleting if it has sessions history? 
        // For now, let's just create a soft delete logically or check if it has open sessions.
        
        $register = CashRegister::find($id);
        
        if ($register->sessions()->exists()) {
            // Option: Soft delete logic or simple error.
            // Since we don't have SoftDeletes trait on model (assumed), we'll block.
            // Actually checking if it has *any* session might block too much.
            // Let's block only if it has an OPEN session.
            if ($register->currentSession()->exists()) {
                session()->flash('error', 'No puedes eliminar una caja que tiene una sesión abierta.');
                return;
            }
            
            // If historical sessions exist, maybe we should just allow delete (and lose history linkage in naive implementation) 
            // OR ideally soft delete. Given user request "manage", let's assume we can delete inactive ones.
            // BUT deleting a parent row violates FK if database strict.
            // Safe bet: deactivate instead?
            // Let's try delete, if key constraint fails, we catch it.
        }

        try {
            $register->delete();
            session()->flash('message', 'Caja eliminada correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se puede eliminar porque tiene historial de sesiones. Intenta desactivarla.');
        }
    }
}
