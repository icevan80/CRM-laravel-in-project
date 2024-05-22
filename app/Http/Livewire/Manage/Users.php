<?php

namespace App\Http\Livewire\Manage;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search;
//    public $showType = '';

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
        $users = User::when($this->showType, function ($query) {
            if ($this->showType == 'clients') {
                $query->where('role_id', '=', Role::getRole('Customer')->id)
                    ->orWhere('role_id', '=', Role::getRole('Admin')->id);
            } else if ($this->showType == 'staff') {
                $query->where('role_id', '!=', Role::getRole('Customer')->id);
            }
        })->where(function ($subQuery) {
            $subQuery->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone_number', 'like', '%' . $this->search . '%');
        })->paginate(20);

        return view('livewire.manage.users', ['users' => $users]);
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
