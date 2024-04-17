<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class AppointmentsGrid extends Component
{
    public function events(): Collection
    {
//        return Appointment::query()
//            ->whereDate('date', '>=', $this->gridStartsAt)
//            ->whereDate('date', '<=', $this->gridEndsAt)
//            ->get()
//            ->map(function (Appointment $appointment) {
//                return [
//                    'id' => $appointment->id,
//                    'title' => $appointment->service->name,
//                    'description' => $appointment->creator->name,
//                    'date' => $appointment->date,
//                ];
//            });
        return collect([
            [
                'id' => 1,
                'title' => 'Breakfast',
                'description' => 'Pancakes! 🥞',
                'date' => Carbon::today(),
            ],
            [
                'id' => 2,
                'title' => 'Meeting with Pamela',
                'description' => 'Work stuff',
                'date' => Carbon::tomorrow(),
            ],
        ]);
    }
}
