<?php

namespace App\Http\Livewire\Components;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class UserSettings extends Component
{
    public User $user;
    public $roles;
    public $roleId;

    public function mount($userId)
    {
        $this->user = User::all()->where('id', $userId)->first();
        $this->roleId = $this->user->role_id;
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.components.user-settings');
    }
}
