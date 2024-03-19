<?php

namespace App\Http\Livewire;

use App\Enums\UserRolesEnum;
use App\Models\Appointment;
use App\Models\Location;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\alert;


class ManageAppointments extends Component
{

    private $appointments;
    public $tableCells = [];
    public $dateRange = array('now' => null, 'start' => null, 'end' => null);
    private $forceGenerate = false;

    public $services;
    public $locations;
    public $masters;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $appointment;

    public bool $confirmAppointmentCancellation = false;
    public bool $confirmingAppointmentCancellation = false;
    public bool $confirmAppointmentDelete = false;
    public bool $confirmingAppointmentDelete = false;
    public bool $confirmingAppointmentCreate = false;
    public bool $confirmingAppointmentSelect = false;
    public bool $notificationAppointmentCreated = false;
    public bool $notificationAppointmentCreatedError = false;
    public bool $notificationAppointmentSwapped = false;
    public bool $notificationAppointmentSwappedError = false;


    public bool $allowOthers = false;
    public bool $allowChangeDate = false;
    public bool $allowChangeAppointments = false;

    // public

    public $selectedDay;

    public array $newAppointment = array(
        'creator_id' => null,
        'implementer_id' => null,
        'receiving_name' => null,
        'receiving_description' => null,
        'date' => null,
        'start_time' => null,
        'end_time' => null,
        'location_id' => null,
        'service_id' => null,
        'total' => null,
    );

    public string $selectFilter = 'upcoming'; // can be 'upcoming' , 'previous' , 'cancelled'
    public string $viewFilter = 'table_one_week'; // table_two_weeks table_one_week table_today_tomorrow rows
    public string $followFilter = 'salon'; // salon master self
    public $locationFilter = 0;
    public $masterFilter = "0";
    public $implementer;

//    public string $locationFilter = 'table_one_week';

    public $userId;
    public $user;

    protected $rules = [
//        "appointment.name" => "required|string|max:255",
    ];

    protected $casts = [
        'selectedDay' => 'date:Y-m-d'
    ];

    public function mount($userId = null, $selectFilter = 'upcoming')
    {
        $user = auth()->user();

        $this->user = $user;
        $this->allowOthers = $user->role->edit_other == 1;
        $this->allowChangeDate = $user->role->edit_date_self == 1;
        $this->allowChangeAppointments = $user->role->edit_self == 1;

        if (!$this->allowOthers) {
            $this->viewFilter = 'table_today_tomorrow';
            $this->followFilter = 'master';
            $this->masterFilter = $user->id;
        }
//        if (auth()->user()->role->name == "Customer") {
//            $this->userId = auth()->user()->id;
//        } else if (auth()->user()->role->name == ("Employee" || "Admin")) {
//            $this->userId = $userId;
//        }

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


//        if ($this->userId) {
//
//            $query->where('creator_id', $this->userId);
//        }
//        dd($this->selectFilter);


//        dd($this->appointments);

        if ($this->services == null) {
            $this->services = Service::all();
        }

        if ($this->locations == null) {
            $this->locations = Location::all();
            $this->locationFilter = $this->locations->first()->id;
        }

        if ($this->masters == null) {
            $this->masters = User::all()->filter(function ($master) {
                return in_array($master->role_id, array(3, 5, 8, 10, 11));
            });
        }


        switch ($this->viewFilter) {
            case 'table_today_tomorrow':
            case 'table_two_weeks':
            case 'table_one_week':
//            $query->whereDate('date', '>=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1))->whereDate('date', '<=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1)->addWeeks(2))
//                ->where('status', 1);
                break;
            case 'rows':
                if ($this->selectFilter === 'previous') {
                    $query->whereDate('date', '<', Carbon::today())->where('status', 1);

                } else if ($this->selectFilter === 'upcoming') {
                    $query->whereDate('date', '>', Carbon::today())->where('status', 1);

                } else if ($this->selectFilter === 'cancelled') {
                    $query->where('status', 0);
                }
                break;
        }

//        if (!$this->allowOthers) {
//            $query->where('implementer_id', $this->user->id);
//        } else {
        if ($this->followFilter == 'salon') {
            $query->where('location_id', $this->locationFilter);
        } elseif ($this->followFilter == 'master' && $this->masterFilter != 0) {
            $query->where('implementer_id', $this->masterFilter);
        } elseif ($this->followFilter == 'self') {
            $query->where('creator_id', auth()->user()->id);
        }
//        }


        $this->appointments = $query
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(50);


        switch ($this->viewFilter) {
            case 'table_today_tomorrow':
            case 'table_two_weeks':
            case 'table_one_week':
                if ($this->generateDateRange($this->selectedDay) || $this->forceGenerate) {
                    $query->whereDate('date', '>=', $this->dateRange['start'])
                        ->whereDate('date', '<=', $this->dateRange['end'])
                        ->where('status', 1);
                    $this->tableCells = $this->generateArray($this->appointments);
                    $this->forceGenerate = false;
                }
                return view('livewire.manage-appointments', [
                    'appointments' => $this->appointments,
                    'services' => $this->services,
                    'locations' => $this->locations,
                    'masters' => $this->masters,
                    'tableCells' => $this->tableCells,
                ]);
            case 'rows':
                return view('livewire.manage-appointments-rows', [
                    'appointments' => $this->appointments,
                    'services' => $this->services,
                    'locations' => $this->locations,
                    'masters' => $this->masters,
                ]);
        }
    }

    private function generateArray($appointments): array
    {


        $arrayWeek = array();
        $available = $this->allowChangeDate;
        for ($i = $this->dateRange['start']; $i < $this->dateRange['end']->copy(); $i->addDay()) {
            $arrayDay = array();
            $arrayDayAppointment = $this->in_array_by_key($i->toDateString(), $appointments, 'date');
            if (count($arrayDayAppointment) > 0) {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $arrayDay[] = ['id' => $i->day . '-' . $k->toTimeString(), 'minutes' => $k->copy()->toTimeString(), 'appointments' => array()];
                }
                foreach ($arrayDayAppointment as $appointment) {
                    $index = array_search($appointment['start_time'], array_column($arrayDay, 'minutes'));
                    $range = Carbon::parse($appointment['start_time'])->diffInMinutes(Carbon::parse($appointment['end_time'])) / 15;
                    $itemAvailable = $available && $i->copy()->setTimeFrom($appointment['start_time'])->greaterThan(now()) && $appointment['complete'] == 0;
                    $arrayDay[$index]['appointments'][] = array('range' => $range, 'data' => $appointment, 'available' => $itemAvailable);
                    usort($arrayDay[$index]['appointments'], fn($a, $b) => $b["range"] <=> $a["range"]);
                }
            } else {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $arrayDay[] = ['id' => $i->day . '-' . $k->toTimeString(), 'minutes' => $k->copy()->toTimeString(), 'appointments' => array()];
                }
            }
            $arrayWeek[] = ['id' => $i->day, 'day' => $i->copy()->toDateString(), 'schedule' => $arrayDay];
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
        $start = Carbon::parse($date);
        $end = Carbon::parse($date)->setDaysFromStartOfWeek(1);

        switch ($this->viewFilter) {
            case 'table_two_weeks':
                $start->setDaysFromStartOfWeek(1);
                $end = $start->copy()->addWeeks(2);
                break;
            case 'table_one_week':
                $start->setDaysFromStartOfWeek(1);
                $end = $start->copy()->addWeeks(1);
                break;
            case 'table_today_tomorrow':
                $end = $start->copy()->addDays(2);
                break;
        }

        if ($this->dateRange['start'] == null || $this->dateRange['start'] != $start || $this->dateRange['end'] != $end) {
            $result = true;
            $this->dateRange['start'] = $start;
            $this->dateRange['end'] = $end;
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
            $currentAppointment = null;
            foreach ($cellFrom['appointments'] as $appointment) {
                if ($appointment['data']['appointment_code'] == $idElement) {
                    $currentAppointment = $appointment;
                }
            }

//            dd($currentAppointment);

//            $is_available = DB::table('appointments')
//                ->whereDate('date', '=', Carbon::parse($dayTo)->toDateString())
//                ->whereBetween('start_time', [Carbon::parse($cellTo['minutes'])->toTimeString(), Carbon::parse($cellTo['minutes'])->addMinutes($cellFrom['range'] * 15)->subMinute()->toTimeString()]);
            if ($currentAppointment != null) {
                if ($this->masterSlotValidate(Carbon::parse($dayTo)->toDateString(),
                    Carbon::parse($cellTo['minutes'])->toTimeString(),
                    Carbon::parse($cellTo['minutes'])->addMinutes($currentAppointment['range'] * 15)->subMinute()->toTimeString(),
                    $currentAppointment['data']['implementer_id'],
                    $currentAppointment['data']['appointment_code'])) {
                    Appointment::where('appointment_code', $idElement)->update([
                        'date' => Carbon::parse($dayTo)->toDateString(),
                        'start_time' => Carbon::parse($cellTo['minutes'])->toTimeString(),
                        'end_time' => Carbon::parse($cellTo['minutes'])->addMinutes(15 * $currentAppointment['range'])->toTimeString(),
                    ]);
                    $this->notificationAppointmentSwapped = true;
                } else {
                    $this->notificationAppointmentSwappedError = true;
                }
            }


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
        $this->appointment = $appointment;


//        if (auth()->user()->id == $this->appointment->user->id
//            || auth()->user()->role->name == (UserRolesEnum::Employee->name || UserRolesEnum::Admin->name)) {

        $this->appointment->status = 0;
//        $this->appointment->cancelled_by = auth()->user()->id;
        // TODO add reason
        $this->appointment->save();
        $this->confirmingAppointmentDelete = false;
        $this->confirmingAppointmentSelect = false;


    }

    public function cancelAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;


//        if (auth()->user()->id == $this->appointment->user->id
//            || auth()->user()->role->name == (UserRolesEnum::Employee->name || UserRolesEnum::Admin->name)) {

        $this->appointment->complete = 1;
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
        $this->implementer = $appointment->implementer_id;
        $this->confirmingAppointmentSelect = true;
    }

    public function changeImplementer(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->appointment->implementer_id = $this->implementer;
        $this->appointment->save();
    }

    public function confirmAppointmentCreate(
        string $time,
        bool   $onAppointment,
    )
    {
        if (!$onAppointment) {
            $carbonTime = Carbon::create($time);
            $this->newAppointment['creator_id'] = $this->user->id;
            if ($this->allowOthers) {
                $this->newAppointment['implementer_id'] = $this->masters->first()->id;
            } else {
                $this->newAppointment['implementer_id'] = $this->masterFilter;
            }
            $this->newAppointment['date'] = $carbonTime->toDateString();
            $this->newAppointment['start_time'] = $carbonTime->toTimeString();
            $this->newAppointment['end_time'] = $carbonTime->addMinutes(15)->toTimeString();
            $this->newAppointment['location_id'] = $this->locations->first()->id;
            $this->newAppointment['service_id'] = $this->services->first()->id;
            $this->confirmingAppointmentCreate = true;
        }
    }

    public function createAppointment()
    {
        $this->newAppointment['total'] = $this->serviceConverter($this->newAppointment['service_id'])->price;
        if ($this->newAppointment['receiving_description'] == null) {
            $this->newAppointment['receiving_description'] = '';
        }

        if ($this->masterSlotValidate($this->newAppointment['date'], $this->newAppointment['start_time'], $this->newAppointment['end_time'], $this->newAppointment['implementer_id'])) {

            Appointment::create([
                'creator_id' => $this->newAppointment['creator_id'],
                'implementer_id' => $this->newAppointment['implementer_id'],
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
            'implementer_id' => null,
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

    protected function masterSlotValidate(string $date, string $timeStart, string $timeEnd, int $masterId, string $appointmentCode = ''): bool
    {

//        dd($date.'\n'.$timeStart.'\n'.$timeEnd);

        $is_available_first = DB::table('appointments')
            ->whereNot('appointment_code', $appointmentCode)
            ->where('implementer_id', $masterId)
            ->whereDate('date', '=', Carbon::today()->setDateFrom($date))
            ->whereBetween('start_time', [$timeStart, today()->setTimeFrom($timeEnd)->subMinute()->toTimeString()]);

        $is_available_second = DB::table('appointments')
            ->whereNot('appointment_code', $appointmentCode)
            ->where('implementer_id', $masterId)
            ->whereDate('date', '=', Carbon::today()->setDateFrom($date))
            ->whereBetween('end_time', [$timeStart, today()->setTimeFrom($timeEnd)->subMinute()->toTimeString()]);

        return $is_available_first->count() == 0 && $is_available_second->count() == 0;
    }
}
