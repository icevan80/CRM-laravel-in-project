<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        if (auth()->user()->hasPermission('new_style_access')) {
            return view('dashboard.manage.categories.index', compact('categories'));
        }
        return view('dashboard.manage-categories.index.index');


        //
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
            return redirect()->route('settings.permissions')->with('errormsg', 'Permission not created.');
        }

        try {

            Permission::create([
                'name' => $request['permission_name'],
            ]);
        } catch (Exception $e) {
            return redirect()->route('settings.permissions')->with('errormsg', 'Permission not created.');
        }

        return redirect()->route('settings.permissions')->with('success', 'Permission created successfully.');
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
