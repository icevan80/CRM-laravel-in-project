<?php

namespace App\Http\Livewire\Manage;

use App\Models\Deal;
use Livewire\Component;
use Livewire\WithPagination;

class Deals extends Component
{
    use withPagination;


    public $confirmingDeleteDeal = false;
    public $confirmingDealEdit = false;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $deals = Deal::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
            ->orderBy('start_date', 'desc')
            ->where('status', true)
            ->paginate(10);

        return view('livewire.manage.deals', [
            'deals' => $deals,
        ]);
    }

    public function confirmDealEdit(Deal $newDeal)
    {
        $this->newDeal = $newDeal;

        // using the same form for adding and editing
        $this->confirmingDealAdd = true;
    }

    public function confirmDeleteDeal($id)
    {
        $this->confirmingDeleteDeal = $id;
    }
}
