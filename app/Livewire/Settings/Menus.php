<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseCrudComponent;
use App\Models\MenuItem;

class Menus extends BaseCrudComponent
{
    public $name, $url, $type = 'custom', $reference_id, $order = 0, $is_active = true, $parent_id;
    public $menu_id;

    protected $rules = [
        'name' => 'required|string|max:255',
        'url' => 'nullable|string|max:255',
        'type' => 'required|in:custom,category,route',
        'reference_id' => 'nullable|integer',
        'order' => 'required|integer',
        'is_active' => 'boolean',
        'parent_id' => 'nullable|exists:menu_items,id',
    ];

    protected function resetInputFields()
    {
        $this->name = '';
        $this->url = '';
        $this->type = 'custom';
        $this->reference_id = null;
        $this->order = 0;
        $this->is_active = true;
        $this->parent_id = null;
        $this->menu_id = null;
    }

    public function edit($id)
    {
        $menu = MenuItem::findOrFail($id);
        $this->menu_id = $id;
        $this->name = $menu->name;
        $this->url = $menu->url;
        $this->type = $menu->type;
        $this->reference_id = $menu->reference_id;
        $this->order = $menu->order;
        $this->is_active = $menu->is_active;
        $this->parent_id = $menu->parent_id;
        
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        MenuItem::updateOrCreate(['id' => $this->menu_id], [
            'name' => $this->name,
            'url' => $this->url,
            'type' => $this->type,
            'reference_id' => $this->reference_id,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('message', $this->menu_id ? 'Menú actualizado correctamente.' : 'Menú creado correctamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        MenuItem::find($id)->delete();
        session()->flash('message', 'Menú eliminado correctamente.');
    }
    
    public function updateOrder($items)
    {
        foreach ($items as $item) {
            MenuItem::where('id', $item['value'])->update(['order' => $item['order']]);
        }
    }

    public function render()
    {
        $menus = MenuItem::with('parent')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('order')
            ->paginate(15);
            
        $parentMenus = MenuItem::whereNull('parent_id')->get();

        return view('livewire.settings.menus', compact('menus', 'parentMenus'))
            ->layout('layouts.app');
    }
}
