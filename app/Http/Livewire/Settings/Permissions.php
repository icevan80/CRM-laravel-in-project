<?php

namespace App\Http\Livewire\Settings;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Permissions extends Component
{
    public $permissions;
    public $permissionsMap = array();
    public $roleId = null;
    public $userId = null;
    public $role = null;
    public $user = null;

    public int $elementsInRow = 4;

    public function mount($permissions = null, $roleId = null, $userId = null)
    {

        if ($permissions == null) {
            $permissions = Permission::all();
        }
        $this->fill(['permissions' => $permissions]);
        if ($roleId == null && $userId == null) {
            $this->fillMainPage($permissions);
        } else if ($roleId != null && $userId == null) {
            $this->roleId = $roleId;
            $this->role = Role::getRole($roleId);
            $this->fillRolePage($permissions, $this->role);
        } else if ($roleId == null && $userId != null) {
            $this->elementsInRow = 3;
            $this->userId = $userId;
            $this->user = User::all()->where('id', $userId)->first();
            $this->fillUserPage($permissions, $this->user);
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

    public function fillRolePage($permissions, $role)
    {
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

    public function fillUserPage($permissions, $user)
    {
        $permissionsMap = array();
        $userPermissions = $user->personalPermissions();
        $rolePermissions = $user->role->permissions();

        foreach ($permissions as $permission) {
            $status = 'default';
            $roleStatus = array_key_exists($permission->id, $rolePermissions) ? 'allow' : 'reject';
            if (array_key_exists($permission->id, $userPermissions)) {
                $status = $userPermissions[$permission->id]['approve'] ? 'allow' : 'reject';
            }

            $permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'code_name' => $permission->code_name,
                'status' => $status,
                'roleStatus' => $roleStatus,
                'permission' => $permission,
            );
        }

        /*foreach ($permissions as $permission) {
            $permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'code_name' => $permission->code_name,
                'status' => array_key_exists($permission->id, $permissionsMap),
                'permission' => $permission,
            );

        }*/
        $this->fill(['permissionsMap' => $permissionsMap]);

    }

    public function updateStatus(int $id)
    {
        if ($this->roleId == null && $this->userId == null) {
            $permission = Permission::getPermission($id);
            $permission->status = $this->permissionsMap[$id]['status'];
            $permission->save();
        } else if ($this->roleId != null && $this->userId == null) {
            $permission = Permission::getPermission($id);
            if ($this->permissionsMap[$id]['status']) {
                $this->role->addPermission($permission);
            } else {
                $this->role->removePermission($permission);
            }
        }
    }

    public function render()
    {
        return view('livewire.settings.permissions', [
            'permissionMap' => $this->permissionsMap,
        ]);
    }
}
