<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deletePage($id)
    {
        $page = Page::find($id);
        if ($page) {
            $page->delete();
            session()->flash('message', 'Página eliminada correctamente.');
        }
    }

    public function togglePublish($id)
    {
        $page = Page::find($id);
        if ($page) {
            $page->is_published = !$page->is_published;
            $page->save();
            session()->flash('message', 'Estado actualizado.');
        }
    }

    public function render()
    {
        $pages = Page::where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('livewire.admin.pages.index', [
            'pages' => $pages
        ])->layout('layouts.app');
    }
}
