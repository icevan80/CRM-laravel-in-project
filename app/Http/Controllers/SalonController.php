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
        $scheme = $request->all();
        unset($scheme['_token']);
        unset($scheme['_method']);
        $jsonString = utf8_encode(json_encode($scheme, JSON_PRETTY_PRINT));
        $fp = fopen(resource_path('/settings/default.json'), 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        $settings = getStore();
        $settings->color_scheme = json_encode($scheme);
        $settings->save();
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
