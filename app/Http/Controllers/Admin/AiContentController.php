<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AiContentGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

class AiContentController extends Controller
{
    public function generate(Request $request, AiContentGeneratorService $generator): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:inmueble,post,asesor'],
            'instrucciones' => ['nullable', 'string', 'max:500'],
            'contexto' => ['nullable', 'array'],
        ]);

        try {
            $context = $this->sanitizeContext((array) Arr::get($validated, 'contexto', []));
            $this->validateInmuebleContext((string) $validated['type'], $context);

            $result = $generator->generate([
                'type' => (string) $validated['type'],
                'instrucciones' => (string) Arr::get($validated, 'instrucciones', ''),
                'contexto' => $context,
            ]);

            return response()->json([
                'ok' => true,
                'data' => $result,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'ok' => false,
                'message' => (string) Arr::first(Arr::flatten($e->errors()),
                    'Completa los campos requeridos para generar con IA.'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            Log::warning('ai-content-generate-failed', [
                'message' => $e->getMessage(),
                'user_id' => optional($request->user())->id,
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'No se pudo generar contenido en este momento. Verifica tu configuracion de IA e intenta de nuevo.',
            ], 422);
        }
    }

    protected function sanitizeContext(array $context): array
    {
        $sanitized = [];

        foreach ($context as $key => $value) {
            if (!is_string($key) || $key === '') {
                continue;
            }

            if (is_scalar($value) || is_null($value)) {
                $sanitized[$key] = is_string($value) ? trim($value) : $value;
                continue;
            }

            if (is_array($value)) {
                $sanitized[$key] = array_values(array_filter(array_map(static function ($item) {
                    if (is_scalar($item) || is_null($item)) {
                        return is_string($item) ? trim($item) : $item;
                    }

                    return null;
                }, $value), static fn($item) => $item !== null && $item !== ''));
            }
        }

        return $sanitized;
    }

    protected function validateInmuebleContext(string $type, array $context): void
    {
        if ($type !== 'inmueble') {
            return;
        }

        $validator = Validator::make($context, [
            'zona' => ['required', 'string', 'max:120'],
            'provincia' => ['required', 'string', 'max:120'],
            'tipo_propiedad' => ['required', 'string', 'max:120'],
            'disponible_para' => ['required', 'string', 'max:120'],
            'estado' => ['required', 'string', 'max:120'],
            'moneda' => ['required', 'string', 'max:10'],
            'habitaciones' => ['required', 'string', 'max:50'],
            'banos' => ['required', 'string', 'max:50'],
            'parqueos' => ['required', 'string', 'max:50'],
            'amenidades' => ['required', 'array', 'min:1'],
            'amenidades.*' => ['required', 'string', 'max:120'],
        ], [
            'zona.required' => 'Selecciona la zona en Datos comerciales antes de usar IA.',
            'provincia.required' => 'Selecciona la provincia en Datos comerciales antes de usar IA.',
            'tipo_propiedad.required' => 'Selecciona el tipo de propiedad en Datos comerciales antes de usar IA.',
            'disponible_para.required' => 'Selecciona disponible para en Datos comerciales antes de usar IA.',
            'estado.required' => 'Selecciona el estado de propiedad antes de usar IA.',
            'moneda.required' => 'Selecciona la moneda en Datos comerciales antes de usar IA.',
            'habitaciones.required' => 'Selecciona habitaciones en Datos comerciales antes de usar IA.',
            'banos.required' => 'Selecciona banos en Datos comerciales antes de usar IA.',
            'parqueos.required' => 'Selecciona parqueos en Datos comerciales antes de usar IA.',
            'amenidades.required' => 'Selecciona al menos una amenidad antes de usar IA.',
            'amenidades.min' => 'Selecciona al menos una amenidad antes de usar IA.',
        ]);

        $validator->after(function ($validator) use ($context) {
            foreach (['zona', 'provincia', 'tipo_propiedad', 'disponible_para', 'estado', 'moneda'] as $key) {
                $value = mb_strtolower(trim((string) Arr::get($context, $key, '')));
                if ($value !== '' && str_starts_with($value, 'selecciona')) {
                    $validator->errors()->add($key,
                        'Completa los campos de Datos comerciales y estado antes de usar IA.');
                }
            }
        });

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    }
}
