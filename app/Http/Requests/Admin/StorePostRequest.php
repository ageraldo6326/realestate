<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo' => $this->normalizeString($this->input('titulo')),
            'contenido' => $this->normalizeString($this->input('contenido')),
            'metadescription' => $this->normalizeString($this->input('metadescription')),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:5', 'max:60'],
            'contenido' => ['required', 'string', 'min:30'],
            'metadescription' => ['required', 'string', 'min:20', 'max:320'],
            'foto' => ['nullable', 'image', 'max:5120'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    private function normalizeString($value): string
    {
        return trim((string) $value);
    }
}
