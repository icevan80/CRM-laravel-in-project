<?php

namespace App\Http\Livewire;

use App\Enums\UserRolesEnum;
use App\Models\Appointment;
use App\Models\Location;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class ManageAppointments extends Component
{

    private $appointments;
    public $tableCells = [];
    public $dateRange = array('now' => null, 'start' => null, 'end' => null);
    private $forceGenerate = false;

    public $typeOfView = 'TableCrmTwoWeeks';

    public $services;
    public $locations;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $appointment;

    public $confirmAppointmentCancellation = false;
    public $confirmingAppointmentCancellation = false;
    public $confirmAppointmentDelete = false;
    public $confirmingAppointmentDelete = false;
    public $confirmingAppointmentCreate = false;
    public $confirmingAppointmentSelect = false;
    public $notificationAppointmentCreated = false;
    public $notificationAppointmentCreatedError = false;
    public $notificationAppointmentSwapped = false;
    public $notificationAppointmentSwappedError = false;

    // public

    public $selectedDay;

    public $newAppointment = array(
        'creator_id' => null,
        'receiving_name' => null,
        'receiving_description' => null,
        'date' => null,
        'start_time' => null,
        'end_time' => null,
        'location_id' => null,
        'service_id' => null,
        'total' => null,
    );

    public $selectFilter = 'upcoming'; // can be 'upcoming' , 'previous' , 'cancelled'

    public $userId;

    protected $rules = [
//        "appointment.name" => "required|string|max:255",
    ];

    protected $casts = [
        'selectedDay' => 'date:Y-m-d'
    ];

    public function mount($userId = null, $selectFilter = 'upcoming')
    {
        if (auth()->user()->role->name == "Customer") {
            $this->userId = auth()->user()->id;
        } else if (auth()->user()->role->name == ("Employee" || "Admin")) {
            $this->userId = $userId;
        }
        $selectFilter ? $this->selectFilter = $selectFilter : $this->selectFilter = 'upcoming';

        $this->selectedDay = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        $query = Appointment::with('creator', 'service', 'location');
        if ($this->search) {
            $query->where(function ($subQuery) {
                $subQuery
                    ->where('date', 'like', '%' . $this->search . '%')
                    ->orWhere('appointment_code', 'like', '%' . $this->search . '%')
                    ->orWhere('start_time', 'like', '%' . $this->search . '%')
                    ->orWhere('end_time', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('service_id', 'like', '%' . $this->search . '%')
//                    ->orWhere('time_slot_id', 'like', '%' . $this->search . '%')
                    ->orWhere('location_id', 'like', '%' . $this->search . '%');
            });

            $query->orWhereHas('creator', function ($userQuery) {
                $userQuery->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone_number', 'like', '%' . $this->search . '%');
            });

            $query->orWhereHas('service', function ($serviceQuery) {
                $serviceQuery->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('category_id', 'like', '%' . $this->search . '%');
            });

            $query->orWhereHas('location', function ($locationQuery) {
                $locationQuery->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%')
                    ->orWhere('telephone_number', 'like', '%' . $this->search . '%');
            });
        }


        if ($this->userId) {

            $query->where('creator_id', $this->userId);
        }
//        dd($this->selectFilter);
        if ($this->selectFilter === 'previous') {
            $query->whereDate('date', '<', Carbon::today())->where('status', 1);

        } else if ($this->selectFilter === 'upcoming') {
            $query->whereDate('date', '>=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1))->whereDate('date', '<=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1)->addWeeks(2));

        } else if ($this->selectFilter === 'cancelled') {
            $query->where('status', 0);
        }

        $this->appointments = $query
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(50);
//        dd($this->appointments);


        if ($this->services == null) {
            $this->services = Service::all();
        }

        if ($this->locations == null) {
            $this->locations = Location::all();
        }

        if ($this->generateDateRange($this->selectedDay) || $this->forceGenerate) {
            $this->tableCells = $this->generateArray($this->appointments);
            $this->forceGenerate = false;
        }

        switch ($this->typeOfView) {
            case 'TableCrmTodayTomorrow':
            case 'TableCrmTwoWeeks':
                return view('livewire.manage-appointments', [
                    'appointments' => $this->appointments,
                    'services' => $this->services,
                    'locations' => $this->locations,
                    'tableCells' => $this->tableCells,
                ]);
            case 'TableRows':
                return view('livewire.manage-appointments-stroke', [
                    'appointments' => $this->appointments,
                    ]);
        }
    }

    private function generateArray($appointments): array
    {



        $arrayWeek = array();
        $elementId = 1;
        $dayId = 1;
        for ($i = $this->dateRange['start']; $i < $this->dateRange['end']->copy(); $i->addDay()) {
            $arrayDay = array();
            $arrayDayAppointment = $this->in_array_by_key($i->toDateString(), $appointments, 'date');
            if (count($arrayDayAppointment) > 0) {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $arrayDay[] = ['id' => $elementId++, 'minutes' => $k->copy()->toTimeString(), 'appointments' => array()];
                }
                foreach ($arrayDayAppointment as $appointment) {
                    $index = array_search($appointment['start_time'], array_column($arrayDay, 'minutes'));
                    $range = Carbon::parse($appointment['start_time'])->diffInMinutes(Carbon::parse($appointment['end_time'])) / 15;
                    $available = $i->copy()->setTimeFrom($appointment['start_time'])->greaterThan(now()) && $appointment['status'];
                    $arrayDay[$index]['appointments'][] = array('range' => $range, 'data' => $appointment, 'available' => $available);
                    usort($arrayDay[$index]['appointments'], fn($a, $b) => $b["range"] <=> $a["range"]);
                }
            } else {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $arrayDay[] = ['id' => $elementId++, 'minutes' => $k->copy()->toTimeString(), 'appointments' => array()];
                }
            }
            $arrayWeek[] = ['id' => $dayId++, 'day' => $i->copy()->toDateString(), 'schedule' => $arrayDay];
        }
        return $arrayWeek;
    }


    private function in_array_by_key(mixed $needle, mixed $array, string $key): array
    {
        $arrayByNeedle = array();

        foreach ($array as $element) {
            if ($element[$key] == $needle) {
                $arrayByNeedle[] = $element;
            }
        }

        return $arrayByNeedle;
    }

    private function generateDateRange(string $date): bool
    {
        $result = false;
        $this->dateRange['now'] = Carbon::parse($date);
        $startDay = Carbon::parse($date)->setDaysFromStartOfWeek(1);

        if ($this->dateRange['start'] == null || $this->dateRange['start'] != $startDay) {
            $result = true;
            $this->dateRange['start'] = $startDay->copy();
            $this->dateRange['end'] = $startDay->copy()->addWeeks(1);
        }

        return $result;
    }

    public function reorder($idFrom, $idTo, $idElement)
    {
//        dd($idFrom.' '.$idTo.' '.$idElement);
        $dayFrom = '';
        $dayTo = '';
        $cellFrom = array();
        $cellTo = array();

        foreach ($this->tableCells as $day) {
            foreach ($day['schedule'] as $timeSlot) {
                if ($timeSlot['id'] == $idFrom) {
                    $dayFrom = $day['day'];
                    $cellFrom = $timeSlot;
                }
                if ($timeSlot['id'] == $idTo) {
                    $dayTo = $day['day'];
                    $cellTo = $timeSlot;
                }
            }
        }


        if ($cellFrom != null && $cellTo != null &&
            Carbon::parse($dayFrom)->setTimeFrom(Carbon::parse($cellFrom['minutes']))->greaterThan(now()) &&
            Carbon::parse($dayTo)->setTimeFrom(Carbon::parse($cellTo['minutes']))->greaterThan(now())) {
            $this->forceGenerate = true;
            $range = null;
            foreach ($cellFrom['appointments'] as $appointment) {
                if ($appointment['data']['appointment_code'] == $idElement) {
                    $range = $appointment['range'];
                }
            }

//            dd($currentAppointment);

//            $is_available = DB::table('appointments')
//                ->whereDate('date', '=', Carbon::parse($dayTo)->toDateString())
//                ->whereBetween('start_time', [Carbon::parse($cellTo['minutes'])->toTimeString(), Carbon::parse($cellTo['minutes'])->addMinutes($cellFrom['range'] * 15)->subMinute()->toTimeString()]);
//            if ($is_available->count() == 0) {
            if ($range != null) {
                Appointment::where('appointment_code', $idElement)->update([
                    'date' => Carbon::parse($dayTo)->toDateString(),
                    'start_time' => Carbon::parse($cellTo['minutes'])->toTimeString(),
                    'end_time' => Carbon::parse($cellTo['minutes'])->addMinutes(15 * $range)->toTimeString(),
                ]);
                $this->notificationAppointmentSwapped = true;
            }
//            } else {
//                $this->notificationAppointmentSwappedError = true;
//            }

        } else {
            $this->notificationAppointmentSwappedError = true;
        }
    }

    public function confirmAppointmentCancellation()
    {
        $this->confirmingAppointmentCancellation = true;
    }

    public function confirmAppointmentDelete()
    {
        $this->confirmingAppointmentDelete = true;
    }

    public function deleteAppointment(Appointment $appointment)
    {
        $appointment->delete();
        $this->confirmingAppointmentDelete = false;
        $this->confirmingAppointmentSelect = false;
        $this->appointment = null;
    }

    public function cancelAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;


//        if (auth()->user()->id == $this->appointment->user->id
//            || auth()->user()->role->name == (UserRolesEnum::Employee->name || UserRolesEnum::Admin->name)) {

        $this->appointment->status = 0;
//        $this->appointment->cancelled_by = auth()->user()->id;
        // TODO add reason
        $this->appointment->save();
        $this->confirmingAppointmentCancellation = false;
        $this->confirmingAppointmentSelect = false;
//        }
    }

    public function setSelectedAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->confirmingAppointmentSelect = true;
    }

    public function confirmAppointmentCreate(
        string $time
    )
    {
        $carbonTime = Carbon::create($time);
        $this->newAppointment['creator_id'] = auth()->user()->id;
        $this->newAppointment['date'] = $carbonTime->toDateString();
        $this->newAppointment['start_time'] = $carbonTime->toTimeString();
        $this->newAppointment['location_id'] = $this->locations->first()->id;
        $this->newAppointment['service_id'] = $this->services->first()->id;
        $this->confirmingAppointmentCreate = true;
    }

    public function createAppointment()
    {

        $is_available = DB::table('appointments')
            ->whereDate('date', '=', Carbon::today()->setDateFrom($this->newAppointment['date']))
            ->whereBetween('start_time', [$this->newAppointment['start_time'], today()->setTimeFrom($this->newAppointment['start_time'])->addMinutes(59)->toTimeString()]);

        if ($is_available->count() == 0) {

            $this->newAppointment['end_time'] = today()->setTimeFrom($this->newAppointment['start_time'])->addMinutes(60)->toTimeString();
            $this->newAppointment['total'] = $this->serviceConverter($this->newAppointment['service_id'])->price;
            if ($this->newAppointment['receiving_description'] == null) {
                $this->newAppointment['receiving_description'] = '';
            }

            Appointment::create([
                'creator_id' => $this->newAppointment['creator_id'],
                'receiving_name' => $this->newAppointment['receiving_name'],
                'receiving_description' => $this->newAppointment['receiving_description'],
                'date' => $this->newAppointment['date'],
                'start_time' => $this->newAppointment['start_time'],
                'end_time' => $this->newAppointment['end_time'],
                'location_id' => $this->newAppointment['location_id'],
                'service_id' => $this->newAppointment['service_id'],
                'total' => $this->newAppointment['total'],
            ]);
            $this->notificationAppointmentCreated = true;
        } else {
            $this->notificationAppointmentCreatedError = true;
        }
        $this->confirmingAppointmentCreate = false;
        $this->newAppointment = array(
            'creator_id' => null,
            'receiving_name' => null,
            'receiving_description' => null,
            'date' => null,
            'start_time' => null,
            'end_time' => null,
            'location_id' => null,
            'service_id' => null,
            'total' => null,
        );
    }

    protected function serviceConverter($serviceId): Service
    {
        foreach ($this->services as $service) {
            if ($serviceId . '' == $service->id . '') {
                return $service;
            }
        }
        return $this->services->first();
    }

    protected function locationConverter($locationId): Location
    {
        foreach ($this->locations as $location) {

            if ($locationId . '' == $location->id . '') {
                return $location;
            }
        }
        return $this->locations->first();
    }
}
