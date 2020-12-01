<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function detail()
    {
        $data = Setting::first();
        return view('settings', [
            'data' => $data
        ]);
    }

    public function edit(Request $request)
    {
        $setting = Setting::first();
        $setting->single_room_price = $request->single_room_price;
        $setting->room_price = $request->room_price;
        $setting->added_bed_price = $request->added_bed_price;
        $setting->has_animals_price = $request->has_animals_price;
        $setting->save();
        
        return redirect()->route('settings.detail');
    }
}
