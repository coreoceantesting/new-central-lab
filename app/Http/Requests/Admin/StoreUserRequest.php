<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'role' => 'required',
            'lab' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'health_post_id' => 'nullable',
            'name' => 'nullable',
            'email' => 'required|unique:users,email|email',
            'mobile' => 'required|unique:users,mobile|digits:10',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }
}
