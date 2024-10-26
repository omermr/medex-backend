<?php

namespace App\Http\Requests\Backend\Speciality;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecialityRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255', 'unique:specialities,name'],
            'description'   => ['sometimes', 'string'],
            'cover'         => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'The name field is required',
            'name.unique'           => 'The name field must be unique',
            'name.string'           => 'The name field must be a string',
            'name.max'              => 'The name field must be less than 255 characters',

            'description.string'    => 'The description field must be a string',

            'cover.required'        => 'The cover field is required',
            'cover.image'           => 'The cover field must be an image',
            'cover.mimes'           => 'The cover field must be a file of type: jpeg, png, jpg, gif, svg',
        ];
    }
}
