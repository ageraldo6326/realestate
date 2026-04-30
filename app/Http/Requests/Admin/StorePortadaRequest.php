<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePortadaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'minititulo' => $this->normalizeString($this->input('minititulo')),
            'titulo' => $this->normalizeString($this->input('titulo')),
            'descripcion' => $this->normalizeNullableString($this->input('descripcion')),
            'enlace1' => $this->normalizeNullableString($this->input('enlace1')),
            'url1' => $this->normalizeNullableString($this->input('url1')),
            'enlace2' => $this->normalizeNullableString($this->input('enlace2')),
            'url2' => $this->normalizeNullableString($this->input('url2')),
            'video' => $this->normalizeNullableString($this->input('video')),
        ]);
    }

    public function rules(): array
    {
        return [
            'minititulo' => ['required', 'string', 'min:2', 'max:100'],
            'titulo' => ['required', 'string', 'min:2', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'enlace1' => ['nullable', 'string', 'max:100'],
            'url1' => ['nullable', 'string', 'max:100'],
            'enlace2' => ['nullable', 'string', 'max:100'],
            'url2' => ['nullable', 'string', 'max:100'],
            'video' => ['nullable', 'string', 'max:100'],
            'foto' => ['required', 'image', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'foto.required' => 'Debes seleccionar una imagen para la portada.',
            'foto.image' => 'La portada debe ser un archivo de imagen valido.',
        ];
    }

    private function normalizeString($value): string
    {
        return trim((string) $value);
    }

    private function normalizeNullableString($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
