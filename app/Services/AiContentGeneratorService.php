<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class AiContentGeneratorService
{
    public function generate(array $payload): array
    {
        $apiKey = trim((string) config('services.openai.api_key'));
        if ($apiKey === '') {
            throw new RuntimeException('OPENAI_API_KEY no esta configurada.');
        }

        $baseUrl = rtrim((string) config('services.openai.base_url', 'https://api.openai.com/v1'), '/');
        $model = (string) config('services.openai.model', 'gpt-4o-mini');

        $type = (string) Arr::get($payload, 'type', 'inmueble');
        $instructions = trim((string) Arr::get($payload, 'instrucciones', ''));
        $context = (array) Arr::get($payload, 'contexto', []);

        // Los modelos de razonamiento (gpt-5, o1, o3) no soportan el parametro temperature
        $reasoningModels = ['gpt-5', 'o1', 'o1-mini', 'o3', 'o3-mini', 'o4-mini'];
        $payload_data = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $this->systemPrompt($type),
                ],
                [
                    'role' => 'user',
                    'content' => $this->userPrompt($context, $instructions),
                ],
            ],
        ];
        if (!in_array($model, $reasoningModels, true)) {
            $payload_data['temperature'] = 0.7;
        }

        $response = Http::timeout(60)
            ->withToken($apiKey)
            ->acceptJson()
            ->post($baseUrl . '/chat/completions', $payload_data);

        if (!$response->successful()) {
            $status = $response->status();
            $body   = (string) $response->body();
            \Illuminate\Support\Facades\Log::warning('ai-openai-http-error', [
                'status' => $status,
                'body'   => mb_substr($body, 0, 500),
                'model'  => $model,
            ]);
            throw new RuntimeException('No se pudo generar contenido con IA en este momento.');
        }

        $content = (string) data_get($response->json(), 'choices.0.message.content', '');
        if ($content === '') {
            throw new RuntimeException('La IA no devolvio contenido utilizable.');
        }

        $parsed = $this->parseJsonPayload($content);

        return [
            'descripcion'      => $this->sanitizeHtml((string) Arr::get($parsed, 'descripcion', ''), 8000),
            'descripcion_corta' => $this->sanitizeText((string) Arr::get($parsed, 'descripcion_corta', ''), 160),
            'metadescription'  => $this->sanitizeText((string) Arr::get($parsed, 'metadescription', ''), 160),
            'titulo_sugerido'  => $this->sanitizeText((string) Arr::get($parsed, 'titulo_sugerido', ''), 60),
        ];
    }

    protected function systemPrompt(string $type): string
    {
        if ($type === 'asesor') {
            return <<<'PROMPT'
Eres un redactor experto en marketing para agencias inmobiliarias. Tu tarea es escribir la descripcion de perfil de un asesor inmobiliario para publicarla en el sitio web de la agencia.
El tono debe ser profesional, cercano y de confianza. Destaca la experiencia, especialidad, enfoque de servicio al cliente y cualquier atributo diferenciador del asesor.
El texto debe estar en espanol neutro, bien estructurado con parrafos cortos.

Genera el contenido y responde UNICAMENTE en JSON valido con estas claves exactas:
- "descripcion": HTML bien formateado con etiquetas <p> y <strong> donde corresponda. Entre 80 y 200 palabras. Tono profesional y cercano.
- "descripcion_corta": texto plano, 60-120 caracteres, sin HTML, resumen breve del perfil.
- "metadescription": texto plano, 120-160 caracteres, sin HTML, optimizado para SEO.
- "titulo_sugerido": texto plano, maximo 60 caracteres, titulo SEO para la pagina del asesor.

Reglas estrictas: sin hashtags, sin emojis, sin comillas decorativas, sin markdown (solo HTML en "descripcion").
PROMPT;
        }

        if ($type === 'post') {
            return <<<'PROMPT'
Eres un redactor experto en marketing inmobiliario con 15 años de experiencia vendiendo propiedades de lujo y proyectos de inversion en Latinoamerica.
Tu escritura es persuasiva, entusiasta y orientada a la accion: usas verbos de impacto, destacas el valor diferencial y creas urgencia sin ser agresivo.
El texto debe estar en espanol neutro, bien estructurado con parrafos cortos y subtitulos atractivos.

Genera el contenido de un post de blog inmobiliario y responde UNICAMENTE en JSON valido con estas claves exactas:
- "descripcion": HTML bien formateado con etiquetas <h2>, <p>, <ul>/<li> y <strong> donde corresponda. Minimo 300 palabras. Tono de experto asesor inmobiliario.
- "descripcion_corta": texto plano, 80-160 caracteres, sin HTML, frase de gancho que invite a leer.
- "metadescription": texto plano, 120-160 caracteres, sin HTML, optimizado para SEO con llamada a la accion sutil.
- "titulo_sugerido": texto plano, maximo 60 caracteres, titulo SEO atractivo y con palabra clave natural.

Reglas estrictas: sin hashtags, sin emojis, sin comillas decorativas, sin markdown (solo HTML en "descripcion").
PROMPT;
        }

        return <<<'PROMPT'
Eres un asesor inmobiliario senior con mas de 15 anos vendiendo propiedades en Latinoamerica. Tu estilo es persuasivo, preciso y enfocado en el beneficio para el comprador o inversionista.
Destacas la ubicacion, el estilo de vida, la rentabilidad potencial y los atributos unicos de cada propiedad. Creas deseo y urgencia de forma natural, sin exagerar.
El texto debe estar en espanol neutro, orientado a ventas, con parrafos cortos y llamadas a la accion implícitas.

Genera los textos para la ficha de un inmueble y responde UNICAMENTE en JSON valido con estas claves exactas:
- "descripcion": HTML bien formateado con etiquetas <h2>, <p>, <ul>/<li> y <strong> donde corresponda. Minimo 250 palabras. Destaca los beneficios clave, el entorno, los acabados y el estilo de vida que ofrece la propiedad.
- "descripcion_corta": texto plano, 80-160 caracteres, sin HTML, frase de gancho con el mayor atributo del inmueble.
- "metadescription": texto plano, 120-160 caracteres, sin HTML, optimizado para SEO con llamada a la accion sutil.
- "titulo_sugerido": texto plano, maximo 60 caracteres, titulo SEO atractivo y con palabra clave natural.

Reglas estrictas: sin hashtags, sin emojis, sin comillas decorativas, sin markdown (solo HTML en "descripcion").
PROMPT;
    }

    protected function userPrompt(array $context, string $instructions): string
    {
        $contextJson = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $extra = $instructions !== '' ? "\nInstrucciones adicionales del usuario: {$instructions}" : '';

        return "Contexto del registro:\n{$contextJson}{$extra}";
    }

    protected function parseJsonPayload(string $content): array
    {
        $trimmed = trim($content);

        if (Str::startsWith($trimmed, '```')) {
            $trimmed = preg_replace('/^```(?:json)?\s*/', '', $trimmed) ?? $trimmed;
            $trimmed = preg_replace('/\s*```$/', '', $trimmed) ?? $trimmed;
        }

        $decoded = json_decode($trimmed, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw new RuntimeException('La respuesta de IA no llego en JSON valido.');
        }

        return $decoded;
    }

    /**
     * Permite etiquetas HTML seguras para la descripcion enriquecida del inmueble/post.
     */
    protected function sanitizeHtml(string $value, int $maxLength): string
    {
        $allowed = '<h2><h3><p><ul><ol><li><strong><em><br>';
        $clean = trim(strip_tags($value, $allowed));

        if ($clean === '') {
            return '';
        }

        return Str::limit($clean, $maxLength, '');
    }

    protected function sanitizeText(string $value, int $maxLength): string
    {
        $clean = trim(strip_tags($value));

        if ($clean === '') {
            return '';
        }

        return Str::limit($clean, $maxLength, '');
    }
}
