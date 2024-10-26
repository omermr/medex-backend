<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar'        => ['sometimes', 'file', 'mimes:png,jpg'],
            'gender'        => ['required', Rule::in([User::MALE, User::FEMALE])],
            'date_of_birth' => ['required', 'date'],
            'address'       => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            //Avatar Validation Messages
            'avatar.file'               => 'The profile picture must be a file',
            'avatar.mimes'              => 'The profile picture must be of type PNG or JPG',

            //Gender Validation Messages
            'gender.required'           => 'Gender field is required',
            'gender.in'                 => 'Gender must be one of Male or Female',

            //Date Of Birth Validation Messages
            'date_of_birth.required'    => 'Date Of Birth is required field',
            'date_of_birth.date'        => 'Date Of Birth must be valid date',

            //Address Validation Messages
            'address.required'          => 'Address field is required',
            'address.string'            => 'Address must be string'
        ];
    }
}
