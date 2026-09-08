<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstadoRequest extends FormRequest
{
  public function authorize(): bool
  {
    return (bool) optional($this->user())->can('access-admin');
  }

  protected function prepareForValidation(): void
  {
    $this->merge([
      'estado' => $this->normalize($this->input('estado')),
    ]);
  }

  public function rules(): array
  {
    return [
      'estado' => [
        'required',
        'string',
        'min:2',
        'max:50',
        Rule::unique('estados', 'estado'),
      ],
    ];
  }

  public function messages(): array
  {
    return [
      'estado.required' => 'El estado es obligatorio.',
      'estado.min' => 'El estado debe tener al menos 2 caracteres.',
      'estado.max' => 'El estado no puede exceder 50 caracteres.',
      'estado.unique' => 'El estado ya existe en el catalogo.',
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
