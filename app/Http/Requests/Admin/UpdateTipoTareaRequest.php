<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoTareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) optional($this->user())->can('access-admin');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'todo_tipo' => $this->normalize($this->input('todo_tipo')),
            'color' => strtolower(trim((string) $this->input('color', ''))),
        ]);
    }

    public function rules(): array
    {
        $routeValue = $this->route('tipostarea')
            ?? $this->route('tipostareas')
            ?? $this->route('tipotarea')
            ?? $this->route('id');

        $tipoTareaId = is_object($routeValue)
            ? (int) ($routeValue->id ?? 0)
            : (int) $routeValue;

        return [
            'todo_tipo' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('to_do_tipos', 'todo_tipo')->ignore($tipoTareaId),
            ],
            'color' => [
                'required',
                'regex:/^#[0-9a-fA-F]{6}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'todo_tipo.required' => 'El tipo de tarea es obligatorio.',
            'todo_tipo.min' => 'El tipo de tarea debe tener al menos 2 caracteres.',
            'todo_tipo.max' => 'El tipo de tarea no puede exceder 50 caracteres.',
            'todo_tipo.unique' => 'Ya existe un tipo de tarea con ese nombre.',
            'color.required' => 'El color es obligatorio.',
            'color.regex' => 'El color debe estar en formato hexadecimal valido (ej. #2563eb).',
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
