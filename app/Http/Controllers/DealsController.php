<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.manage.deals.index');
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
        if ($request['deal_is_hidden'] || $request['deal_is_hidden'] == 'true') {
            $request['deal_is_hidden'] = true;
        } else {
            $request['deal_is_hidden'] = false;
        }

        $request->validate([
            'deal_name' => 'required|string|min:1|max:255',
            'deal_is_hidden' => 'boolean',
        ]);

        try {
            Deal::create([
                'name' => $request['deal_name'],
                'description' => $request['deal_description'],
                'discount' => $request['deal_discount'],
                'start_date' => $request['deal_start_date'],
                'end_date' => $request['deal_end_date'],
                'is_hidden' => $request['deal_is_hidden'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.deals')->with('errormsg', 'Deal not created.');
        }

        return redirect()->route('manage.deals')->with('success', 'Deal created successfully.');
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
        try {
            $deal = Deal::all()->where('id', $id)->first();
            $deal->status = false;
            $deal->save();
        } catch (Exception $e) {
            return redirect()->route('manage.deals')->with('errormsg', 'Deal not disabled.');
        }

        return redirect()->route('manage.deals')->with('success', 'Deal disabled successfully.');
    }
}
