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
            'seo_title' => $this->normalizeNullableString($this->input('seo_title')),
            'image_alt' => $this->normalizeNullableString($this->input('image_alt')),
            'image_credit' => $this->normalizeNullableString($this->input('image_credit')),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:5', 'max:60'],
            'contenido' => ['required', 'string', 'min:30'],
            'metadescription' => ['required', 'string', 'min:20', 'max:160'],
            'seo_title' => ['nullable', 'string', 'max:70'],
            'published_at' => ['nullable', 'date'],
            'image_alt' => ['nullable', 'string', 'max:160'],
            'image_credit' => ['nullable', 'string', 'max:160'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'activo' => ['nullable', 'boolean'],
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
