<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Location;
use App\Models\Master;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masters = Master::all();
        $locations = Location::all()->where('status', 1);
        $appointments = Appointment::all()->where('status', 1);
        $services = Service::all()->where('status', 1);

        return view('dashboard.manage.appointments.index',
            compact('masters', 'locations', 'appointments', 'services'));

//        return view('dashboard.manage.appointments.index', compact('masters', 'locations', 'appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request['appointment_description'] == null) {
            $request['appointment_description'] = '';
        }

        $request->validate([
            'appointment_name' => 'required|string|min:1|max:255',
            'appointment_description' => 'nullable|string',
        ]);

        if ($this->masterSlotValidate(
            $request['appointment_date'],
            $request['appointment_start_time'],
            $request['appointment_end_time'],
            $request['appointment_implementer_id'])) {
            try {
                Appointment::create([
                    'creator_id' => $request['appointment_creator_id'],
                    'implementer_id' => $request['appointment_implementer_id'],
                    'receiving_name' => $request['appointment_name'],
                    'receiving_description' => $request['appointment_description'],
                    'date' => $request['appointment_date'],
                    'start_time' => $request['appointment_start_time'],
                    'end_time' => $request['appointment_end_time'],
                    'location_id' => $request['appointment_location_id'],
                    'service_id' => $request['appointment_service_id'],
                    'total' => $request['appointment_total'],
                ]);

                return redirect()->route('manage.appointments')->with('success', 'Appointment created successfully');

            } catch (\Exception $e) {
                return redirect()->route('manage.appointments')->with('errormsg', 'Appointment was not created');

            }
        }

//        dd($request);
        return redirect()->route('manage.appointments')->with('errormsg', 'Appointment was not created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.manage.appointments.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateImplementer(Request $request, string $id)
    {
        $appointment = Appointment::where('id', $id)->first();
        $appointment->implementer_id = $request['implementer_id'];
        $appointment->save();

        return redirect()->back();
    }

    public function cancel(string $id)
    {
        $appointment = Appointment::where('id', $id)->first();
        $appointment->complete = true;
        $appointment->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::where('id', $id)->first();
        $appointment->status = false;
        $appointment->save();
        return redirect()->back();
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
