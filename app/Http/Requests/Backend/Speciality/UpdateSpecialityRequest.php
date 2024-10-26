<?php

namespace App\Http\Requests\Backend\Speciality;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecialityRequest extends FormRequest
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
            'name'          => ['sometimes', 'string', 'max:255', Rule::unique('specialities', 'name')->ignore($this->speciality->id)],
            'description'   => ['sometimes', 'string'],
            'cover'         => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique'           => 'The name field must be unique',
            'name.string'           => 'The name field must be a string',
            'name.max'              => 'The name field must be less than 255 characters',

            'description.string'    => 'The description field must be a string',

            'cover.image'           => 'The cover field must be an image',
            'cover.mimes'           => 'The cover field must be a file of type: jpeg, png, jpg, gif, svg',
        ];
    }
}
