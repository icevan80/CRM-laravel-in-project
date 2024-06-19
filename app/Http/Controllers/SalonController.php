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
    public function updateScheme(Request $request)
    {
        $scheme = $request->all();
        unset($scheme['_token']);
        unset($scheme['_method']);
        foreach ($scheme as $key => $color) {

            $str = $color;
            if (str_starts_with($color, 'rgb(')) {
                $str = str_replace('rgb(', '', $color);
                $str = str_replace(')', '', $str);
                $str = str_replace(',', '', $str);
            } else if (str_starts_with($color, '#')) {
                $str = '';
                foreach (sscanf($color, "#%02x%02x%02x") as $code) {
                    $str .= $code . ' ';
                }
                $str = rtrim($str, " ");
            }
            $arr = explode(' ', $str);
//            dd($this->rgbToHsl($arr[0], $arr[1], $arr[2]));
            $arr = rgbToHsl($arr);
            $scheme[$key] = array('h' => $arr[0], 's' => $arr[1], 'l' => $arr[2]);
        }
        $jsonString = utf8_encode(json_encode($scheme, JSON_PRETTY_PRINT));
        $fp = fopen(resource_path('/settings/scheme/' . config('constants.store_uuid') . '.json'), 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        $settings = getStore();
        $settings->color_scheme = json_encode($scheme);
        $settings->save();
        return redirect()->back();
    }

    public function updateFonts(Request $request)
    {
        $fonts = $request->all();
        unset($fonts['_token']);
        unset($fonts['_method']);
        $jsonString = utf8_encode(json_encode($fonts, JSON_PRETTY_PRINT));
        $fp = fopen(resource_path('/settings/fonts/' . config('constants.store_uuid') . '.json'), 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        $settings = getStore();
        $settings->font_theme = json_encode($fonts);
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

    public function fillBD()
    {

    }
}
