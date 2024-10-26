<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Speciality\SpecialityResource;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialitiyController extends Controller
{
    public function index()
    {
        return $this->success( ['specialities' => SpecialityResource::collection(Speciality::all()), 'isSuccess' => true], 'Specialities fetched successfully' );
    }

    public function show(Speciality $speciality)
    {
        return $this->success( ['speciality' => new SpecialityResource($speciality), 'isSuccess' => true], 'Speciality fetched successfully' );
    }
}
