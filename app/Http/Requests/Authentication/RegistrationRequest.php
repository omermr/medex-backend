<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'email'         =>  ['required', 'email', 'unique:users,email'],
            'name'          =>  ['required', 'string', 'max:255'],
            'phone_number'  =>  ['required', 'string'],
            'password'      =>  ['required', 'string', 'max_digits:8']
        ];
    }

    public function messages(): array
    {
        return [

            //Email validation messages
            'email.required'        => 'Email field is required',
            'email.email'           => 'Email must be valid',

            //Name validation messages
            'name.required'         => 'Name field is required',
            'name.string'           => 'Name must be string',
            'name.max'              => 'Name field have a max length 255',

            //Phone number validation messages
            'phone_number.required' => 'Phone number is required field',
            'phone_number.string'   => 'Phone number must be string',

            //Password messages
            'password.required'     => 'Password is required',
            'password.string'       => 'Password must be string',
            'password.max_digits'   => 'Password with max digits 8'

        ];
    }
}
