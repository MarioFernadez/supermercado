<?php

namespace App\Livewire\Admin\Deboning;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeboningSession;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedSession = null;
    public bool $showDetailsModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function viewDetails(string $sessionId): void
    {
        $this->selectedSession = DeboningSession::with(['rawMaterial', 'user', 'items.product'])->find($sessionId);
        $this->showDetailsModal = true;
    }

    public function closeDetails(): void
    {
        $this->showDetailsModal = false;
        $this->selectedSession = null;
    }

    public function render()
    {
        abort_unless(auth()->user()->can('admin') || auth()->user()->can('manager'), 403);
        abort_unless(hasModule('meat_deboning'), 404);

        $sessions = DeboningSession::with(['rawMaterial', 'user', 'items.product'])
            ->whereHas('rawMaterial', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.deboning.index', [
            'sessions' => $sessions
        ])->layout('layouts.app');
    }
}
