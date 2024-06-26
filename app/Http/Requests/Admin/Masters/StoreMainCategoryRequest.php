<?php

namespace App\Http\Requests\Admin\Masters;

use Illuminate\Foundation\Http\FormRequest;

class StoreMainCategoryRequest extends FormRequest
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
            'main_category_name' => 'required',
            'initial' => 'required',
            'type' => 'required',
            'interpretation' => 'required',
            'lab_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'lab_id.required' => 'Please Select Lab'
        ];
    }
}
