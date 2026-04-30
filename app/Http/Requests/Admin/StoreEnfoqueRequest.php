<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnfoqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo' => $this->normalizeString($this->input('titulo')),
            'enfoque' => $this->normalizeString($this->input('enfoque')),
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:2', 'max:255'],
            'enfoque' => ['required', 'string', 'min:10'],
            'foto' => ['nullable', 'image', 'max:5120'],
        ];
    }

    private function normalizeString($value): string
    {
        return trim((string) $value);
    }
}
