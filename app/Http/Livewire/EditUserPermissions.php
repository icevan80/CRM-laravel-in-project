<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class EditUserPermissions extends Component
{
    public User $user;
    public $permissions;
    public $userPermissionsMap = array();
    public $roles;
    public $roleId;

    public bool $notificationPermissionChanged = false;
    public bool $errorPermissionChanged = false;

    public function mount($userId)
    {
        $this->user = User::all()->where('id', $userId)->first();
        $this->roleId = $this->user->role_id;
        $this->roles = Role::all();
//        dd($this->user);
        $this->permissions = Permission::all();

        $userPermissions = $this->user->personalPermissions();
        $rolePermissions = $this->user->role->permissions();
        foreach ($this->permissions as $permission) {
            $status = 'default';
            $roleStatus = array_key_exists($permission->id, $rolePermissions) ? 'allow' : 'reject';
            if (array_key_exists($permission->id, $userPermissions)) {
                $status = $userPermissions[$permission->id]['approve'] ? 'allow' : 'reject';
            }

            $this->userPermissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'code_name' => $permission->code_name,
                'status' => $status,
                'roleStatus' => $roleStatus,
            );
        }
    }

    public function changeUserPermissions()
    {
//        $userPermissions = $this->user->personalPermissions();
        $newUserPermissions = array();
        foreach ($this->userPermissionsMap  as $key => $permission) {
            if ($permission['status'] != 'default') {
                $newUserPermissions[$key] = array('code_name' => $permission['code_name'], 'approve' => $permission['status'] == 'allow');
            }
        }

        $this->user->permissions = json_encode($newUserPermissions);
        if ($this->user->save()) {
            $this->notificationPermissionChanged = true;
        } else {
            $this->errorPermissionChanged   = true;
        }
    }

    public function render()
    {
        return view('livewire.edit-user-permissions', [
            'permissions' => $this->permissions,
//            'userPermissionsMap' => $this->userPermissionsMap,
        ]);
    }
}
