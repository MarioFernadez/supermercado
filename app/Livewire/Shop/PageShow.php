<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Page;
use App\Models\StoreSetting;

class PageShow extends Component
{
    public $page;

    public function mount($slug)
    {
        $this->page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        return view('livewire.shop.page-show', [
            'settings' => $settings
        ])->layout('layouts.shop', ['settings' => $settings]);
    }
}
