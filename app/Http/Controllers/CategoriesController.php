<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.categories.index');
        }
        return view('dashboard.manage-categories.index.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|min:1|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->route('manage.categories')->with('errormsg', 'Validation failed.');
        }

        try {

            Category::create([
                'name' => $request['category_name'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('manage.categories')->with('errormsg', 'Category  not created.');
        }

        return redirect()->route('manage.categories')->with('success', 'Category created successfully.');
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
            'category_name' => 'required|string|min:1|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->route('manage.categories')->with('errormsg', 'Validation failed.');
        }

        try {
            $category = Category::all()->where('id', $id)->first();
            $category->name = $request['category_name'];
            $category->save();
        } catch (Exception $e) {
            return redirect()->route('manage.categories')->with('errormsg', 'Category not updated.');
        }

        return redirect()->route('manage.categories')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $category = Category::all()->where('id', $id)->first();
            $category->status = false;
            $category->save();
        } catch (Exception $e) {
            return redirect()->route('manage.categories')->with('errormsg', 'Category not disabled.');
        }

        return redirect()->route('manage.categories')->with('success', 'Category disabled successfully.');
    }
}
