<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'mob_no' => 'required|min:10|max:10',
            'aadhar_no' => 'nullable|min:12|max:12',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'nullable',
            'tests' => 'required|array',
            // 'lab' => 'required',
            'health_post_name' => 'nullable',
            'refering_doctor_name' => 'nullable',
            'date' => 'required',
        ];
    }
}
