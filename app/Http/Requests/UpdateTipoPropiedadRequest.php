<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoPropiedadRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // La autorización se valida en el controlador/policy
    return $this->user() !== null;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    $tipoPropiedad = $this->route('tipopropiedade');

    return [
      'tipo' => [
        'required',
        'string',
        'max:100',
        'min:2',
        'regex:/^[a-záéíóúñ\s\-&.,]*$/i',
        Rule::unique('tipos_de_propiedads', 'tipo')
          ->ignore(is_object($tipoPropiedad) ? $tipoPropiedad->id : $tipoPropiedad),
      ],
    ];
  }

  /**
   * Get custom messages for validator errors.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'tipo.required' => 'El tipo de propiedad es obligatorio.',
      'tipo.string' => 'El tipo debe ser texto válido.',
      'tipo.max' => 'El tipo no puede exceder 100 caracteres.',
      'tipo.min' => 'El tipo debe tener al menos 2 caracteres.',
      'tipo.regex' => 'El tipo solo puede contener letras, espacios, guiones y ampersand.',
      'tipo.unique' => 'Este tipo de propiedad ya existe en el sistema.',
    ];
  }

  /**
   * Prepare the data for validation.
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    $this->merge([
      'tipo' => trim($this->input('tipo')),
    ]);
  }
}
