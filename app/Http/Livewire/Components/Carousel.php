<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Carousel extends Component
{
    public $images = [
        'https://sun9-52.userapi.com/c855324/v855324512/7f9d7/uWCJUQCfcqE.jpg',
        'https://sun9-36.userapi.com/impg/vwr74652ShBi1hvS4sX7_EvOAENQU1F7-lSEiw/eBbwsaqJ57A.jpg?size=604x377&quality=95&sign=27d56dba4d85760a57d656e25d1d9820&c_uniq_tag=GLPSGCl6O_GV-onDzgtCbJwbCp2cqTy5uaRfRB5aq2k&type=album',
        'https://sun9-4.userapi.com/impf/c622924/v622924157/2ee58/0ydByhhZMGk.jpg?size=604x403&quality=96&sign=b4afd7f3590c4d6cacc65601ad0e7b20',
    ];

    public function render()
    {
        return view('livewire.components.carousel');
    }
}
