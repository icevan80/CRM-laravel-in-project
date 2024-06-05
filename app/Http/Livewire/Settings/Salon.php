<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Salon extends Component
{
    public array $scheme = array();

    public function mount() {
        $file = file_get_contents(resource_path('/settings/default.json'));
        $theme = json_decode($file, true);
        $this->scheme = $theme;
        foreach ($this->scheme as $key => $hsl) {
            $this->scheme[$key] = hslToRgbStr($hsl);
        }
//        dd($this->scheme);
    }

    public function render()
    {
        return view('livewire.settings.salon');
    }


}
