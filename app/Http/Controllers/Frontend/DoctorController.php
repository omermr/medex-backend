<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Doctor\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return $this->success( ['doctors' => DoctorResource::collection(Doctor::all()), 'isSuccess' => true], 'Doctors fetched successfully' );
    }

    public function show(Doctor $doctor)
    {
        return $this->success( ['doctor' => new DoctorResource($doctor->load('user')), 'isSuccess' => true], 'Doctor fetched successfully' );
    }
}
