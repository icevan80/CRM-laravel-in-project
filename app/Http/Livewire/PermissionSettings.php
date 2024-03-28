<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use Livewire\Component;

class PermissionSettings extends Component
{
    public $permissions;

    public function mount() {
        $this->permissons = Permission::all();
    }

    public function render()
    {
        return view('livewire.permission-settings');
    }
}
