<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BotAppointmentController extends Controller
{
    public function index($request)
    {
        Appointment::create([
            'creator_id' => 1,
            'receiving_id' => 1,
            'service_id' => 1,
            'date' => Carbon::now()->toDateString(),
            'start_time' => Carbon::now()->minutes(0)->toTimeString(),
            'end_time' => Carbon::now()->addMinutes(30)->toTimeString(),
            'location_id' => 1,
            'total' => 1337.00,
        ]);

        return "{ 'status': 1 }";
    }

    public function indexGet()
    {
        Appointment::create([
            'creator_id' => 1,
            'receiving_id' => 1,
            'service_id' => 1,
            'date' => Carbon::now()->toDateString(),
            'start_time' => Carbon::now()->minutes(0)->toTimeString(),
            'end_time' => Carbon::now()->addMinutes(30)->toTimeString(),
            'location_id' => 1,
            'total' => 1337.00,
        ]);

        return "{ 'status': 1 }";
    }
}
