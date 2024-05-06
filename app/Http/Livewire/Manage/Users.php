<?php

namespace App\Http\Livewire\Manage;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $search;

    public $confirmingUserDeletion = false;
    public $confirmingUserRestore = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $users = User::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone_number', 'like', '%' . $this->search . '%');
        })
            ->paginate(20);

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
