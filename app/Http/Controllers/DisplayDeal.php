<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Permission;
use App\Models\Role;

class DisplayDeal extends Controller
{
    function index()
    {

//        dd(auth()->user()->permissions());
//        $permission =Permission::getPermission(11);
//        dd($permission);
//        auth()->user()->addPermissionRule($permission, false);
//        $role = Role::getRole(3);
//        dd(auth()->user()->updateRole($role));
        $permissions = Permission::all();
        $array = array();
        foreach ($permissions as $permission) {
            $array[$permission->id] = $permission->code_name;
        }

//        auth()->user()->updateRole(Role::getRole(1));

        /*Permission::create([
            'name' => 'Manage Appointment'
        ]);
        Permission::create([
            'name' => 'Create Appointment'
        ]);
        Permission::create([
            'name' => 'Edit Appointment'
        ]);
        Permission::create([
            'name' => 'Edit date Appointment'
        ]);
        Permission::create([
            'name' => 'Edit other Appointment'
        ]);
        Permission::create([
            'name' => 'Delete Appointment'
        ]);
        Permission::create([
            'name' => 'Edit Translations'
        ]);
        Permission::create([
            'name' => 'Edit Roles'
        ]);
        Permission::create([
            'name' => 'Edit Permissions'
        ]);
        Permission::create([
            'name' => 'Manage Users'
        ]);
        Permission::create([
            'name' => 'Manage Locations'
        ]);
        Permission::create([
            'name' => 'Manage Services'
        ]);
        Permission::create([
            'name' => 'Manage Categories'
        ]);
        Permission::create([
            'name' => 'Manage Deals'
        ]);
        Permission::create([
            'name' => 'Edit Users'
        ]);
        Permission::create([
            'name' => 'Edit Locations'
        ]);
        Permission::create([
            'name' => 'Edit Services'
        ]);
        Permission::create([
            'name' => 'Edit categories'
        ]);
        Permission::create([
            'name' => 'Edit deals'
        ]);*/


        Role::create([
            'name' => 'Admin',
            'default_permissions' => json_encode($array),
        ]);
        Role::create([
            'name' => 'Employee',
            'default_permissions' => json_encode(array()),
        ]);
        Role::create([
            'name' => 'Customer',
            'default_permissions' => json_encode(array()),
        ]);
        Role::create([
            'name' => 'Partner',
            'default_permissions' => json_encode(array()),
        ]);
        Role::create([
            'name' => 'Master',
            'default_permissions' => json_encode(array()),
        ]);


        $deals = Deal::all();
        return view('web.deals', compact('deals'));
    }
}
