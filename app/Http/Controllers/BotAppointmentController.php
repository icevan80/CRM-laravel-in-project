<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Location;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BotAppointmentController extends Controller
{
    public $key = "1235";

    public function getArray($key, $method)
    {
        if ($key != $this->key) {
            return 'Wrong pass';
        }
        $answer = array();
        switch ($method) {
            case "services":
                $services = Service::all();
                foreach ($services as $service) {
                    $answer[] = array("id" => $service->id, "name" => $service->name, "price" => $service->price);
                }
                break;
            case "locations":
                $locations = Location::all();
                foreach ($locations as $location) {
                    $answer[] = array("id" => $location->id, "name" => $location->name, "address" => $location->address);
                }
                break;
            default:
                return 'Wrong method';
        }
        return response()->json($answer);
    }

    public function getTimeSlots($key, $date)
    {
        if ($key != $this->key) {
            return 'Wrong pass';
        }
        $appointments = Appointment::all()->where('date', '=', $date);
        $startHour = today()->hours(8)->toTimeString();
        $answer = array();

        foreach ($appointments as $appointment) {
            if (!$this->getTime($appointment['start_time'])->equalTo($this->getTime($startHour)) &&
                $this->getTime($appointment['start_time'])->diffInHours($this->getTime($startHour)) > 0) {
                $answer[] = array('start' => $startHour, 'end' => $appointment['start_time']);
            }
            $startHour = $appointment['end_time'];
        }

        if (!$this->getTime($startHour)->equalTo($this->getTime($startHour)->hours(20))) {
            $answer[] = array('start' => $startHour, 'end' => $this->getTime($startHour)->hours(20)->minutes(0)->toTimeString());
        }

        return response()->json($answer);
    }

    private function getTime($time): Carbon
    {
        return today()->setTimeFrom($time);
    }

    public function saveAppointment($key, $creator_id, $receiving_name, $date, $start_time, $location_id, $service_id)
    {
        if ($key != $this->key) {
            return 'Wrong pass';
        }

        $is_available = DB::table('appointments')
            ->whereDate('date', '=', Carbon::today()->setDateFrom($date))
            ->whereBetween('start_time', [$start_time, today()->setTimeFrom($start_time)->addMinutes(59)->toTimeString()]);

        if ($is_available->count() == 0) {

            Appointment::create([
                'referral' => true,
                'creator_id' => $creator_id,
                'implementer_id' => 1,
                'receiving_name' => $receiving_name,
                'receiving_description' => 'Создано с помощью чат бота',
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $this->getTime($start_time)->addMinutes(60)->toTimeString(),
                'location_id' => $location_id,
                'service_id' => $service_id,
                'total' => $this->serviceConverter($service_id)->price,
            ]);
//            $query = '/bot_create/save_appointment&key=1235&creator_id=9&receiving_name=Витек&date=2024-03-15&start_time=11:30:00&location_id=3&service_id=3';
            return response()->json('Успешно создано');
        }

        return response()->json('Кто-то уже создал в это время');
    }

    private function serviceConverter($serviceId): Service
    {
        foreach (Service::all() as $service) {
            if ($serviceId . '' == $service->id . '') {
                return $service;
            }
        }
        return $this->services->first();
    }
}
