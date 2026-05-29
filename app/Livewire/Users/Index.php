<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Livewire\BaseCrudComponent;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class Index extends BaseCrudComponent
{
    public $userId;

    #[Rule('required|min:3')]
    public $name;

    #[Rule('required|email|unique:users,email')]
    public $email;

    public $password;

    #[Rule('required')]
    public $role = 'cajero';

    public $branch_id = null;


    public function render()
    {
        $users = User::search($this->search, ['name', 'email'])
            ->where('email', '!=', config('services.developer.email'))
            ->where('role', '!=', 'developer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $branches = \App\Models\Branch::where('is_active', true)->orderBy('name')->get();

        return view('livewire.users.index', [
            'users' => $users,
            'branches' => $branches
        ])->layout('layouts.app');
    }

    protected function resetInputFields()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'cajero';
        $this->branch_id = null;
        $this->resetValidation();
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email' . ($this->userId ? ',' . $this->userId : ''),
            'role' => 'required|in:admin,gerente,cajero,developer',
        ];

        // Password is required only for creation, optional for update
        if (!$this->userId) {
            $rules['password'] = 'required|min:6';
        }

        if (!$this->userId && !\App\Services\LicenseService::canAddUser()) {
            session()->flash('error', 'Límite de usuarios alcanzado para su plan (' . \App\Services\LicenseService::getMaxUsers() . ').');
            $this->closeModal();
            return;
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'branch_id' => $this->branch_id ?: null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->userId ?: null], $data);

        session()->flash('message', $this->userId ? 'Usuario actualizado correctamente.' : 'Usuario creado correctamente.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->branch_id = $user->branch_id;
        $this->password = ''; // Don't send back password hash

        $this->openModal();
    }

    public function delete($id)
    {
        // Prevent deleting self or the only admin (basic protection)
        if ($id == auth()->id()) {
             session()->flash('error', 'No puedes eliminar tu propio usuario.');
             return;
        }

        User::find($id)->delete();
        session()->flash('message', 'Usuario eliminado correctamente.');
    }
}
