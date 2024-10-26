<?php

namespace App\Http\Requests\Backend\Hospital;

use App\Models\Hospital;
use App\Models\User;
use App\Rules\UniqueTypeEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHospitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Adjust this as needed based on your authorization logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $user_id = $this->hospital->user_id;

        return [
            'name'        => 'sometimes|string|max:255',
            'address'     => 'sometimes|string',
            'phone'       => 'sometimes|numeric|digits_between:10,15',
            'email'       => [
                'sometimes',
                'email',
                new UniqueTypeEmail($user_id, User::HOSPITAL),
            ],
            'type'        => ['sometimes', Rule::in([Hospital::PUBLIC, Hospital::PRIVATE])],
            'cover'       => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'lat'         => 'sometimes|numeric|between:-90,90',
            'lng'         => 'sometimes|numeric|between:-180,180',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'name.max'              => 'The hospital name may not exceed 255 characters.',

            'phone.numeric'         => 'The phone number must be a valid number.',
            'phone.digits_between'  => 'The phone number must be between 10 and 15 digits.',

            'email.email'           => 'The email must be a valid email address.',
            'email.unique'          => 'The email is already taken by another hospital.',

            'type.in'               => 'The hospital type must be either public or private.',

            'cover.image'           => 'The cover must be an image.',
            'cover.mimes'           => 'The cover must be a valid image format.',

            'lat.between'           => 'The latitude must be between -90 and 90.',

            'lng.between'           => 'The longitude must be between -180 and 180.',
        ];
    }
}
