<?php

namespace App\Services;

use App\Models\Doctor;
use App\Http\Resources\Backend\Doctor\DoctorResource;
class DoctorService extends BaseService
{
    public function getAllDoctors()
    {
        return $this->success( ['doctors' => DoctorResource::collection(Doctor::all()), 'isSuccess' => true], 'Doctors fetched successfully' );
    }

    public function getDoctorById(Doctor $doctor)
    {
        return $this->success( ['doctor' => new DoctorResource($doctor->load('user')), 'isSuccess' => true], 'Doctor fetched successfully' );
    }

    public function createDoctor(array $data)
    {
        return $this->success( ['doctor' => new DoctorResource(Doctor::create($data)), 'isSuccess' => true], 'Doctor created successfully' );
    }

    public function updateDoctor(Doctor $doctor, array $data)
    {
        return $this->success( ['doctor' => new DoctorResource($doctor->update($data)), 'isSuccess' => true], 'Doctor updated successfully' );
    }

    public function deleteDoctor(Doctor $doctor)
    {
        $doctor->deleteFile($doctor->cover);
        $doctor->delete();
        return $this->success( ['doctor' => new \stdClass(), 'isSuccess' => true], 'Doctor deleted successfully' );
    }
    public function activation(Doctor $doctor, $status)
    {
        if ($status == 'active') {
            $doctor->update(['status' => Doctor::ACTIVE]);
        } else {
            $doctor->update(['status' => Doctor::INACTIVE]);
        }

        return $this->success(['doctor' => new DoctorResource($doctor->refresh()->load('user')), 'isSuccess' => true], 'Doctor activation updated successfully');
    }
}
