<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.locations.index');
        }
        return view('dashboard.manage-locations.index.index');
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
        if ($request['location_operate'] || $request['location_operate'] == 'true') {
            $request['location_operate'] = true;
        } else {
            $request['location_operate'] = false;
        }

        $request->validate([
            "location_name" => "required|string|max:255",
            "location_address" => "required|string|max:255",
            "location_telephone_number" => "required|string|min_digits:10|max_digits:10",
            "location_operate" => "required|boolean",
        ]);

        try {

            Location::create([
                'name' => $request['location_name'],
                'address' => $request['location_address'],
                'telephone_number' => $request['location_telephone_number'],
                'operate' => $request['location_operate'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.locations')->with('errormsg', 'Location  not created.');
        }

        return redirect()->route('manage.locations')->with('success', 'Location created successfully.');
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
        if ($request['location_operate']) {
            $request['location_operate'] = true;
        } else {
            $request['location_operate'] = false;
        }

        $request->validate([
            "location_name" => "required|string|max:255",
            "location_address" => "required|string|max:255",
            "location_telephone_number" => "required|string|min_digits:10|max_digits:10",
            "location_operate" => "required|boolean",
        ]);

        try {

            $location = Location::all()->where('id', $id)->first();
            $location->update([
                'name' => $request['location_name'],
                'address' => $request['location_address'],
                'telephone_number' => $request['location_telephone_number'],
                'operate' => $request['location_operate'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.locations')->with('errormsg', 'Location  not created.');
        }

        return redirect()->route('manage.locations')->with('success', 'Location created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $location = Location::all()->where('id', $id)->first();
            $location->update([
                'operate' => false,
                'status' => false,
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.locations')->with('errormsg', 'Location not disabled.');
        }

        return redirect()->route('manage.locations')->with('success', 'Location disabled successfully.');
    }
}
