<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class RoleSettings extends Component
{
    public $roles;
    public $permissions;
    public $rolePermissionsMap = array();
    public int $rowspan;
    public $lastRole;
    public $oldPermissions;

    public bool $notificationPermissionChanged = false;
    public bool $errorPermissionChanged = false;

    public function mount()
    {

        $this->roles = Role::all();
        $this->permissions = Permission::all();

        $this->rowspan = round(count($this->permissions) / 4);
    }

    public function render()
    {
        return view('livewire.role-settings', [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'rolePermissionsMap' => $this->rolePermissionsMap,
        ]);
    }

    public function openRolePermissions(Role $role)
    {
        if (!array_key_exists($role->id, $this->rolePermissionsMap)) {
            $rolePermissions = $role->permissions();
            foreach ($this->permissions as $permission) {
                $this->rolePermissionsMap[$role->id][$permission->id] = array(
                    'name' => $permission->name,
                    'code_name' => $permission->code_name,
                    'contain' => array_key_exists($permission->id, $rolePermissions,
                    ));
            }
        }
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

    public function changePermissionsForAllUsersWithRole() {
        $users = User::all()->where('role_id', $this->lastRole->id);
        $rolePermissions = $this->lastRole->permissions();
        $oldPermissions = $this->oldPermissions;
        $changePermissions = array();
        if ($users->count() > 0) {
            foreach ($rolePermissions as $key => $value) {
                if (!array_key_exists($key, $oldPermissions)) {
                    $changePermissions[$key] = array('code_name' => $value, 'needRemove' => false);
                }
            }
            foreach ($oldPermissions as $key => $value) {
                if (!array_key_exists($key, $rolePermissions)) {
                    $changePermissions[] = array('key' => $key, 'code_name' => $value, 'needRemove' => true);
                }
            }
            foreach ($users as $user) {
                $user->permissions = $this->lastRole->default-
                $userPermissions = $user->permissions();
                foreach ($changePermissions as $permission) {
                    if ($permission['needRemove']) {
                        unset($userPermissions[$permission['key']]);
                    } else {
                        $userPermissions[$permission['key']] = $permission['code_name'];
                    }
                }
                dd($userPermissions);

            }
        } else {
            $this->notificationPermissionChanged = false;
        }
    }
}
