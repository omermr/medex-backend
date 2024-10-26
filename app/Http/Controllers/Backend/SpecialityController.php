<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Speciality\StoreSpecialityRequest;
use App\Http\Requests\Backend\Speciality\UpdateSpecialityRequest;
use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Services\SpecialityService;

class SpecialityController extends Controller
{
    protected $specialityService;

    public function __construct(SpecialityService $specialityService)
    {
        $this->specialityService = $specialityService;
    }

    public function index()
    {
        return $this->specialityService->getAllSpecialities();
    }

    public function show(Speciality $speciality)
    {
        return $this->specialityService->getSpecialityById($speciality);
    }

    public function store(StoreSpecialityRequest $request)
    {
        return $this->specialityService->createSpeciality($request->validated());
    }

    public function update(UpdateSpecialityRequest $request, Speciality $speciality)
    {
        return $this->specialityService->updateSpeciality($speciality, $request->validated());
    }

    public function destroy(Speciality $speciality)
    {
        return $this->specialityService->deleteSpeciality($speciality);
    }
}
