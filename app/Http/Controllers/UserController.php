<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
    public function index()
    {


        return view('dashboard.manage.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        if (auth()->user()->role->name != 'Admin') {
            $roles->where('name', '!=', 'Admin');
        }
        return view('dashboard.manage.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|min:1|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:255',
            'password_confirmation' => 'required|string|min:8|max:255|same:password',
            'phone_number' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users'],
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('manage.users.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            User::create([
                'name' => $request['user_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone_number' => $request['phone_number'],
                'role_id' => $request['role_id'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.users.create')->with('errormsg', 'User creation failed.');
        }

        return redirect()->route('manage.users')->with('success', 'User created successfully.');
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
        return view('dashboard.manage.users.show', compact('user', 'appointments'));
        // find the appointments of the user

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
/* USERS PHP
 <?php

namespace App\Http\Livewire\Manage;

use App\Models\User;
use Illuminate\View\Component;

class Users extends Component
{
    public $search;
//    public $showType = '';

    public $confirmingUserDeletion = false;
    public $confirmingUserRestore = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
//        if (request()->routeIs('manage.users.clients')) {
//            $this->showType = 'clients';
//        } else if (request()->routeIs('manage.users.staff')) {
//            $this->showType = 'staff';
//        } else {
//            $this->showType = 'all';
//        }
//        dd($this->showType);
    }

    public function render()
    {
//        $users = User::all();
//        if ($this->search) {
//            $users->where(function ($subQuery) {
//                $subQuery
//                    ->where('name', 'like', '%' . $this->search . '%')
//                    ->orWhere('email', 'like', '%' . $this->search . '%')
//                    ->orWhere('phone_number', 'like', '%' . $this->search . '%');
//            });
//        }
        $users = User::all()->where('id', 1);
//        $users = User::when($this->search, function ($query) {
//            $query->where('name', 'like', '%' . $this->search . '%')
//                ->orWhere('email', 'like', '%' . $this->search . '%')
//                ->orWhere('phone_number', 'like', '%' . $this->search . '%');
//        })->paginate(20);

//        $users->paginate(20);

dd('ABOBA');

//        return view('livewire.manage.users', ['users' => $users]);
        return view('livewire.manage.users', compact('users'));
//        return view('livewire.manage.users');
    }

    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion = $id;
    }

    public function confirmUserRestoration($id)
    {
        $this->confirmingUserRestore = $id;
    }
}


*/

