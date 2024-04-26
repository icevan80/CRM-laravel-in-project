<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all()->where('status', 1);

        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.services.index', compact('categories'));
        }
        return view('dashboard.manage-services.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.manage.services.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request['service_is_hidden'] || $request['service_is_hidden'] == 'true') {
            $request['service_is_hidden'] = true;
        } else {
            $request['service_is_hidden'] = false;
        }

        $request->validate([
            'service_name' => 'required|string|min:1|max:255',
//            'service_slug' => 'unique:services,slug,' . ($this->newService['id'] ?? ''),
            'service_description' => 'required|string|min:1|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_is_hidden' => 'boolean',
            'service_category_id' => 'required|integer|min:1|exists:categories,id',
            'service_allergens' => 'nullable|string|min:1|max:255',
            'service_cautions' => 'nullable|string|min:1|max:255',
            // duration should be increments of 15 minutes max 24 hours : )
//        'service_duration_minutes' => 'nullable|integer|min:15|max:1440|multiple_of:15',
            'service_benefits' => 'nullable|string|min:1|max:255',
            'service_aftercare_tips' => 'nullable|string|min:1|max:255',
            'service_notes' => 'nullable|string|min:1|max:255',
        ]);

        try {

            Service::create([
                'name' => $request['service_name'],
                'slug' => \Str::slug($request['service_name']),
                'description' => $request['service_description'],
                'image' => $request['service_image'],
                'price' => $request['service_price'],
                'notes' => $request['service_notes'],
                'allergens' => $request['service_allergens'],
                'benefits' => $request['service_benefits'],
                'aftercare_tips' => $request['service_aftercare_tips'],
                'cautions' => $request['service_cautions'],
//        'duration_minutes',
                'category_id' => $request['service_category_id'],
                'is_hidden' => $request['service_is_hidden'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.services')->with('errormsg', 'Service not created.');
        }

        return redirect()->route('manage.services')->with('success', 'Service created successfully.');
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
        $categories = Category::all();
        $service = Service::where('id', $id)->first();
        return view('dashboard.manage.services.index', compact('categories', 'id', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request['service_is_hidden'] || $request['service_is_hidden'] == 'true') {
            $request['service_is_hidden'] = true;
        } else {
            $request['service_is_hidden'] = false;
        }

        $request->validate([
            'service_name' => 'required|string|min:1|max:255',
//            'service_slug' => 'unique:services,slug,' . ($this->newService['id'] ?? ''),
            'service_description' => 'required|string|min:1|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_is_hidden' => 'boolean',
            'service_category_id' => 'required|integer|min:1|exists:categories,id',
            'service_allergens' => 'nullable|string|min:1|max:255',
            'service_cautions' => 'nullable|string|min:1|max:255',
            // duration should be increments of 15 minutes max 24 hours : )
//        'service_duration_minutes' => 'nullable|integer|min:15|max:1440|multiple_of:15',
            'service_benefits' => 'nullable|string|min:1|max:255',
            'service_aftercare_tips' => 'nullable|string|min:1|max:255',
            'service_notes' => 'nullable|string|min:1|max:255',
        ]);

        try {

            Service::where('id', $id)->first()->update([
                'name' => $request['service_name'],
                'slug' => \Str::slug($request['service_name']),
                'description' => $request['service_description'],
                'image' => $request['service_image'],
                'price' => $request['service_price'],
                'notes' => $request['service_notes'],
                'allergens' => $request['service_allergens'],
                'benefits' => $request['service_benefits'],
                'aftercare_tips' => $request['service_aftercare_tips'],
                'cautions' => $request['service_cautions'],
//        'duration_minutes',
                'category_id' => $request['service_category_id'],
                'is_hidden' => $request['service_is_hidden'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.services')->with('errormsg', 'Service not updated.');
        }

        return redirect()->route('manage.services')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
