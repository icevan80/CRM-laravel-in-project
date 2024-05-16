<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Location;
use App\Models\Master;
use App\Models\Service;
use Illuminate\Http\Request;

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
        dd($request);
        /*if ($request['appointment_is_hidden'] || $request['appointment_is_hidden'] == 'true') {
               $request['appointment_is_hidden'] = true;
           } else {
               $request['appointment_is_hidden'] = false;
           }

           $request['appointment_duration_minutes'] += $request['appointment_duration_hours'];
           if ($request['appointment_masters']) {
               $request['appointment_masters'] = array_values(array_unique($request['appointment_masters']));
           }

           $request->validate([
               'appointment_name' => 'required|string|min:1|max:255',
   //            'appointment_slug' => 'unique:appointments,slug,' . ($this->newAppointment['id'] ?? ''),
               'appointment_price' => 'required|numeric|min:0',
               'appointment_max_price' => 'nullable|numeric|min:0|gte:appointment_price',
               'appointment_category_id' => 'required|integer|min:1|exists:categories,id',
               'appointment_duration_minutes' => 'required|integer|min:15|max:1440|multiple_of:15',
               'appointment_notes' => 'nullable|string|min:1|max:255',
               'appointment_masters' => 'min:1',
               'appointment_is_hidden' => 'boolean',
           ]);

           if (!$request['appointment_max_price']) {
               $request['appointment_max_price'] = null;
           }

           try {

               $appointment = Appointment::create([
                   'name' => $request['appointment_name'],
                   'slug' => \Str::slug($request['appointment_name']),
                   'image' => $request['appointment_image'],
                   'price' => $request['appointment_price'],
                   'max_price' => $request['appointment_max_price'],
                   'notes' => $request['appointment_notes'],
                   'type' => $request['appointment_type'],
                   'duration_minutes' => $request['appointment_duration_minutes'],
                   'category_id' => $request['appointment_category_id'],
                   'is_hidden' => $request['appointment_is_hidden'],
               ]);
               $appointment->masters()->attach($request['appointment_masters']);
           } catch (Exception $e) {
               return redirect()->route('manage.appointments')->with('errormsg', 'Appointment not created.');
           }

           return redirect()->route('manage.appointments')->with('success', 'Appointment created successfully.');*/
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
