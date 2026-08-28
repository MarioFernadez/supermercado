<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\RestaurantTable;
use App\Models\Waiter;

class Restaurant extends Component
{
    public $newTableName = '';
    public $newWaiterName = '';

    public function render()
    {
        return view('livewire.settings.restaurant', [
            'tables' => RestaurantTable::all(),
            'waiters' => Waiter::all(),
        ])->layout('layouts.app');
    }

    public function addTable()
    {
        $this->validate(['newTableName' => 'required|min:2']);
        RestaurantTable::create(['name' => $this->newTableName]);
        $this->newTableName = '';
        session()->flash('table_message', 'Mesa agregada.');
    }

    public function deleteTable($id)
    {
        RestaurantTable::findOrFail($id)->delete();
        session()->flash('table_message', 'Mesa eliminada.');
    }

    public function addWaiter()
    {
        $this->validate(['newWaiterName' => 'required|min:2']);
        Waiter::create(['name' => $this->newWaiterName]);
        $this->newWaiterName = '';
        session()->flash('waiter_message', 'Mozo agregado.');
    }

    public function toggleWaiter($id)
    {
        $waiter = Waiter::findOrFail($id);
        $waiter->active = !$waiter->active;
        $waiter->save();
    }

    public function deleteWaiter($id)
    {
        Waiter::findOrFail($id)->delete();
        session()->flash('waiter_message', 'Mozo eliminado.');
    }
}
