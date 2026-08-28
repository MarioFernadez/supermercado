<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Str;

class Form extends Component
{
    public $pageId = null;
    public $title = '';
    public $slug = '';
    public $content = '';
    public $is_published = true;
    public $meta_title = '';
    public $meta_description = '';

    public function mount($page = null)
    {
        if ($page) {
            $pageModel = Page::findOrFail($page);
            $this->pageId = $pageModel->id;
            $this->title = $pageModel->title;
            $this->slug = $pageModel->slug;
            $this->content = $pageModel->content;
            $this->is_published = $pageModel->is_published;
            $this->meta_title = $pageModel->meta_title;
            $this->meta_description = $pageModel->meta_description;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:pages,slug,' . $this->pageId,
            'content' => 'nullable',
            'is_published' => 'boolean',
        ]);

        $page = $this->pageId ? Page::find($this->pageId) : new Page();
        $page->title = $this->title;
        
        if (!empty($this->slug)) {
            $page->slug = Str::slug($this->slug);
        } else {
            // Let the boot method handle it or do it here
            $page->slug = null;
        }

        $page->content = $this->content;
        $page->is_published = $this->is_published;
        $page->meta_title = $this->meta_title;
        $page->meta_description = $this->meta_description;
        $page->save();

        session()->flash('message', 'Página guardada correctamente.');
        return redirect()->route('pages.index');
    }

    public function render()
    {
        return view('livewire.admin.pages.form')->layout('layouts.app');
    }
}
