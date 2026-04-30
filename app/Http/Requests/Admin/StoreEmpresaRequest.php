<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) optional($this->user())->hasAnyRole(['admin', 'superadmin']);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->normalizeText($this->input('nombre')),
            'correo' => $this->normalizeText($this->input('correo')),
            'direccion' => $this->normalizeText($this->input('direccion')),
            'telefono' => $this->normalizeText($this->input('telefono')),
            'titulo' => $this->normalizeText($this->input('titulo')),
            'metadescription' => $this->normalizeText($this->input('metadescription')),
            'facebook' => $this->normalizeText($this->input('facebook')),
            'instagram' => $this->normalizeText($this->input('instagram')),
            'tiktok' => $this->normalizeText($this->input('tiktok')),
            'whatsapp' => $this->normalizeText($this->input('whatsapp')),
            'quienessomos' => $this->normalizeTextarea($this->input('quienessomos')),
            'theme_color_primary' => $this->normalizeHex($this->input('theme_color_primary')),
            'theme_color_secondary' => $this->normalizeHex($this->input('theme_color_secondary')),
            'theme_color_accent' => $this->normalizeHex($this->input('theme_color_accent')),
            'theme_color_neutral' => $this->normalizeHex($this->input('theme_color_neutral')),
            'theme_logo_behavior' => $this->input('theme_logo_behavior', 'apply_logo_palette'),
            'aprobacion' => $this->normalizeBoolean($this->input('aprobacion')),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', 'max:255'],
            'direccion' => ['required', 'string'],
            'titulo' => ['nullable', 'string', 'max:255'],
            'metadescription' => ['nullable', 'string', 'max:500'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'quienessomos' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,ico', 'max:2048'],
            'theme_color_primary' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'theme_color_secondary' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'theme_color_accent' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'theme_color_neutral' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'theme_logo_behavior' => ['nullable', 'in:keep_current,apply_logo_palette'],
            'aprobacion' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.mimes' => 'El logo debe estar en formato jpg, jpeg, png o webp.',
            'favicon.mimes' => 'El favicon debe estar en formato jpg, jpeg, png, webp o ico.',
            'theme_color_primary.regex' => 'El color primario debe estar en formato hexadecimal valido.',
            'theme_color_secondary.regex' => 'El color secundario debe estar en formato hexadecimal valido.',
            'theme_color_accent.regex' => 'El color de acento debe estar en formato hexadecimal valido.',
            'theme_color_neutral.regex' => 'El color neutro debe estar en formato hexadecimal valido.',
        ];
    }

    private function normalizeText($value): ?string
    {
        $normalized = preg_replace('/\s+/u', ' ', trim((string) $value));

        if (!is_string($normalized)) {
            return null;
        }

        return $normalized === '' ? null : $normalized;
    }

    private function normalizeTextarea($value): ?string
    {
        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }

    private function normalizeHex($value): ?string
    {
        $normalized = strtolower(trim((string) $value));

        return $normalized === '' ? null : $normalized;
    }

    private function normalizeBoolean($value): ?bool
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
