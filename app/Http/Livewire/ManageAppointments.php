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

    public $services;
    public $locations;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $appointment;

    public $confirmingAppointmentAdd;

    public $confirmAppointmentCancellation = false;
    public $confirmingAppointmentCancellation = false;
    public $confirmingAppointmentCreate = false;
    public $confirmingAppointmentSelect = false;
    public $notificationAppointmentCreated = false;
    public $notificationAppointmentCreatedError = false;
    public $notificationAppointmentSwapped = false;
    public $notificationAppointmentSwappedError = false;

    // public

    public $timeNow;
    public $selectedDay;
    public $startDate;
    public $selectedAppointment;

    public $selectedCreateDay;
    public $selectedCreateService;
    public $selectedCreateLocation;
    public $selectedCreateTime;

    public $selectFilter = 'upcoming'; // can be 'upcoming' , 'previous' , 'cancelled'

    public $userId;

    protected $rules = [
//        "appointment.name" => "required|string|max:255",
        'selectedCreateService' => 'required',
        'selectedCreateLocation' => 'required',
        'selectedCreateDay' => 'required|string',
        'selectedCreateTime' => 'required|string',
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

        $this->timeNow = Carbon::now();
        $this->selectedDay = Carbon::today()->format('Y-m-d');
    }

    public function generateArray($appointments): array
    {
        $arrayWeek = array();
        $elementId = 1;
        $dayId = 1;
        for ($i = $this->dateRange['start']; $i < $this->dateRange['end']->copy(); $i->addDay()) {
            $arrayDay = array();
            $arrayDayAppointment = $this->in_array_by_key($i->toDateString(), $appointments, 'date');
            if (count($arrayDayAppointment) > 0) {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $addSlot = false;
                    foreach ($arrayDayAppointment as $appointment) {
                        $currentStart = $i->copy()->setTimeFrom($appointment['start_time']);
                        $currentEnd = $i->copy()->setTimeFrom($appointment['end_time'])->subMinute();
                        if ($currentStart == $k) {
                            $range = Carbon::parse($appointment['start_time'])->diffInMinutes(Carbon::parse($appointment['end_time'])) / 15;
                            $arrayDay[] = ['id' => $elementId++, 'minutes' => $k->copy()->toTimeString(), 'appointment' => $appointment, 'collapse' => false, 'range' => $range];
                            $addSlot = true;
                            break;
                        } elseif ($k->between($currentStart, $currentEnd)) {
                            $arrayDay[] = ['id' => $elementId++, 'minutes' => $k->copy()->toTimeString(), 'appointment' => null, 'collapse' => true, 'range' => 1];
                            $addSlot = true;
                        }
                    }
                    if (!$addSlot) {
                        $arrayDay[] = ['id' => $elementId++, 'minutes' => $k->copy()->toTimeString(), 'appointment' => null, 'collapse' => false, 'range' => 1];
                    }
                }
            } else {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $arrayDay[] = ['id' => $elementId++, 'minutes' => $k->copy()->toTimeString(), 'appointment' => null, 'collapse' => false];
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

    public function generateDateRange(string $date): bool
    {
        $result = true;
        $this->dateRange['now'] = Carbon::parse($this->selectedDay);
        $startDay = Carbon::parse($this->selectedDay)->setDaysFromStartOfWeek(1);

        if ($this->dateRange['start'] == null || $this->dateRange['start'] != $startDay) {
            $result = true;
            $this->dateRange['start'] = $startDay->copy();
            $this->dateRange['end'] = $startDay->copy()->addWeeks(1);
        }

        return $result;
    }

    public function reorder($idFrom, $idTo)
    {
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

            $is_available = DB::table('appointments')
                ->whereDate('date', '=', Carbon::parse($dayTo)->toDateString())
                ->whereBetween('start_time', [Carbon::parse($cellTo['minutes'])->toTimeString(), Carbon::parse($cellTo['minutes'])->addMinutes($cellFrom['range'] * 15)->subMinute()->toTimeString()]);
            if ($is_available->count() == 0) {

                Appointment::where('appointment_code', $cellFrom['appointment']['appointment_code'])->update([
                    'date' => Carbon::parse($dayTo)->toDateString(),
                    'start_time' => Carbon::parse($cellTo['minutes'])->toTimeString(),
                    'end_time' => Carbon::parse($cellTo['minutes'])->addMinutes($cellFrom['range'] * 15)->toTimeString(),
                ]);
                $this->notificationAppointmentSwapped = true;
            } else {
                $this->notificationAppointmentSwappedError = true;
            }
        }
        else {
            $this->notificationAppointmentSwappedError = true;
        }
    }

    public function appointmentCancel() {

    }

    public function appointmentCancelConfirmed($appointment) {

    }

    public function render()
    {


        $query = Appointment::with('creator', 'receiving', 'service', 'location');
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

            $query->orWhereHas('receiving', function ($userQuery) {
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

        if ($this->selectedCreateService == null && $this->services != null) {
            $this->selectedCreateService = $this->services[0];
        }

        if ($this->locations == null) {
            $this->locations = Location::all();
        }

        if ($this->selectedCreateLocation == null && $this->locations != null) {
            $this->selectedCreateLocation = $this->locations[0];
        }

        if ($this->generateDateRange($this->selectedDay)) {
            $this->tableCells = $this->generateArray($this->appointments);
        }

        return view('livewire.manage-appointments', [
            'appointments' => $this->appointments,
            'services' => $this->services,
            'locations' => $this->locations,
            'selectedCreateService' => $this->selectedCreateService,
            'selectedCreateLocation' => $this->selectedCreateLocation,
            'tableCells' => $this->tableCells,
//            'selectedCreateService' => $this->selectedCreateService,
        ]);
    }


    private function getServicesList()
    {
        $services = Service::all();
        if ($services->isNull()) {
            $this->services = [];
        } else {
            $this->services = $services;
        }
    }



//    public function confirmAppointmentEdit(Appointment $appointment) {
//        $this->appointment = $appointment;
//        $this->confirmingAppointmentAdd= true;
//    }
    public function confirmAppointmentCancellation()
    {
        $this->confirmingAppointmentCancellation = true;
    }

    public function saveAppointment()
    {
        //    $this->validate();

        if (isset($this->appointment->id)) {
            $this->appointment->save();
        } else {
            Appointment::create(
                [
                    'name' => $this->appointment['name'],
                ]
            );
        }

        $this->confirmingAppointmentAdd = false;
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

    public function confirmAppointmentAdd()
    {
//        $this->getServicesList();
        $this->confirmingAppointmentAdd = true;
    }

    public function setSelectedAppointment(Appointment $appointment)
    {
        $this->selectedAppointment = $appointment;
        $this->confirmingAppointmentSelect = true;
    }

    public function confirmAppointmentCreate(
        string $time
    )
    {
        $carbonTime = Carbon::create($time);
        $this->selectedCreateDay = $carbonTime->toDateString();
        $this->selectedCreateTime = $carbonTime->toTimeString();
        $this->confirmingAppointmentCreate = true;
        $this->render();
    }

    public function createAppointment()
    {

        $is_available = DB::table('appointments')
            ->whereDate('date', '=', Carbon::today()->setDateFrom($this->selectedCreateDay))
            ->whereBetween('start_time', [$this->selectedCreateTime, today()->setTimeFrom($this->selectedCreateTime)->addMinutes(59)->toTimeString()]);

        if ($is_available->count() == 0) {

            Appointment::create([
                'creator_id' => auth()->user()->id,
                'receiving_id' => auth()->user()->id,
                'service_id' => $this->serviceConverter($this->selectedCreateService)->id,
                'date' => $this->selectedCreateDay,
                'start_time' => $this->selectedCreateTime,
                'end_time' => today()->setTimeFrom($this->selectedCreateTime)->addMinutes(60)->toTimeString(),
                'location_id' => $this->locationConverter($this->selectedCreateLocation)->id,
                'total' => $this->serviceConverter($this->selectedCreateService)->price,
            ]);
            $this->notificationAppointmentCreated = true;
        } else {
            $this->notificationAppointmentCreatedError = true;
        }
        $this->confirmingAppointmentCreate = false;
    }

    protected function serviceConverter($serviceId): Service
    {
        foreach ($this->services as $service) {
            if ($serviceId.'' == $service->id.'') {
                return $service;
            }
        }
            return $this->services->first();
//        return $service;
    }

    protected function locationConverter($locationId): Location
    {
        foreach ($this->locations as $location) {

            if ($locationId.'' == $location->id.'') {
                return $location;
            }
        }
        return $this->locations->first();
    }
}
