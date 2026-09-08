<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación centralizada para creación de usuarios.
 * Aplica sanitización de entrada, validación exhaustiva y reglas de negocio.
 */
class StoreUsuarioRequest extends FormRequest
{
    /**
     * Autorización: solo administradores pueden crear usuarios.
     */
    public function authorize(): bool
    {
        return (bool) optional($this->user())->can('access-admin');
    }

    /**
     * Normaliza entradas antes de validación.
     * - Trim automático en strings
     * - Email a minúsculas (case-insensitive)
     * - Conversión de boolean y integer
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->normalize($this->input('name')),
            'email' => mb_strtolower($this->normalize($this->input('email'))),
            'telefono' => $this->normalize($this->input('telefono')),
            'descripcion' => $this->normalize($this->input('descripcion')),
            'metadescription' => $this->normalize($this->input('metadescription')),
            'titulo' => $this->normalize($this->input('titulo')),
            'facebook' => $this->normalize($this->input('facebook')),
            'instagram' => $this->normalize($this->input('instagram')),
            'whatsapp' => $this->normalize($this->input('whatsapp')),
            'tiktok' => $this->normalize($this->input('tiktok')),
            'rol' => (int) ($this->input('rol') ?? 0),
            'mostrar' => (int) ($this->input('mostrar') ?? 1),
            'activo' => (int) ($this->input('activo') ?? 1),
            'orden' => $this->input('orden') === '' || $this->input('orden') === null ? null : (int) $this->input('orden'),
            'requiere_aprobacion_propiedades' => (int) ($this->input('requiere_aprobacion_propiedades') ?? 0),
        ]);
    }

    /**
     * Reglas de validación para creación de usuario.
     * Incluye: obligatorios, unicidad, formato, rango, seguridad.
     */
    public function rules(): array
    {
        return [
            // Datos personales (requeridos)
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/.*\S.*/i', // No solo espacios
            ],
            'email' => [
                'required',
                'string',
                'email:rfc',
                'max:255',
                // Unique ignoring soft-deleted users
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'telefono' => [
                'required',
                'string',
                'min:7',
                'max:255',
                'regex:/.*\S.*/i', // No solo espacios
            ],

            // Descripción (requerida para consistencia)
            'descripcion' => [
                'required',
                'string',
                'min:10',
                'max:10000',
            ],

            // Metadata SEO (opcional)
            'metadescription' => [
                'nullable',
                'string',
                'max:160',
            ],
            'titulo' => [
                'nullable',
                'string',
                'max:60',
            ],

            // Redes sociales (opcional)
            'facebook' => [
                'nullable',
                'string',
                'max:255',
            ],
            'instagram' => [
                'nullable',
                'string',
                'max:255',
            ],
            'whatsapp' => [
                'nullable',
                'string',
                'max:255',
            ],
            'tiktok' => [
                'nullable',
                'string',
                'max:255',
            ],

            // Rol y visibilidad (enums)
            'rol' => [
                'required',
                Rule::in([0, 1]),
            ],
            'mostrar' => [
                'required',
                Rule::in([0, 1]),
            ],
            'activo' => [
                'required',
                Rule::in([0, 1]),
            ],

            // Orden de listado (opcional)
            'orden' => [
                'nullable',
                'integer',
                'between:0,9999',
            ],

            // Aprobación de propiedades (enum)
            'requiere_aprobacion_propiedades' => [
                'required',
                Rule::in([0, 1]),
            ],

            // Contraseña (requerida en creación, must be strong)
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:72',
                // Regex: al menos 1 mayúscula, 1 minúscula, 1 dígito
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed',
            ],
            'new_password_confirmation' => [
                'required',
                'string',
            ],

            // Foto (opcional, solo formatos seguros)
            'fotourl' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096', // 4 MB
                'dimensions:min_width=300,min_height=300',
            ],
        ];
    }

    /**
     * Mensajes de validación personalizados y amigables.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.regex' => 'El nombre no puede contener solo espacios.',
            
            'email.required' => 'El correo es requerido.',
            'email.email' => 'El correo debe ser válido (ej: user@domain.com).',
            'email.unique' => 'Este correo ya está registrado en la base de datos.',
            
            'telefono.required' => 'El teléfono es requerido.',
            'telefono.min' => 'El teléfono debe tener al menos 7 caracteres.',
            'telefono.regex' => 'El teléfono no puede contener solo espacios.',
            
            'descripcion.required' => 'La descripción es requerida.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            
            'metadescription.max' => 'La meta descripción no puede exceder 160 caracteres.',
            'titulo.max' => 'El título no puede exceder 60 caracteres.',
            
            'rol.required' => 'El rol es requerido.',
            'rol.in' => 'El rol debe ser Asesor (0) o Administrador (1).',
            
            'mostrar.required' => 'La visibilidad es requerida.',
            'mostrar.in' => 'La visibilidad debe ser Mostrar (1) o No mostrar (0).',
            
            'activo.required' => 'El estado es requerido.',
            'activo.in' => 'El estado debe ser Activo (1) o Inactivo (0).',
            
            'orden.integer' => 'El orden debe ser un número entero.',
            'orden.between' => 'El orden debe estar entre 0 y 9999.',
            
            'new_password.required' => 'La clave es requerida.',
            'new_password.min' => 'La clave debe tener al mínimo 8 caracteres.',
            'new_password.max' => 'La clave no puede exceder 72 caracteres.',
            'new_password.regex' => 'La clave debe incluir mayúsculas, minúsculas y al menos un número.',
            'new_password.confirmed' => 'La confirmación de clave no coincide.',
            'new_password_confirmation.required' => 'La confirmación de clave es requerida.',
            
            'fotourl.image' => 'El archivo debe ser una imagen válida.',
            'fotourl.mimes' => 'La foto debe estar en formato JPG, PNG o WebP.',
            'fotourl.max' => 'La foto no puede pesar más de 4 MB.',
            'fotourl.dimensions' => 'La foto debe tener mínimo 300x300 píxeles.',
        ];
    }

    /**
     * Atributos amigables para mensajes de validación.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'telefono' => 'teléfono',
            'descripcion' => 'descripción',
            'metadescription' => 'meta descripción',
            'titulo' => 'título o cargo',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'whatsapp' => 'WhatsApp',
            'tiktok' => 'TikTok',
            'rol' => 'rol',
            'mostrar' => 'visibilidad',
            'activo' => 'estado',
            'orden' => 'orden',
            'requiere_aprobacion_propiedades' => 'aprobación de propiedades',
            'new_password' => 'clave',
            'new_password_confirmation' => 'confirmación de clave',
            'fotourl' => 'foto de perfil',
        ];
    }

    /**
     * Normaliza un string: trim y null si está vacío.
     */
    private function normalize($value): ?string
    {
        $normalized = trim((string) $value);
        return $normalized === '' ? null : $normalized;
    }
}
