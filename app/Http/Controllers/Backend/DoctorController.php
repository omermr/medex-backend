<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Doctor\StoreDoctorRequest;
use App\Http\Requests\Backend\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private DoctorService $doctorService;
    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        return $this->doctorService->getAllDoctors();
    }

    public function show(Doctor $doctor)
    {
        return $this->doctorService->getDoctorById($doctor);
    }

    public function store(StoreDoctorRequest $request)
    {
        return $this->doctorService->createDoctor($request->validated());
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        return $this->doctorService->updateDoctor($doctor, $request->validated());
    }

    public function destroy(Doctor $doctor)
    {
        return $this->doctorService->deleteDoctor($doctor);
    }

    public function activation(Doctor $doctor, $status)
    {
        return $this->doctorService->activation($doctor, $status);
    }
}
