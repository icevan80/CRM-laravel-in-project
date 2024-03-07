<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BotAppointmentController extends Controller
{
    public function indexPost(Request $request)
    {

//        $value = $request['value'] != null ? $request['value'] : 1337.00;
//        $value = ($request != null) ? 123.00 : 321.00;
        Appointment::create([
            'creator_id' => 1,
            'receiving_id' => 1,
            'service_id' => 2,
            'date' => Carbon::now()->toDateString(),
            'start_time' => Carbon::now()->minutes(0)->toTimeString(),
            'end_time' => Carbon::now()->addMinutes(30)->toTimeString(),
            'location_id' => 1,
            'total' => 1340.00,
        ]);

//        return "{ 'status': 1 }";
    }

    public function indexGet()
    {
        Appointment::create([
            'creator_id' => 1,
            'receiving_id' => 1,
            'service_id' => 3,
            'date' => Carbon::now()->toDateString(),
            'start_time' => Carbon::now()->minutes(0)->toTimeString(),
            'end_time' => Carbon::now()->addMinutes(30)->toTimeString(),
            'location_id' => 1,
            'total' => 4321.00,
        ]);

//        return redirect()->route('botCreatePost');

        return response()->json([]);
    }
    public function getFreeSlots($day)
    {
        return response()->json([]);
    }

    public function getLocationsList()
    {
        return response()->json([]);
    }

    public function getServicesList()
    {
        return response()->json([]);
    }

}
