<?php

namespace App\Http\Livewire\Manage;

use App\Models\User;
use Illuminate\View\Component;

class Users extends Component
{
    public $search;
    public $showType = '';

    public $confirmingUserDeletion = false;
    public $confirmingUserRestore = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        if (request()->routeIs('manage.users.clients')) {
            $this->showType = 'clients';
        } else if (request()->routeIs('manage.users.staff')) {
            $this->showType = 'staff';
        } else {
            $this->showType = 'all';
        }
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
        $users = User::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone_number', 'like', '%' . $this->search . '%');
        })->paginate(20);

//        $users->paginate(20);

//        return view('livewire.manage.users', ['users' => $users]);
        return view('livewire.manage.users', compact('users'));
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
