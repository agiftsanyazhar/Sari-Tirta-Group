<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'preferred_timezone' => 'required|exists:users,preferred_timezone',
            'password' => 'required|string|min:8',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            '*.required' => 'The :attribute field is required.',
            '*.string' => 'The :attribute must be a string.',
            '*.max' => 'The :attribute must be at most :max characters.',
        ];
    }
}
