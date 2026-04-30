# Generacion de Contenido con IA (OpenAI)

Fecha de implementacion: 2026-04-26

## Objetivo

Integrar OpenAI directamente en el panel de administracion para que asesores y administradores puedan generar automaticamente descripciones, descripciones cortas, meta descriptions y titulos SEO usando el contexto del registro que estan editando (propiedad o post de blog).

---

## Arquitectura

### Archivos creados

| Archivo | Proposito |
|---|---|
| `app/Services/AiContentGeneratorService.php` | Servicio central: construye prompts, llama a la API, parsea y sanitiza la respuesta |
| `app/Http/Controllers/Admin/AiContentController.php` | Controlador HTTP: valida la request, llama al servicio, retorna JSON |

### Archivos modificados

| Archivo | Cambio |
|---|---|
| `config/services.php` | Bloque `openai` con `api_key`, `model` y `base_url` |
| `routes/web.php` | Ruta `POST /admin/ai/generar-contenido` con middleware `auth`, `role:asesor\|admin` y `throttle:20,1` |
| `resources/views/admin/propiedades/create.blade.php` | Boton IA + spinner + script de generacion con contexto completo del inmueble |
| `resources/views/admin/propiedades/edit.blade.php` | Idem create, ademas sincroniza el campo oculto `#metadescripcion-sync` |
| `resources/views/admin/posts/create.blade.php` | Boton IA + spinner + script para posts de blog |
| `resources/views/admin/posts/edit.blade.php` | Idem posts/create |
| `.env.example` | Variables de ejemplo para OpenAI |

---

## Configuracion de entorno

Agregar al archivo `.env`:

```bash
OPENAI_API_KEY=sk-proj-...        # Clave de API de OpenAI (obligatorio)
OPENAI_MODEL=gpt-4o-mini          # Modelo a usar (ver modelos compatibles)
OPENAI_BASE_URL=https://api.openai.com/v1  # URL base (no cambiar salvo proxy)
```

### Modelos compatibles

| Modelo | Tipo | Notas |
|---|---|---|
| `gpt-4o-mini` | Clasico | Recomendado: rapido y economico |
| `gpt-4o` | Clasico | Mayor calidad, mas costo |
| `gpt-3.5-turbo` | Clasico | Legado, menos preciso |
| `gpt-5` | Razonamiento | Soportado; NO acepta el parametro `temperature` |
| `o1`, `o1-mini` | Razonamiento | NO aceptan `temperature` |
| `o3`, `o3-mini`, `o4-mini` | Razonamiento | NO aceptan `temperature` |

> El servicio detecta automaticamente si el modelo es de razonamiento y omite el parametro `temperature` para evitar el error HTTP 400 de la API.

---

## Flujo de funcionamiento

```
Usuario hace clic en "Generar textos con IA"
        |
        v
JS recolecta contexto del formulario (titulo, zona, precio, amenidades, etc.)
        |
        v
POST /admin/ai/generar-contenido  {type, instrucciones, contexto}
        |
        v
AiContentController@generate  (valida, sanitiza contexto)
        |
        v
AiContentGeneratorService@generate
  - Construye system prompt (rol de vendedor inmobiliario)
  - Construye user prompt con contexto como JSON
  - Llama a OpenAI /v1/chat/completions
        |
        v
Respuesta JSON de OpenAI
  - parseJsonPayload(): elimina fences de markdown si existen
  - sanitizeHtml(): permite <h2><p><ul><li><strong><em> en descripcion
  - sanitizeText(): texto plano para descripcion_corta, metadescription, titulo
        |
        v
{ok: true, data: {descripcion, descripcion_corta, metadescription, titulo_sugerido}}
        |
        v
JS rellena los campos del formulario (CKEditor para descripcion, inputs para el resto)
SweetAlert muestra confirmacion de exito
```

---

## Campos generados

| Campo | Formato | Longitud | Notas |
|---|---|---|---|
| `descripcion` | HTML (`<h2>`, `<p>`, `<ul>/<li>`, `<strong>`, `<em>`) | Hasta 8000 chars | CKEditor lo renderiza correctamente |
| `descripcion_corta` | Texto plano | 80-160 chars | Frase de gancho para listados |
| `metadescription` | Texto plano | 120-160 chars | Optimizado para SEO |
| `titulo_sugerido` | Texto plano | Maximo 60 chars | Solo se aplica si el campo titulo esta vacio |

---

## Prompt del sistema (actitud vendedor)

### Para inmuebles

La IA adopta el rol de **asesor inmobiliario senior con mas de 15 anos de experiencia en Latinoamerica**. El texto es persuasivo, preciso y enfocado en el beneficio del comprador o inversionista: destaca ubicacion, estilo de vida, rentabilidad y atributos unicos. Crea deseo y urgencia de forma natural, sin exagerar.

### Para posts de blog

La IA adopta el rol de **redactor experto en marketing inmobiliario**. Escritura persuasiva, entusiasta y orientada a la accion: verbos de impacto, valor diferencial, urgencia sin agresividad. Parrafos cortos y subtitulos atractivos.

En ambos casos el JSON devuelto contiene las claves `descripcion`, `descripcion_corta`, `metadescription` y `titulo_sugerido`.

---

## Instrucciones adicionales del usuario

El formulario incluye un campo de texto libre (maximo 220 caracteres) donde el asesor puede dar instrucciones contextuales a la IA antes de generar, por ejemplo:

- `tono premium para inversionistas, resaltar rentabilidad`
- `publico objetivo: familias con ninos, resaltar seguridad y espacios verdes`
- `destacar que es una oportunidad de ultima unidad`

Estas instrucciones se agregan al user prompt como texto adicional.

---

## Seguridad

- La ruta requiere autenticacion (`auth`) y rol `asesor` o `admin`.
- Throttle de 20 requests por minuto por usuario.
- El contexto recibido del cliente se sanitiza en el controlador: se eliminan claves no escalares y se truncan valores a 500 caracteres antes de enviarse a la API.
- La descripcion generada por la IA pasa por `sanitizeHtml()` que usa `strip_tags` con lista blanca segura (sin `<script>`, `<iframe>`, atributos `on*`, etc.).
- Los campos de texto plano pasan por `strip_tags` completo.

---

## Manejo de errores

| Escenario | Comportamiento |
|---|---|
| `OPENAI_API_KEY` vacia | Excepcion inmediata; nunca llega a la API |
| API devuelve error HTTP (4xx/5xx) | Log `ai-openai-http-error` con status y body; mensaje generico al usuario |
| Respuesta vacia de la IA | Excepcion con mensaje descriptivo |
| JSON invalido en la respuesta | Excepcion; se intenta limpiar fences de markdown antes de parsear |
| Error general | Log `ai-content-generate-failed`; SweetAlert de error en el frontend |

Ver logs en `storage/logs/laravel.log` bajo las claves `ai-openai-http-error` y `ai-content-generate-failed`.

---

## Compatibilidad con modelos de razonamiento

Los modelos `gpt-5`, `o1`, `o3` y `o4-mini` no soportan el parametro `temperature` (la API devuelve HTTP 400 si se envia). El servicio incluye una lista de modelos de razonamiento y omite `temperature` automaticamente cuando detecta uno de ellos:

```php
$reasoningModels = ['gpt-5', 'o1', 'o1-mini', 'o3', 'o3-mini', 'o4-mini'];
if (!in_array($model, $reasoningModels, true)) {
    $payload_data['temperature'] = 0.7;
}
```

---

## Spinner de carga

Mientras se espera la respuesta de OpenAI (puede tardar 5-15 segundos dependiendo del modelo), el boton muestra el spinner animado de Bootstrap y el texto cambia a "Generando...". El boton queda deshabilitado para evitar doble envio. Al terminar (exito o error) vuelve a su estado original.

---

## Proximos pasos sugeridos

1. **Selector de tono** — Agregar dropdown con opciones: Formal, Comercial, Inversor, Lujo, Familiar. El valor seleccionado se pasa como instruccion automatica.
2. **Historial de generaciones** — Guardar en base de datos cada generacion (modelo, contexto, resultado, usuario, fecha) para auditoria y retroalimentacion.
3. **Extender a otros modulos** — Testimonios, descripciones de asesores, portadas de landing.
4. **Streaming** — Implementar respuesta en tiempo real (`stream: true`) para mostrar el texto mientras se genera, mejorando la percepcion de velocidad.
5. **Evaluacion de calidad** — Boton de "pulgar arriba/abajo" para registrar si el contenido generado fue util, y usar esos datos para ajustar el prompt.
