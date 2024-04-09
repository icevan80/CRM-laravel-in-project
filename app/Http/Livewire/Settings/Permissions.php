<?php

namespace App\Http\Livewire\Settings;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Permissions extends Component
{
    public $permissions;
    public $permissionsMap = array();
    public $roleId = null;
    public $userId = null;

    public bool $createNewPermission = false;

    public function mount($permissions, $roleId = null, $userId = null)
    {

        $this->fill(['permissions' => $permissions]);
        if ($roleId == null && $userId == null) {
            $this->fillMainPage($permissions);
        } else if ($roleId != null && $userId == null) {
            $this->roleId = $roleId;
            $this->fillRolePage($permissions, $roleId);
        }
    }

    public function fillMainPage($permissions)
    {
        $permissionsMap = array();
        foreach ($permissions as $permission) {
            $permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'code_name' => $permission->code_name,
                'status' => $permission->status,
                'permission' => $permission,
            );
        }
        $this->fill(['permissionsMap' => $permissionsMap]);

    }

    public function fillRolePage($permissions, $roleId)
    {
        $role = Role::getRole($roleId);

        $permissionsMap = $role->permissions();
        foreach ($permissions as $permission) {
            $permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'code_name' => $permission->code_name,
                'status' => array_key_exists($permission->id, $permissionsMap),
                'permission' => $permission,
            );

        }
        $this->fill(['permissionsMap' => $permissionsMap]);

    }

    public function updateStatus(int $id)
    {
        $permission = Permission::getPermission($id);
        $permission->status = $this->permissionsMap[$id]['status'];
        $permission->save();
    }

    public function render()
    {
        return view('livewire.settings.permissions', [
            'permissionMap' => $this->permissionsMap,
        ]);
    }
}
