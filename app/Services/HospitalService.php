<?php

namespace App\Services;

use App\Http\Resources\Backend\HospitalResource;
use App\Models\Hospital;
use App\Models\User;

class HospitalService extends BaseService
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllHospitals()
    {
        return $this->success(['hospitals' => HospitalResource::collection(Hospital::with('user')->get()), 'isSuccess' => true], 'Hospitals fetched successfully');
    }

    public function getHospitalById(Hospital $hospital)
    {
        return $this->success(['hospital' => new HospitalResource($hospital->load('user')), 'isSuccess' => true], 'Hospital fetched successfully');
    }

    public function createHospital(array $data)
    {
        $userResponse = json_decode($this->userService->create($data, User::HOSPITAL)->getContent(), true);

        if (!isset($userResponse['data']['isSuccess']) || empty($userResponse['data']['user']['id'])) {
            return $this->error(['isSuccess' => false], 'User creation failed', 422);
        }

        if (isset($data['cover']) && is_file($data['cover'])) {
            $data['cover'] = $this->uploadFile($data['cover'], 'hospitals');
        }

        $data['user_id'] = $userResponse['data']['user']['id'];

        return $this->success(['hospital' => new HospitalResource(Hospital::create($data)->load('user')), 'isSuccess' => true], 'Hospital created successfully');
    }

    public function updateHospital(Hospital $hospital, array $data)
    {
        $userResponse = json_decode($this->userService->updateUserProfile($data, $hospital->user_id)->getContent(), true);
        logger($userResponse);
        if (!isset($userResponse['data']['isSuccess'])) {
            return $this->error(['isSuccess' => false], 'User update failed', 422);
        }

        if (isset($data['cover']) && is_file($data['cover'])) {
            $data['cover'] = $this->uploadFile($data['cover'], 'hospitals');
        }
        $hospital->update($data);
        return $this->success(['hospital' => new HospitalResource($hospital->refresh()->load('user')), 'isSuccess' => true], 'Hospital updated successfully');
    }

    public function deleteHospital(Hospital $hospital)
    {
        return $this->success(['isSuccess' => $hospital->delete()], 'Hospital deleted successfully');
    }

    public function activation(Hospital $hospital, $status)
    {
        if ($status == 'active') {
            $hospital->update(['status' => Hospital::ACTIVE]);
        } else {
            $hospital->update(['status' => Hospital::INACTIVE]);
        }

        return $this->success(['hospital' => new HospitalResource($hospital->refresh()->load('user')), 'isSuccess' => true], 'Hospital activation updated successfully');
    }
}
