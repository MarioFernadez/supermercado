<?php

namespace App\Livewire\Sellers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Seller;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $name = '';
    public $code = '';
    public $phone = '';
    public $shift = '';
    public $isActive = true;

    public $editingId = null;
    public $showModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'name'     => 'required|string|max:100',
            'code'     => 'nullable|string|max:20',
            'phone'    => 'nullable|string|max:30',
            'shift'    => 'nullable|in:mañana,tarde,noche',
            'isActive' => 'boolean',
        ];
    }

    public function openCreate()
    {
        $this->reset(['name', 'code', 'phone', 'shift', 'editingId']);
        $this->isActive = true;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        $this->editingId = $seller->id;
        $this->name      = $seller->name;
        $this->code      = $seller->code ?? '';
        $this->phone     = $seller->phone ?? '';
        $this->shift     = $seller->shift ?? '';
        $this->isActive  = $seller->is_active;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name'      => $this->name,
            'code'      => $this->code ?: null,
            'phone'     => $this->phone ?: null,
            'shift'     => $this->shift ?: null,
            'is_active' => $this->isActive,
        ];

        if ($this->editingId) {
            Seller::findOrFail($this->editingId)->update($data);
        } else {
            Seller::create($data);
        }

        $this->showModal = false;
        $this->reset(['name', 'code', 'phone', 'shift', 'editingId']);
        $this->isActive = true;
    }

    public function toggleActive($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['is_active' => !$seller->is_active]);
    }

    public function delete($id)
    {
        Seller::findOrFail($id)->delete();
    }

    public function render()
    {
        $sellers = Seller::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.sellers.index', compact('sellers'))
            ->layout('layouts.app');
    }
}
