<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) optional($this->user())->can('access-admin');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'telefono' => $this->normalize($this->input('telefono')),
            'descripcion' => $this->normalize($this->input('descripcion')),
            'metadescription' => $this->normalize($this->input('metadescription')),
            'titulo' => $this->normalize($this->input('titulo')),
            'facebook' => $this->normalize($this->input('facebook')),
            'instagram' => $this->normalize($this->input('instagram')),
            'whatsapp' => $this->normalize($this->input('whatsapp')),
            'tiktok' => $this->normalize($this->input('tiktok')),
            'estado' => $this->has('estado') ? 1 : 0,
            'rol' => $this->input('rol'),
            'mostrar' => $this->input('mostrar'),
            'orden' => $this->input('orden'),
            'new_password' => $this->normalizePassword($this->input('new_password')),
            'new_password_confirmation' => $this->normalizePassword($this->input('new_password_confirmation')),
        ]);
    }

    public function rules(): array
    {
        return [
            'telefono' => ['required', 'string', 'min:7', 'max:255', 'regex:/.*\S.*/'],
            'descripcion' => ['nullable', 'string', 'max:10000'],
            'metadescription' => ['nullable', 'string', 'max:160'],
            'titulo' => ['nullable', 'string', 'max:60'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'rol' => ['required', Rule::in([0, 1, '0', '1'])],
            'mostrar' => ['required', Rule::in([0, 1, '0', '1'])],
            'orden' => ['nullable', 'integer', 'between:0,9999'],
            'modo_aprobacion_propiedades' => ['nullable', Rule::in(['system', 'required', 'skip'])],
            'estado' => ['nullable', 'boolean'],
            'new_password' => ['nullable', 'string', 'min:8', 'max:72', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'new_password_confirmation' => ['nullable', 'string'],
            'fotourl' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.regex' => 'La clave debe incluir mayusculas, minusculas y al menos un numero.',
            'new_password.confirmed' => 'La confirmacion de clave no coincide.',
        ];
    }

    private function normalize($value): ?string
    {
        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }

    private function normalizePassword($value): ?string
    {
        $password = (string) $value;

        return $password === '' ? null : $password;
    }
}
