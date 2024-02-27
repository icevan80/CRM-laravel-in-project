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

    private $services;
    private $locations;

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

    // public

    private $timeNow;
    public $selectedDay;
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

    public function render()
    {


        $query = Appointment::with('timeSlot', 'user', 'service', 'location');
        if ($this->search) {
            $query->where(function ($subQuery) {
                $subQuery
                    ->where('date', 'like', '%' . $this->search . '%')
                    ->orWhere('appointment_code', 'like', '%' . $this->search . '%')
                    ->orWhere('start_time', 'like', '%' . $this->search . '%')
                    ->orWhere('end_time', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('service_id', 'like', '%' . $this->search . '%')
                    ->orWhere('time_slot_id', 'like', '%' . $this->search . '%')
                    ->orWhere('location_id', 'like', '%' . $this->search . '%');
            });

            $query->orWhereHas('user', function ($userQuery) {
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

            $query->where('user_id', $this->userId);
        }
//        dd($this->selectFilter);
        if ($this->selectFilter === 'previous') {
            $query->whereDate('date', '<', Carbon::today())->where('status', 1);

        } else if ($this->selectFilter === 'upcoming') {
            $query->whereDate('date', '>=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1))->whereDate('date', '<=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1)->addWeeks(2))->where('status', 1);

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

        return view('livewire.manage-appointments', [
            'appointments' => $this->appointments,
            'services' => $this->services,
            'locations' => $this->locations,
            'selectedCreateService' => $this->selectedCreateService,
            'selectedCreateLocation' => $this->selectedCreateLocation,
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


        if (auth()->user()->id == $this->appointment->user->id
            || auth()->user()->role->name == (UserRolesEnum::Employee->name || UserRolesEnum::Admin->name)) {

            $this->appointment->status = 0;
//        $this->appointment->cancelled_by = auth()->user()->id;
            // TODO add reason
            $this->appointment->save();
            $this->confirmingAppointmentCancellation = false;
        }
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
                'cart_id' => 1,
                'user_id' => auth()->user()->id,
                'service_id' => $this->serviceConverter($this->selectedCreateService)->id,
                'date' => $this->selectedCreateDay,
                'time_slot_id' => 1,
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

    protected function serviceConverter($service): Service
    {
        return $service;
    }

    protected function locationConverter($location): Location
    {
        return $location;
    }
}
