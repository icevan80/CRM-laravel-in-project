<?php

namespace App\Http\Livewire\Manage;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Appointments extends Component
{
    private $appointments;
    public $tableCells = [];
    public $dateRange = array('now' => null, 'start' => null, 'end' => null);
    private $forceGenerate = false;

    public $services;
    public $locations;
    public $masters;

    public $search;

    public string $list = 'one_week'; // two_weeks one_week today_tomorrow rows
    public string $view = 'salon'; // salon master self
    public $follow;
    public $filter;
    public $select;

    protected $queryString = [
        'search' => ['except' => ''],
        'list' => ['except' => 'one_week'],
        'view' => ['except' => ''],
        'filter' => ['except' => ''],
        'select' => ['except' => ''],
    ];

    public $appointment = false;


    public $confirmSelectAppointment = false;
    public bool $confirmingAppointmentCancellation = false;
    public bool $confirmingAppointmentDelete = false;
    public $confirmingAppointmentCreate = false;
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

    public $implementer;


    public $userId;
    public $user;

    protected $casts = [
        'selectedDay' => 'date:Y-m-d'
    ];

    protected $rules = [
        'confirmSelectAppointment' => '',
        'confirmingAppointmentCreate' => '',
    ];

    public function mount($locations = array(), $masters = array(), $services = array(), $userId = null)
    {
        $this->locations = $locations;
        $this->masters = $masters;
        $this->services = $services;

        if (count($locations) > 0) {
            $this->follow = $locations->first()->id;
        }

        if($this->select != '') {
            $this->confirmSelectAppointment = Appointment::where('id', $this->select)->where('status', true)->first();
            if ($this->confirmSelectAppointment == null) {
                $this->select = '';
            }
        }

        if ($userId != null) {
            $user = User::findOrFail('id', $userId);
        } else {
            $user = auth()->user();
        }

        $this->user = $user;
        $this->allowOthers = auth()->user()->hasPermission('edit_other_appointment');
        $this->allowChangeDate = auth()->user()->hasPermission('edit_date_appointment');
        $this->allowChangeAppointments = auth()->user()->hasPermission('edit_appointment');

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

        switch ($this->list) {
            case 'today_tomorrow':
            case 'two_weeks':
            case 'one_week':
//            $query->whereDate('date', '>=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1))->whereDate('date', '<=', Carbon::today()->setDateFrom($this->selectedDay)->setDaysFromStartOfWeek(1)->addWeeks(2))
//                ->where('status', 1);
                break;
            case 'rows':
                if ($this->filter === 'previous') {
                    $query->whereDate('date', '<', Carbon::today())->where('status', 1);

                } else if ($this->filter === 'upcoming') {
                    $query->whereDate('date', '>', Carbon::today())->where('status', 1);

                } else if ($this->filter === 'cancelled') {
                    $query->where('status', 0);
                }
                break;
        }

        if ($this->view == 'salon') {
            $query->where('location_id', $this->follow);
        } elseif ($this->view == 'master' && $this->follow != 0) {
            $query->where('implementer_id', $this->follow);
        } elseif ($this->view == 'self') {
            $query->where('creator_id', auth()->user()->id);
        }

        $this->appointments = $query
            ->orderBy('date')
            ->orderBy('start_time')
            ->where('status', true)
            ->paginate(50);


        switch ($this->list) {
            case 'today_tomorrow':
            case 'two_weeks':
            case 'one_week':
                if ($this->generateDateRange($this->selectedDay) || $this->forceGenerate) {
                    $query->whereDate('date', '>=', $this->dateRange['start'])
                        ->whereDate('date', '<=', $this->dateRange['end'])
                        ->where('status', 1);
                    $this->tableCells = $this->generateArray($this->appointments);
                    $this->forceGenerate = false;
                }
                return view('livewire.manage.appointments', [
                    'appointments' => $this->appointments,
                    'services' => $this->services,
                    'locations' => $this->locations,
                    'masters' => $this->masters,
                    'tableCells' => $this->tableCells,
                    'list' => $this->list,
                    'view' => $this->view,
                    'follow' => $this->follow,
                    'filter' => $this->filter,

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

    public function getSelectedServiceDuration(): int {
        return $this->services->where('id', $this->newAppointment['service_id'])->first()->duration_minutes;
    }

    public function getSelectedServiceTotal(): int {
        return $this->services->where('id', $this->newAppointment['service_id'])->first()->price;
    }

    public function updatedView($value)
    {
        // TODO: добавить разрешение view_other_appointemnt
        if (auth()->user()->hasPermission('edit_other_appointment')) {
            if ($value == 'salon' && $this->locations) {
                $this->follow = $this->locations->first()->id;
            } else if ($value == 'master' && $this->masters) {
                $this->follow = $this->masters->first()->id;
            } else if ($value == 'self') {
                $this->follow = auth()->user()->id;
            } else {
                $this->follow = '';
            }
        } else {
            $this->follow = auth()->user()->id;
        }
    }

    private function generateArray($appointments): array
    {
        $arrayWeek = array();
        $available = $this->allowChangeDate;
        for ($i = $this->dateRange['start']; $i < $this->dateRange['end']->copy(); $i->addDay()) {
            $appointmentsToday = 0;
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
                    $appointmentsToday++;
                }
            } else {
                for ($k = $i->copy()->hour(8); $k <= $i->copy()->hour(20); $k->addMinutes(15)) {
                    $arrayDay[] = ['id' => $i->day . '-' . $k->toTimeString(), 'minutes' => $k->copy()->toTimeString(), 'appointments' => array()];
                }
            }
            $arrayWeek[] = ['id' => $i->day, 'day' => $i->copy()->toDateString(), 'schedule' => $arrayDay, 'count_appointments' => $appointmentsToday];
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
        $end = Carbon::parse($date)->setDaysFromStartOfWeek(0);

        switch ($this->list) {
            case 'two_weeks':
                $start->setDaysFromStartOfWeek(0);
                $end = $start->copy()->addWeeks(2);
                break;
            case 'one_week':
                $start->setDaysFromStartOfWeek(0);
                $end = $start->copy()->addWeeks(1);
                break;
            case 'today_tomorrow':
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

    public function setSelectedAppointment(Appointment $appointment)
    {
        $this->confirmSelectAppointment = $appointment;
        $this->select = $appointment->id;
    }

    public function unsetSelectedAppointment()
    {
        $this->confirmSelectAppointment = false;
        $this->select = '';

        $this->confirmingAppointmentDelete = false;
        $this->confirmingAppointmentCancellation = false;
    }

    public function confirmAppointmentCreate(
        string $time,
        bool   $onAppointment,
    ) {
        if (!$onAppointment) {
            $carbonTime = Carbon::create($time);
            if ($carbonTime->minute % 15 != 0) {
                $carbonTime->addMinutes(15 - $carbonTime->minute % 15);
            }
            $this->newAppointment['date'] = $carbonTime->toDateString();
            $this->newAppointment['start_time'] = $carbonTime->toTimeString();
            $this->newAppointment['service_id'] = $this->services->first()->id;
            $this->confirmingAppointmentCreate = $carbonTime;
        }
    }

    protected function masterSlotValidate(string $date, string $timeStart, string $timeEnd, int $masterId, string $appointmentCode = ''): bool
    {
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
