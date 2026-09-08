<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateZonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) optional($this->user())->can('access-admin');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'zona' => $this->normalize($this->input('zona')),
        ]);
    }

    public function rules(): array
    {
        $routeZona = $this->route('zona');
        $zonaId = is_object($routeZona) ? (int) $routeZona->id : (int) $routeZona;

        return [
            'zona' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('zonas', 'zona')->ignore($zonaId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'zona.required' => 'La zona es obligatoria.',
            'zona.min' => 'La zona debe tener al menos 2 caracteres.',
            'zona.max' => 'La zona no puede exceder 50 caracteres.',
            'zona.unique' => 'Ya existe una zona con ese nombre.',
        ];
    }

    private function normalize($value): ?string
    {
        $normalized = preg_replace('/\s+/u', ' ', trim((string) $value));

        if (!is_string($normalized)) {
            return null;
        }

        return $normalized === '' ? null : $normalized;
    }
}
