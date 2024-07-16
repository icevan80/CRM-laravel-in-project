<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Salon extends Component
{
    public array $scheme = array();
    public array $fonts = array();
    public array $storeInformation = array();
    public String $logoUrl = '';
    public $salon;

//    public $storeInformation = array();


    public function mount()
    {
        $this->salon = getStore();
        $this->storeInformation = json_decode($this->salon->information, true);
        $this->logoUrl = $this->salon->logo_url;
        $this->fonts = getFonts();
        $this->scheme = getTheme();
        foreach ($this->scheme as $key => $hsl) {
            $this->scheme[$key] = hslToRgbStr($hsl);
        }
    }

    public function render()
    {
        return view('livewire.settings.salon', ['salon' => $this->salon]);
    }


}
