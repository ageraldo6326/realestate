<?php

namespace App\Http\Requests\Admin;

class UpdatePortadaRequest extends StorePortadaRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['foto'] = ['nullable', 'image', 'max:5120'];

        return $rules;
    }
}
