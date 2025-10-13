<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $cities = City::where('active', true)->get();
            return response()->json(['data' => $cities]);
        }

        $cities = City::paginate(20);
        return view('admin.cities.index', compact('cities'));
    }
}
