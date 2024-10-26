<?php

namespace App\Http\Requests\Backend\Hospital;

use App\Models\Hospital;
use App\Models\User;
use App\Rules\EmailExistsWithType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHospitalRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'address'   => ['required', 'string'],
            'phone'     => ['required', 'string'],
            'email'     => [
                'required',
                'email',
                Rule::unique('users')->where('role', User::HOSPITAL)
            ],
            'type'      => ['required', Rule::in([Hospital::PUBLIC, Hospital::PRIVATE])],
            'lat'       => ['required', 'numeric', 'between:-90,90'],
            'lng'       => ['required', 'numeric', 'between:-180,180'],
            'cover'     => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'name.required'         => 'The hospital name is required.',
            'name.max'              => 'The hospital name may not exceed 255 characters.',

            'address.required'      => 'The hospital address is required.',

            'phone.required'        => 'The phone number is required.',
            'phone.numeric'         => 'The phone number must be a valid number.',
            'phone.digits_between'  => 'The phone number must be between 10 and 15 digits.',

            'email.required'        => 'The email address is required.',
            'email.email'           => 'The email must be a valid email address.',
            'email.unique'          => 'The email is already taken by another hospital.',

            'type.required'         => 'The hospital type is required.',
            'type.in'               => 'The hospital type must be either public or private.',

            'cover.required'        => 'The cover is required.',
            'cover.image'           => 'The cover must be an image.',
            'cover.mimes'           => 'The cover must be a valid image format.',

            'lat.required'          => 'The latitude is required.',
            'lat.numeric'           => 'The latitude must be a valid number.',
            'lat.between'           => 'The latitude must be between -90 and 90.',

            'lng.required'          => 'The longitude is required.',
            'lng.numeric'           => 'The longitude must be a valid number.',
            'lng.between'           => 'The longitude must be between -180 and 180.',
        ];
    }
}
