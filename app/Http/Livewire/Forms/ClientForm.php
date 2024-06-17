<?php

namespace App\Http\Livewire\Forms;

use App\Models\Client;
use Livewire\Component;

class ClientForm extends Component
{
    public $client = array(
        'name' => '',
        'phone' => '',
        'email' => '',
        'notes' => '',
    );

    public $searchPhone;
    public $searchProcess = false;


    public function mount() {
        $this->client = array(
            'name' => '',
            'phone' => '',
            'email' => '',
            'notes' => '',
        );
    }

    public function render()
    {
        $clients = array();
        if ($this->searchPhone) {
            $clients = Client::where('phone_number', 'like','%'.$this->searchPhone.'%')->get();
        }

        return view('livewire.forms.client-form', ['clients'=> $clients,]);
    }

    public function updatedClientPhone($value) {
        $this->searchPhone = $value;
    }

    public function startSearch() {
        $this->searchProcess = true;
    }

    public function endSearch() {
        $this->searchProcess = false;
    }

    public function selectClient($client) {
        $this->searchPhone = $client['phone_number'];
        $this->client['name'] = $client['name'];
        $this->client['phone'] = $client['phone_number'];
        $this->client['email'] = $client['email'];
        $this->client['notes'] = $client['notes'];

    }
}
