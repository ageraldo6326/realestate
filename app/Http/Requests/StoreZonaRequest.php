<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreZonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'zona' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('zonas', 'zona'),
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'zona' => 'nombre de zona',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'zona.required' => 'El nombre de la zona es obligatorio.',
            'zona.min' => 'El nombre debe tener al menos 2 caracteres.',
            'zona.max' => 'El nombre no puede exceder 50 caracteres.',
            'zona.unique' => 'Esta zona ya existe en el sistema.',
        ];
    }
}
