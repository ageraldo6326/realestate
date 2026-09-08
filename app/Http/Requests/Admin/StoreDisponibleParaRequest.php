<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDisponibleParaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) optional($this->user())->can('access-admin');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'disponible_para' => $this->normalize($this->input('disponible_para')),
        ]);
    }

    public function rules(): array
    {
        return [
            'disponible_para' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('disponible_paras', 'disponible_para'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'disponible_para.required' => 'El campo disponible para es obligatorio.',
            'disponible_para.min' => 'Debe tener al menos 2 caracteres.',
            'disponible_para.max' => 'No puede exceder 50 caracteres.',
            'disponible_para.unique' => 'Ese valor ya existe en el catalogo.',
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
