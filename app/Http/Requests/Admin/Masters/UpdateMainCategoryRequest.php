<?php

namespace App\Http\Requests\Admin\Masters;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMainCategoryRequest extends FormRequest
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
        $rules = [
            'main_category_name' => 'required',
            'initial' => 'required',
            'type' => 'required',
            'lab_id' => 'required',
        ];
    
        // Conditionally include 'interpretation' in validation if present in the request
        if ($this->getMethod() == 'POST' || $this->input('interpretation')) {
            $rules['interpretation'] = 'required';
        }
    
        return $rules;
    }

    public function messages()
    {
        return [
            'lab_id.required' => 'Please Select Lab'
        ];
    }
}
