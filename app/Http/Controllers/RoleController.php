<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        if (auth()->user()->hasPermission('new_style_access')) {

            return view('dashboard.settings.roles.index', compact('roles'));
        }
        return view('dashboard.role-settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|min:1|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->route('settings.roles')->with('errormsg', 'Role not created.');
        }

        try {

            Role::create([
                'name' => $request['role_name'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('settings.roles')->with('errormsg', 'Role not created.');
        }

        return redirect()->route('settings.roles')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
