<?php

namespace App\Http\Livewire\Settings;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $roles;
    public $permissions;

    public bool $createNewRole = false;


    public function mount($roles)
    {
        $permissions = Permission::all();
        $this->fill(['permissions' => $permissions]);
        $this->fill(['roles' => $roles]);
    }

    public function render()
    {
        return view('livewire.settings.roles', [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ]);
    }

    public function buttonHidePermissions(Role $role) {}

}
