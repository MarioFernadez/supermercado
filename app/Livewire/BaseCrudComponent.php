<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseCrudComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    
    // Bulk actions
    public $selected = [];
    public $selectAll = false;

    /**
     * Reset input fields (Abstract: must be implemented by child)
     */
    abstract protected function resetInputFields();

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
