<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.salon.index');
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
    public function update(Request $request)
    {

        $jsonArray = array();
            $jsonArray['primary_color'] = $request['primary_color'];
            $jsonArray['secondary_color'] = $request['secondary_color'];
            $jsonArray['surface_color'] = $request['surface_color'];
        $jsonString = utf8_encode(json_encode($jsonArray, JSON_PRETTY_PRINT));
        $fp = fopen(resource_path('/settings/default.json'), 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
