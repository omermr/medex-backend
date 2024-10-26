<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Hospital\StoreHospitalRequest;
use App\Http\Requests\Backend\Hospital\UpdateHospitalRequest;
use App\Models\Hospital;
use App\Services\HospitalService;

class HospitalController extends Controller
{
    protected $hospitalService;

    public function __construct(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }

    public function index()
    {
        return $this->hospitalService->getAllHospitals();
    }

    public function show(Hospital $hospital)
    {
        return $this->hospitalService->getHospitalById($hospital);
    }

    public function store(StoreHospitalRequest $request)
    {
        return $this->hospitalService->createHospital($request->validated());
    }

    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        return $this->hospitalService->updateHospital($hospital, $request->validated());
    }

    public function destroy(Hospital $hospital)
    {
        return $this->hospitalService->deleteHospital($hospital);
    }

    public function activation(Hospital $hospital, $status)
    {
        return $this->hospitalService->activation($hospital, $status);
    }
}
