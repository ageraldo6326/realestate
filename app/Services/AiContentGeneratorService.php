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
                    'content' => $this->systemPrompt($type, $instructions),
                ],
                [
                    'role' => 'user',
                    'content' => $this->userPrompt($context, $type),
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

        $descripcion = $this->sanitizeHtml((string) Arr::get($parsed, 'descripcion', ''), 8000);
        if ($type === 'inmueble') {
            $descripcion = $this->ensurePropertyHashtags($descripcion, $context);
        }

        $tituloSugerido = (string) Arr::get(
            $parsed,
            'titulo_sugerido',
            Arr::get($parsed, 'titulo', '')
        );

        return [
            'descripcion'      => $descripcion,
            'descripcion_corta' => $this->sanitizeText((string) Arr::get($parsed, 'descripcion_corta', ''), 160),
            'metadescription'  => $this->sanitizeText((string) Arr::get($parsed, 'metadescription', ''), 160),
            'titulo_sugerido'  => $this->sanitizeText($tituloSugerido, 60),
        ];
    }

    protected function systemPrompt(string $type, string $instructions = ''): string
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

        $prompt = $this->inmuebleBasePrompt();

        if ($instructions !== '') {
            $prompt .= "\n\nInstrucciones del usuario que deben aplicarse a TODOS los campos generados (titulo_sugerido, descripcion_corta, metadescription y descripcion): {$instructions}.\nAdapta el tono, enfoque y vocabulario de todos los campos segun esas instrucciones.";
        }

        return $prompt;
    }

    protected function userPrompt(array $context, string $type = 'inmueble'): string
    {
        $contextJson = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $locationRules = '';
        if ($type === 'inmueble') {
            $provincia = trim((string) Arr::get($context, 'provincia', ''));
            $sector = trim((string) Arr::get($context, 'sector', ''));

            if ($provincia !== '' || $sector !== '') {
                $locationRules = "\nReglas obligatorias de ubicacion:\n"
                    . "- Ubicacion de referencia: " . ($sector !== '' ? "Sector {$sector}" : 'Sector no especificado')
                    . ", " . ($provincia !== '' ? "Provincia {$provincia}" : 'Provincia no especificada') . ".\n"
                    . "- Usa solo esos datos para hablar de ubicacion.\n"
                    . "- No menciones ciudades o zonas distintas (por ejemplo, Santo Domingo Este) a menos que coincidan exactamente con provincia o sector.\n"
                    . "- Si los textos actuales del contexto contienen otra ubicacion, ignoralos para la ubicacion final.";
            }
        }

        return "Contexto del registro:\n{$contextJson}{$locationRules}";
    }

    private function inmuebleBasePrompt(): string
    {
        return <<<'PROMPT'
Eres un asesor inmobiliario senior con mas de 15 anos vendiendo propiedades en Latinoamerica. Tu estilo es persuasivo, preciso y enfocado en el beneficio para el comprador o inversionista.
Destacas la ubicacion, el estilo de vida, la rentabilidad potencial y los atributos unicos de cada propiedad. Creas deseo y urgencia de forma natural, sin exagerar.
El texto debe estar en espanol neutro, orientado a ventas, con parrafos cortos y llamadas a la accion implícitas.

Regla obligatoria de ubicacion: usa unicamente la provincia y el sector recibidos en el contexto como fuente de ubicacion.
No inventes ni sustituyas ciudades, zonas o sectores diferentes. Si en textos previos del contexto hay otra ubicacion, debes ignorarla.

Genera los textos para la ficha de un inmueble y responde UNICAMENTE en JSON valido con estas claves exactas:
- "descripcion": HTML bien formateado con etiquetas <h2>, <p>, <ul>/<li> y <strong> donde corresponda. Minimo 250 palabras. Destaca los beneficios clave, el entorno, los acabados y el estilo de vida que ofrece la propiedad. Incluye exactamente 3 hashtags inmobiliarios al final (por ejemplo: #Inmuebles #BienesRaices #HogarIdeal).
- "descripcion_corta": texto plano, 80-160 caracteres, sin HTML, frase de gancho con el mayor atributo del inmueble.
- "metadescription": texto plano, 120-160 caracteres, sin HTML, optimizado para SEO con llamada a la accion sutil.
- "titulo_sugerido": texto plano, maximo 60 caracteres, titulo SEO atractivo y con palabra clave natural.

Reglas estrictas: sin emojis, sin comillas decorativas, sin markdown (solo HTML en "descripcion").
PROMPT;
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

    protected function ensurePropertyHashtags(string $description, array $context): string
    {
        if ($description === '') {
            return '';
        }

        preg_match_all('/(^|[\s>])(#[\p{L}\p{N}_]+)/u', $description, $matches);
        $existing = [];
        foreach ((array) ($matches[2] ?? []) as $tag) {
            $normalized = $this->normalizeHashtag($tag);
            if ($normalized !== '' && !in_array($normalized, $existing, true)) {
                $existing[] = $normalized;
            }
        }

        if (count($existing) >= 3) {
            return $description;
        }

        $candidateKeys = [
            'tipo_propiedad',
            'disponible_para',
            'provincia',
            'sector',
            'estado',
        ];

        $candidates = [];
        foreach ($candidateKeys as $key) {
            $value = trim((string) Arr::get($context, $key, ''));
            $tag = $this->normalizeHashtag($value);
            if ($tag !== '' && !in_array($tag, $candidates, true)) {
                $candidates[] = $tag;
            }
        }

        $defaults = ['#Inmuebles', '#BienesRaices', '#HogarIdeal', '#TuNuevoHogar'];
        $allTags = array_values(array_unique(array_merge($existing, $candidates, $defaults)));
        $targetTags = array_slice($allTags, 0, 3);
        $missingTags = array_values(array_diff($targetTags, $existing));

        if ($missingTags === []) {
            return $description;
        }

        return rtrim($description) . '<p>' . implode(' ', $missingTags) . '</p>';
    }

    protected function normalizeHashtag(string $value): string
    {
        $value = ltrim(trim($value), '#');
        if ($value === '') {
            return '';
        }

        $ascii = Str::ascii($value);
        $ascii = preg_replace('/[^A-Za-z0-9\s]/', ' ', $ascii) ?? '';
        $ascii = preg_replace('/\s+/', ' ', trim($ascii)) ?? '';

        if ($ascii === '') {
            return '';
        }

        $compact = str_replace(' ', '', ucwords(Str::lower($ascii)));
        if ($compact === '') {
            return '';
        }

        return '#' . substr($compact, 0, 24);
    }
}
