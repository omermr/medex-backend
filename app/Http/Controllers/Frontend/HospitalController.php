<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\HospitalResource;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $hospitals = Hospital::orderByDistance($latitude, $longitude)
            ->with('user')
            ->get();

        return $this->success([
            'hospitals' => HospitalResource::collection($hospitals)
        ], 'Hospitals fetched successfully');
    }
}
