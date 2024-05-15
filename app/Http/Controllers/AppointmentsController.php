<?php

namespace App\Http\Controllers;

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
        $services = Service::all()->where('status', 1);

        return view('dashboard.manage.appointments.index',
            compact('masters', 'locations', 'services'));

//        return view('dashboard.manage.appointments.index', compact('masters', 'locations', 'services'));
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
        //
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
