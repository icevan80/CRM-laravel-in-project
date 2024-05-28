<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Salon extends Component
{
    public string $primary = '';
    public string $secondary = '';
    public string $surface = '';

    public function mount() {
        $file = file_get_contents(resource_path('/settings/default.json'));
        $theme = json_decode($file, true);
        $this->primary = $theme['primary_color'];
        $this->secondary = $theme['secondary_color'];
        $this->surface = $theme['surface_color'];
    }

    public function render()
    {
        return view('livewire.settings.salon');
    }


}
