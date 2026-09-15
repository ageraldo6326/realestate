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
            'seo_h1' => $this->normalize($this->input('seo_h1')),
            'seo_title' => $this->normalize($this->input('seo_title')),
            'meta_description' => $this->normalize($this->input('meta_description')),
            'seo_description' => trim((string) $this->input('seo_description')) ?: null,
            'image_alt' => $this->normalize($this->input('image_alt')),
            'is_public' => $this->boolean('is_public'),
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
            'is_public' => ['nullable', 'boolean'],
            'seo_h1' => ['nullable', 'string', 'max:120'],
            'seo_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'seo_description' => ['nullable', 'string', 'max:10000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:160'],
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
