<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use Livewire\Component;

class PermissionSettings extends Component
{
    public $permissions;
    public $permissionsMap = array();
    public $newPermissionName = '';

    public bool $createNewPermission = false;
    public bool $notificationCreateStatus = false;
    public bool $notificationSaveStatus = false;
    public bool $errorSaveStatus = false;

    protected $rules = [

        'newPermissionName' => 'required|string|min:6|max:64',

    ];

    public function mount()
    {
        $this->permissions = Permission::all();
        foreach ($this->permissions as $permission) {
            $this->permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'status' => $permission->status,
                'permission' => $permission,
            );
        }
    }

    public function render()
    {
        return view('livewire.permission-settings', [
            'permissions' => $this->permissions,
            ]);
    }

    public function createNewPermission()
    {
        $this->createNewPermission = false;
        $this->validate();
        Permission::create([
            'name' => $this->newPermissionName,
        ]);
        $this->newPermissionName = '';
        $this->notificationSaveStatus = true;

        $this->permissions = Permission::all();
        foreach ($this->permissions as $permission) {
            $this->permissionsMap[$permission->id] = array(
                'name' => $permission->name,
                'status' => $permission->status,
                'permission' => $permission,
            );
        }
    }

    public function changePermissionsStatus()
    {
        $result = true;
        foreach ($this->permissionsMap as $permission) {
            if ($permission['status'] != $permission['permission']['status']) {
                $newPermission =Permission::getPermission($permission['permission']['id']);
                $newPermission->status = $permission['status'];
                $result = $result && $newPermission->save();
            }
        }
        if ($result) {
            $this->notificationSaveStatus = true;
        } else {
            $this->errorSaveStatus = true;
        }
    }
}
