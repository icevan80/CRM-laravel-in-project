<?php

namespace App\Http\Livewire\Settings;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Roles extends Component
{
    public $roles;
    public $permissions;

    public function mount($roles)
    {
        $permissions = Permission::all();
        $this->fill(['permissions' => $permissions]);
        $this->fill(['roles' => $roles]);
    }

    public function render()
    {
        return view('livewire.settings.roles');
    }

    public function openRolePermissions(Role $role)
    {
//        if (!array_key_exists($role->id, $this->rolePermissionsMap)) {
//            $rolePermissions = $role->permissions();
//            foreach ($this->permissions as $permission) {
//                $this->rolePermissionsMap[$role->id][$permission->id] = array(
//                    'name' => $permission->name,
//                    'code_name' => $permission->code_name,
//                    'contain' => array_key_exists($permission->id, $rolePermissions,
//                    ));
//            }
//        }
    }

    public function saveNewPermissions(Role $role) {
        $arrayNewPermission = array();
        foreach ($this->rolePermissionsMap[$role->id] as $key => $value) {
            if ($value['contain']) {
                $arrayNewPermission[$key] = $value['code_name'];
            }
        }
        $this->oldPermissions = $role->permissions();
        $role->default_permissions = json_encode($arrayNewPermission);
        if ($role->save()) {
            $this->notificationPermissionChanged = true;
            $this->lastRole = $role;
        } else {
            $this->errorPermissionChanged   = true;
        }
    }

}
