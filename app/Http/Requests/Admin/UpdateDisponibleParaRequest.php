<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDisponibleParaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) optional($this->user())->hasAnyRole(['admin', 'superadmin']);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'disponible_para' => $this->normalize($this->input('disponible_para')),
        ]);
    }

    public function rules(): array
    {
        $routeValue = $this->route('disponibleparum')
            ?? $this->route('disponiblepara')
            ?? $this->route('id');

        $disponibleParaId = is_object($routeValue)
            ? (int) ($routeValue->id ?? 0)
            : (int) $routeValue;

        return [
            'disponible_para' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('disponible_paras', 'disponible_para')->ignore($disponibleParaId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'disponible_para.required' => 'El campo disponible para es obligatorio.',
            'disponible_para.min' => 'Debe tener al menos 2 caracteres.',
            'disponible_para.max' => 'No puede exceder 50 caracteres.',
            'disponible_para.unique' => 'Ya existe un registro con ese valor.',
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
