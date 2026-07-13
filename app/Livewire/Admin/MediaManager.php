<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MediaManager extends Component
{
    use WithFileUploads;

    public $currentDirectory = '';
    public $uploads = [];
    public $selectedFile = null;
    public $newFolderName = '';
    public $showNewFolderModal = false;

    public function mount()
    {
        abort_unless(auth()->user()->can('admin'), 403);
    }

    public function getDirectoriesProperty()
    {
        return collect(Storage::disk('public')->directories($this->currentDirectory))
            ->map(function ($dir) {
                return [
                    'path' => $dir,
                    'name' => basename($dir),
                ];
            })->sortBy('name')->values();
    }

    public function getFilesProperty()
    {
        $files = Storage::disk('public')->files($this->currentDirectory);
        
        return collect($files)->map(function ($file) {
            $url = Storage::disk('public')->url($file);
            $isImage = Str::endsWith(strtolower($file), ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg']);
            $size = Storage::disk('public')->size($file);
            
            return [
                'path' => $file,
                'name' => basename($file),
                'url' => $url,
                'is_image' => $isImage,
                'size' => $this->formatSize($size),
                'last_modified' => Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file))->format('d/m/Y H:i'),
                'raw_size' => $size
            ];
        })->sortByDesc('last_modified')->values();
    }

    public function getBreadcrumbsProperty()
    {
        if (empty($this->currentDirectory)) {
            return [];
        }

        $parts = explode('/', $this->currentDirectory);
        $breadcrumbs = [];
        $currentPath = '';

        foreach ($parts as $part) {
            if (empty($part)) continue;
            
            $currentPath .= ($currentPath === '' ? '' : '/') . $part;
            $breadcrumbs[] = [
                'name' => $part,
                'path' => $currentPath
            ];
        }

        return $breadcrumbs;
    }

    public function openDirectory($path)
    {
        $this->currentDirectory = $path;
        $this->selectedFile = null;
    }

    public function goUp()
    {
        if (empty($this->currentDirectory)) return;

        $parts = explode('/', $this->currentDirectory);
        array_pop($parts);
        $this->currentDirectory = implode('/', $parts);
        $this->selectedFile = null;
    }

    public function goToRoot()
    {
        $this->currentDirectory = '';
        $this->selectedFile = null;
    }

    public function selectFile($path)
    {
        $this->selectedFile = $this->files->firstWhere('path', $path);
    }

    public function updatedUploads()
    {
        $this->validate([
            'uploads.*' => 'file|max:5120', // 5MB max
        ]);

        foreach ($this->uploads as $upload) {
            $filename = $upload->getClientOriginalName();
            // Evitar sobrescribir si ya existe
            if (Storage::disk('public')->exists($this->currentDirectory . '/' . $filename)) {
                $filename = uniqid() . '_' . $filename;
            }
            $upload->storeAs($this->currentDirectory, $filename, 'public');
        }

        $this->reset('uploads');
        session()->flash('message', 'Archivos subidos correctamente.');
    }

    public function deleteSelected()
    {
        if (!$this->selectedFile) return;

        Storage::disk('public')->delete($this->selectedFile['path']);
        $this->selectedFile = null;
        session()->flash('message', 'Archivo eliminado.');
    }

    public function createFolder()
    {
        $this->validate([
            'newFolderName' => 'required|string|alpha_dash|max:50'
        ], [
            'newFolderName.alpha_dash' => 'El nombre solo puede contener letras, números, guiones y guiones bajos.'
        ]);

        $path = $this->currentDirectory ? $this->currentDirectory . '/' . $this->newFolderName : $this->newFolderName;
        
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
            session()->flash('message', 'Carpeta creada.');
        } else {
            $this->addError('newFolderName', 'La carpeta ya existe.');
            return;
        }

        $this->showNewFolderModal = false;
        $this->newFolderName = '';
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function render()
    {
        return view('livewire.admin.media-manager')
            ->layout('layouts.app');
    }
}
