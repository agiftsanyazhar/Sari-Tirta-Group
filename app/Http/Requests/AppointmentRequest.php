<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'creator_id' => 'required|integer',
            'receiver_id' => 'required|integer',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            '*.required' => 'The :attribute field is required.',
            '*.string' => 'The :attribute must be a string.',
            '*.max' => 'The :attribute must be at most :max characters.',
            '*.integer' => 'The :attribute must be an integer.',
            '*.date_format' => 'The :attribute must be in the format :format.',
        ];
    }
}
