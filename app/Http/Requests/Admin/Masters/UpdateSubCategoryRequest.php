<?php

namespace App\Http\Requests\Admin\Masters;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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
            'sub_category_name' => 'required',
            'units' => 'nullable',
            'interval_type' => 'required',
            'bioreferal' => 'required_if:interval_type,2',
            'from_range' => 'required_if:interval_type,1',
            'to_range' => 'required_if:interval_type,1',
            'main_category' => 'required',
            'method' => 'required',
        ];
    }
}
