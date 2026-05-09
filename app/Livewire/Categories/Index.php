<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Livewire\BaseCrudComponent;
use Livewire\Attributes\Rule;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends BaseCrudComponent
{
    use WithFileUploads;

    public $categoryId;
    
    #[Rule('required|min:3')]
    public $name;
    
    #[Rule('nullable|exists:categories,id')]
    public $parent_id;
    
    public $is_active = true;

    // Image upload
    public $category_image;
    public $category_image_path;

    public function render()
    {
        $categories = Category::search($this->search, ['name'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $parents = Category::where('is_active', true)
            ->where('id', '!=', $this->categoryId) // Prevent self-parenting
            ->get();

        return view('livewire.categories.index', [
            'categories' => $categories,
            'parents' => $parents
        ])->layout('layouts.app');
    }

    protected function resetInputFields()
    {
        $this->name = '';
        $this->parent_id = null;
        $this->is_active = true;
        $this->categoryId = null;
        $this->category_image = null;
        $this->category_image_path = null;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'parent_id' => 'nullable|exists:categories,id',
            'category_image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        if ($this->category_image) {
            // Delete old image if updating
            if ($this->category_image_path) {
                Storage::disk('public')->delete($this->category_image_path);
            }
            $this->category_image_path = $this->category_image->store('categories', 'public');
        }

        Category::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
            'parent_id' => $this->parent_id ?: null,
            'is_active' => $this->is_active,
            'image_path' => $this->category_image_path
        ]);

        session()->flash('message', $this->categoryId ? 'Categoría actualizada correctamente.' : 'Categoría creada correctamente.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->parent_id = $category->parent_id;
        $this->is_active = $category->is_active;
        $this->category_image_path = $category->image_path;

        $this->openModal();
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Categoría eliminada correctamente.');
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;
        
        Category::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', 'Categorías seleccionadas eliminadas correctamente.');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Category::search($this->search, ['name'])
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
