<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Salon extends Component
{
    public array $scheme = array();
    public array $fonts = array();


    public function mount() {
        $this->fonts = getFonts();
        $this->scheme = getTheme();
        foreach ($this->scheme as $key => $hsl) {
            $this->scheme[$key] = hslToRgbStr($hsl);
        }
    }

    public function render()
    {
        return view('livewire.settings.salon');
    }


}
