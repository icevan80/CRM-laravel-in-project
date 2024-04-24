<?php

namespace App\Http\Livewire\Manage;

use App\Models\Location;
use Livewire\Component;

class Locations extends Component
{
    private $locations;

    public int $locationId = 0;
    public $selectLocation;


    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public bool $confirmEditLocation = false;
    public bool $confirmDeleteLocation = false;

    public function render()
    {
        $query = Location::when($this->search, function ($subQuery) {
            $subQuery->where('name', 'like', '%' . $this->search . '%')->orWhere('address', 'like', '%' . $this->search . '%');
        });
        $this->locations = $query->where('status', true)->paginate(10);

        return view('livewire.manage.locations', [
            'locations' => $this->locations,
        ]);
    }

    public function confirmLocationEdit($locationId, Location $location)
    {
        $this->fill(['locationId' => $locationId]);
        $this->selectLocation = $location;
        $this->fill(['confirmEditLocation' => true]);
    }

    public function confirmLocationDeletion($locationId)
    {
        $this->fill(['locationId' => $locationId]);
        $this->fill(['confirmDeleteLocation' => true]);
    }
}
