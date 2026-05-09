<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Banner;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class BannerManager extends Component
{
    use WithFileUploads;

    public $banners;
    public $title, $subtitle, $link, $order = 0, $image;
    public $bannerId;
    public $isOpen = false;

    public function render()
    {
        $this->banners = Banner::orderBy('order')->get();
        return view('livewire.settings.banner-manager')->layout('layouts.app');
    }

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
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->subtitle = '';
        $this->link = '';
        $this->order = 0;
        $this->image = null;
        $this->bannerId = null;
    }

    public function store()
    {
        $this->validate([
            'image' => $this->bannerId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'order' => 'required|integer',
        ]);

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'link' => $this->link,
            'order' => $this->order,
        ];

        if ($this->image) {
            $data['image_path'] = $this->image->store('banners', 'public');
        }

        Banner::updateOrCreate(['id' => $this->bannerId], $data);

        session()->flash('message', 
            $this->bannerId ? 'Banner actualizado correctamente.' : 'Banner creado correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $this->bannerId = $id;
        $this->title = $banner->title;
        $this->subtitle = $banner->subtitle;
        $this->link = $banner->link;
        $this->order = $banner->order;
        $this->openModal();
    }

    public function delete($id)
    {
        $banner = Banner::find($id);
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        session()->flash('message', 'Banner eliminado correctamente.');
    }

    public function toggleActive($id)
    {
        $banner = Banner::find($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();
    }
}
