<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Permissions extends Component
{
    public $permissions;
    public $permissionsMap = array();
    public $roleId = null;
    public $userId = null;

    public bool $createNewPermission = false;

    public function mount($permissions, $roleId = null, $userId = null) {
        $this->fill(['permissions' => $permissions]);
        if ($roleId == null && $userId == null) {
            $this->fillMainPage($permissions);
        }
    }

    public function fillMainPage($permissions) {
        $permissionsMap = array();
        foreach ($permissions as $permission) {
            $permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'status' => $permission->status,
                'permission' => $permission,
            );
        }
        $this->fill(['permissionsMap' => $permissionsMap]);

    }

    public function render()
    {
        return view('livewire.settings.permissions');
    }
}
