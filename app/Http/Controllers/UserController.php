<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.users.index');
        }

        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = $request['search'];

        $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone_number', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('dashboard.manage-users.index', compact('users'), ['search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.users.create');
        }
        return view('dashboard.manage-users.create-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Redirect if not admin
        if (auth()->user()->role->name != 'Admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to perform this action.');
        }



        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:255',
            'password_confirmation' => 'required|string|min:8|max:255|same:password',
            'phone_number' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users'],
            'role' => 'required|string|in:employee,customer',
        ]);

        if ($validator->fails()) {
            return redirect()->route('manageusers.create')
                ->withErrors($validator)
                ->withInput();
        }

        $role = $request['role'];

        if ($role == 'employee') {
            $role_id = Role::getRole('Employee')->id;
        } else {
            $role_id = Role::getRole('Customer')->id;
        }

        try {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone_number' => $request['phone_number'],
                'role_id' => $role_id,
            ]);
        } catch (Exception $e) {
            return redirect()->route('manageusers')->with('errormsg', 'User creation failed.');
        }

        return redirect()->route('manageusers')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $appointments = Appointment::where('implementer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.users.show', compact('user', 'appointments'));
        }
        // find the appointments of the user

        $permissions = Permission::all();

//        return view('dashboard.manage-users.show-user', compact('user', 'appointments'));
        return view('dashboard.manage-users.show-user', ['user' => $user, 'appointments' => $appointments, 'permissions' => $permissions]);
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
        try {
            if ($id == 1) {
                return redirect()->route('manage.users')->with('errormsg', 'You cannot suspend admin.');
            }
            $user = User::findOrFail($id);
            // throw new Exception('test');

            $user->status = 0;
            $user->save();
            return redirect()->route('manage.users')->with('success', 'User suspended successfully.');

        } catch (Exception $e) {
            return redirect()->route('manage.users')->with('errormsg', 'User suspension failed.');
        }
    }

    public function restore(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 1;
            $user->save();
            return redirect()->route('manage.users')->with('success', 'User activated successfully.');

        } catch (Exception $e) {
            return redirect()->route('manage.users')->with('errormsg', 'User activation failed.');
        }
    }

    public function updateRole(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $role = Role::findOrFail($request['roleId']);
            $user->updateRole($role);
            return redirect()->route('manage.users.show', $user->id)->with('success', 'User role change successfully.');

        } catch (Exception $e) {
            return redirect()->route('manage.users.show', $user->id)->with('errormsg', 'User role change failed.');
        }
    }
}
