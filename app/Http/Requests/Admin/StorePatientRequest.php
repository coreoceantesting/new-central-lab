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
            'patient_name' => 'required',
            'mob_no' => 'required|min:10|max:10',
            'aadhar_no' => 'required|min:12|max:12',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'tests' => 'required|array',
            'lab' => 'required',
            'refering_doctor_name' => 'required',
            'date' => 'required',
        ];
    }
}
