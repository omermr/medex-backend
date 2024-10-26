<?php

namespace App\Services;

use App\Http\Requests\Backend\Speciality\StoreSpecialityRequest;
use App\Http\Resources\Backend\SpecialityResource;
use App\Models\Speciality;

class SpecialityService extends BaseService
{
    public function getAllSpecialities()
    {
        return $this->success(['specialities' => SpecialityResource::collection(Speciality::all()), 'isSuccess' => true], 'Specialities fetched successfully');
    }

    public function getSpecialityById(Speciality $speciality)
    {
        return $this->success(['speciality' => new SpecialityResource($speciality), 'isSuccess' => true], 'Speciality fetched successfully');
    }

    public function createSpeciality($data)
    {
        if(isset($data['cover'])) {
            $data['cover'] = $this->uploadFile($data['cover'], 'specialities');
        }

        return $this->success(['speciality' => new SpecialityResource(Speciality::create($data)), 'isSuccess' => true], 'Speciality created successfully');
    }

    public function updateSpeciality(Speciality $speciality, array $data)
    {
        if(isset($data['cover'])) {
            $data['cover'] = $this->uploadFile($data['cover'], 'specialities');
        }

        $speciality->update($data);

        return $this->success(['speciality' => new SpecialityResource($speciality->refresh()), 'isSuccess' => true], 'Speciality updated successfully');
    }

    public function deleteSpeciality(Speciality $speciality)
    {
        $this->deleteFile($speciality->cover);
        $speciality->delete();
        return $this->success(['speciality' => new \stdClass(), 'isSuccess' => true], 'Speciality deleted successfully');
    }
}
