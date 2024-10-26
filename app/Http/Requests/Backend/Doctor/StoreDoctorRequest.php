<?php

namespace App\Http\Requests\Backend\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'speciality_id' => ['required', 'exists:specialities,id'],
            'bio'           => ['required', 'string'],
            'experience'    => ['required', 'integer'],
            'description'   => ['required', 'string'],
            'cover'         => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'status'        => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'           => 'The status field is required.',
            'status.boolean'            => 'The status field must be a boolean.',

            'cover.required'            => 'The cover field is required.',
            'cover.image'               => 'The cover field must be an image.',
            'cover.mimes'               => 'The cover field must be an image with the following extensions: jpeg, png, jpg, gif, svg.',

            'speciality_id.required'    => 'The speciality field is required.',
            'speciality_id.exists'      => 'The speciality field must be an existing speciality.',

            'bio.required'              => 'The bio field is required.',
            'bio.string'                => 'The bio field must be a string.',

            'experience.required'       => 'The experience field is required.',
            'experience.integer'        => 'The experience field must be an integer.',

            'description.required'      => 'The description field is required.',
            'description.string'        => 'The description field must be a string.',

            'name.required'             => 'The name field is required.',
            'name.string'               => 'The name field must be a string.',
            'name.max'                  => 'The name field must be less than 255 characters.',
        ];
    }
}
