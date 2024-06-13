<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all()->where('status', 1);

        return view('dashboard.manage.subcategory.index', compact('categories'));
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
        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required|string|min:1|max:255',
            'subcategory_presentation_name' => 'nullable|string|min:1|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->route('manage.categories')->with('errormsg', 'Validation failed.');
        }

        if ($request['subcategory_presentation_name']) {
            $request['subcategory_presentation_name'] = null;
        }

        try {
            Subcategory::create([
                'name' => $request['subcategory_name'],
                'presentation_name' => $request['subcategory_presentation_name'],
                'category_id' => $request['category_id'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.subcategories')->with('errormsg', 'Subcategory  not created.');
        }

        return redirect()->route('manage.subcategories')->with('success', 'Subcategory created successfully.');
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
        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required|string|min:1|max:255',
            'subcategory_presentation_name' => 'nullable|string|min:1|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->route('manage.categories')->with('errormsg', 'Validation failed.');
        }

        if ($request['subcategory_presentation_name']) {
            $request['subcategory_presentation_name'] = null;
        }

        try {
            $subcategory = Subcategory::all()->where('id', $id)->first();

            $subcategory->update([
                'name' => $request['subcategory_name'],
                'presentation_name' => $request['subcategory_presentation_name'],
                'category_id' => $request['category_id'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.subcategories')->with('errormsg', 'Subcategory  not updated.');
        }

        return redirect()->route('manage.subcategories')->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subcategory = Subcategory::all()->where('id', $id)->first();
            $subcategory->status = false;
            $subcategory->save();
        } catch (Exception $e) {
            return redirect()->route('manage.categories')->with('errormsg', 'Subcategory not disabled.');
        }

        return redirect()->route('manage.categories')->with('success', 'Subcategory disabled successfully.');
    }
}
