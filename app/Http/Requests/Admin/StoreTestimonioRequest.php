<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cliente' => $this->normalizeString($this->input('cliente')),
            'testimonio' => $this->normalizeString($this->input('testimonio')),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'cliente' => ['required', 'string', 'min:2', 'max:255'],
            'testimonio' => ['required', 'string', 'min:10'],
            'cliente_foto' => ['nullable', 'image', 'max:5120'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    private function normalizeString($value): string
    {
        return trim((string) $value);
    }
}
