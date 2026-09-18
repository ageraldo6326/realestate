# SDD — Módulo de Auditoría SEO y Sitemap Inteligente para ALIS

## 1. Propósito

Crear una funcionalidad reusable de ALIS que valide internamente la calidad técnica SEO de las URLs públicas y genere un sitemap XML dinámico, consistente e indexable.

El módulo debe impedir que URLs defectuosas entren al sitemap, mostrar al administrador qué debe corregir y actualizar el sitemap automáticamente cuando se creen, publiquen, editen, oculten o retiren propiedades, zonas, artículos y páginas públicas dinámicas.

La primera instalación validada será `https://realestate.voipcom.net/`. El diseño no debe incluir dominios ni datos de cliente hardcodeados.

## 2. Objetivos

- Mantener una única URL canónica por página y por instalación/organización.
- Incluir en sitemap solo URLs públicas, indexables, canónicas y con respuesta final 200.
- Detectar problemas antes de que afecten indexación: dominio equivocado, `.local`, 3xx, 4xx, 5xx, duplicados, `noindex`, slug inválido, contenido insuficiente y metadata faltante.
- Dar al administrador una vista de salud SEO con estados verde, amarillo y rojo.
- Ejecutar validaciones automáticamente por eventos de dominio sin regenerar innecesariamente todo el sitemap por cada cambio.
- Preservar rutas y datos existentes; las rutas heredadas deben redirigir 301 a su equivalente canónico cuando aplique.

## 3. Alcance

### Entidades auditadas

- Inicio y páginas institucionales aprobadas.
- Propiedades públicas.
- Zonas públicas.
- Tipos y operaciones públicas, solo cuando sean indexables y no duplicados.
- Índice de blog y artículos publicados.

### Fuera de alcance

- Garantizar posiciones específicas en Google.
- Crear contenido editorial automáticamente.
- Chatbot, WhatsApp o acciones de IA sobre inventario.
- Modificar automáticamente SEO title, slug, contenido o estado de publicación sin aprobación humana.

## 4. Dependencias y contexto de sitio

El módulo depende de `SiteContextService` y de la configuración reusable del sitio público. Debe obtener de este contexto:

- organización/tenant actual, cuando aplique;
- dominio canónico HTTPS;
- hosts alternos;
- estado global de indexación;
- configuración SEO, marca y Schema;
- rutas públicas vigentes.

Rutas canónicas objetivo:

- Propiedad: `/propiedades/{slug}`
- Zona: `/propiedades/{zone_slug}`
- Blog: `/blog` y `/blog/{slug}`

El sistema nunca debe construir una URL pública usando dominios hardcodeados, `APP_URL` como fuente única, `.local`, `localhost` o el host de una organización distinta.

## 5. Arquitectura

### Servicios

| Servicio | Responsabilidad |
|---|---|
| `SeoAuditService` | Evalúa reglas globales y por URL; produce hallazgos y estado. |
| `IndexabilityPolicy` | Decide si una entidad puede entrar al sitemap. |
| `CanonicalUrlService` | Construye URL absoluta canónica por entidad y contexto de sitio. |
| `SitemapService` | Reúne únicamente entidades indexables y produce XML cacheado. |
| `SitemapInvalidationService` | Invalida/reconstruye caché tras eventos relevantes. |
| `SeoHealthSummaryService` | Calcula indicadores para dashboard y alertas. |
| `StructuredDataService` | Valida presencia de Schema requerido por plantilla. |

### Eventos de dominio

Los siguientes eventos deben encolar una auditoría de entidad y solicitar invalidación de sitemap:

- `PropertyCreated`, `PropertyUpdated`, `PropertyPublished`, `PropertyUnpublished`, `PropertyDeleted`.
- `ZoneCreated`, `ZoneUpdated`, `ZonePublished`, `ZoneUnpublished`, `ZoneDeleted`.
- `PostCreated`, `PostUpdated`, `PostPublished`, `PostUnpublished`, `PostDeleted`.
- `SiteSettingsUpdated`, `SiteHostUpdated`, `SeoSettingsUpdated`.

La cola evita bloquear la experiencia del administrador. Cada evento se agrupa por entidad/organización durante una ventana corta para evitar trabajos repetidos durante una edición con múltiples guardados.

## 6. Reglas de indexabilidad

Una URL será elegible para sitemap solo si todas las reglas bloqueantes se cumplen:

| Regla | Aplicación |
|---|---|
| Entidad publicada/pública | Propiedad, zona, post o página institucional aprobada. |
| Contexto correcto | Pertenece a la organización/sitio resuelto. |
| URL canónica absoluta | HTTPS y dominio canónico configurado. |
| Slug válido y único | Sin duplicidad en su namespace de ruta. |
| Respuesta final esperada | HTTP 200, no 301/302/404/410/500. |
| Canonical auto-referenciado | El HTML declara la misma URL canónica. |
| Sin bloqueo | No contiene meta robots ni header `noindex`. |
| Sin exclusión manual | No está marcada `exclude_from_sitemap`. |
| Sin datos de desarrollo | No contiene `.local`, `localhost`, `127.0.0.1` o host ajeno. |

Reglas adicionales por tipo:

- Propiedad: disponibilidad/estado apto para publicación, título/H1, imagen principal y campos mínimos de ficha.
- Zona: inventario público o contenido editorial sustancial aprobado.
- Post: contenido publicado, título, H1, meta description o fallback válido y fecha de publicación.
- Tipo/operación: inventario real, no duplicado de otro listado y sin filtros de parámetros indexables.

Una falla bloqueante produce estado rojo y excluye la URL. Una recomendación no bloqueante produce amarillo y permite la inclusión si las reglas bloqueantes se cumplen.

## 7. Catálogo de reglas de auditoría

### 7.1 Reglas globales

| Código | Severidad | Validación |
|---|---|---|
| `SEO-DOMAIN-001` | Crítica | Dominio canónico no HTTPS o no configurado. |
| `SEO-REDIRECT-001` | Crítica | HTTP/host alterno no redirige 301 al origen canónico. |
| `SEO-ROBOTS-001` | Crítica | `robots.txt` no declara sitemap absoluto o bloquea accidentalmente URLs públicas. |
| `SEO-SITEMAP-001` | Crítica | Sitemap inválido, inaccesible o no XML. |
| `SEO-SITEMAP-002` | Crítica | Sitemap contiene `.local`, localhost, HTTP o dominio ajeno. |
| `SEO-SITEMAP-003` | Alta | Sitemap contiene URLs 3xx, 4xx, 5xx o noindex. |
| `SEO-SITEMAP-004` | Alta | Sitemap contiene URLs duplicadas. |
| `SEO-SCHEMA-001` | Media | Faltan Organization/RealEstateAgent o WebSite cuando aplique. |
| `SEO-PERF-001` | Media | Plantilla pública supera umbral definido de LCP o tiene errores críticos de consola. |

### 7.2 Reglas por URL

| Código | Severidad | Validación |
|---|---|---|
| `SEO-URL-001` | Crítica | URL canónica no coincide con la entidad o dominio configurado. |
| `SEO-URL-002` | Crítica | Respuesta final distinta a 200 para URL marcada indexable. |
| `SEO-URL-003` | Crítica | URL tiene noindex pero está incluida en sitemap. |
| `SEO-URL-004` | Alta | Canonical apunta a URL inexistente, redirección o entidad diferente. |
| `SEO-URL-005` | Alta | Slug duplicado o ruta en colisión. |
| `SEO-URL-006` | Alta | Enlace público apunta a ruta heredada o no canónica. |
| `SEO-META-001` | Media | Falta title SEO/H1/meta description o fallback permitido. |
| `SEO-META-002` | Media | Hay más de un H1 o jerarquía de encabezados inválida. |
| `SEO-IMAGE-001` | Baja | Imagen principal sin alt, dimensiones o formato optimizado. |
| `SEO-SCHEMA-002` | Media | Falta Schema específico de la plantilla. |
| `SEO-CONTENT-001` | Media | Zona/listado sin inventario ni contenido editorial suficiente. |
| `SEO-LASTMOD-001` | Baja | `updated_at` ausente o inconsistente para entidad indexable. |

Los umbrales de longitud, contenido e imagen serán configurables por instalación; no bloquearán publicación sin justificación explícita.

## 8. Panel administrativo

Ruta sugerida: `Administración → SEO e Indexación`.

Permisos:

- `seo-audit.view`: ver salud, hallazgos y detalle.
- `seo-audit.run`: lanzar auditoría manual.
- `seo-audit.manage`: configurar umbrales/exclusiones y confirmar reintentos.
- `sitemap.view`: abrir sitemap y resumen.

### Dashboard

Debe mostrar:

- estado global: verde/amarillo/rojo;
- total de URLs indexables, incluidas en sitemap, bloqueadas y con advertencias;
- hallazgos críticos/altos recientes;
- última ejecución automática y manual;
- estado de robots, sitemap, dominio y hosts alternos;
- desglose por propiedades, zonas, posts, tipos/operaciones y páginas institucionales.

### Listado de URLs

Columnas mínimas:

- entidad y título;
- tipo de URL;
- URL canónica;
- estado de publicación;
- estado de indexabilidad;
- estado de sitemap;
- semáforo SEO;
- hallazgo prioritario;
- última auditoría;
- acción: abrir, revisar entidad, excluir/incluir según permiso, reauditar.

Filtros: organización, tipo, estado, severidad, incluida/excluida y periodo de actualización.

El panel debe ser mobile-first, accesible, reactivo con Livewire y consistente con el look and feel actual de AdminLTE. No debe modificar contenido de forma automática.

## 9. Generación inteligente de sitemap

### Flujo

1. Se crea/edita/publica una entidad dinámica.
2. Se emite evento de dominio.
3. Un job en cola ejecuta `SeoAuditService` para esa entidad.
4. Se guarda el resultado y se recalcula la elegibilidad.
5. Si cambia la elegibilidad, URL, `updated_at`, publicación o contexto, se invalida la caché de sitemap del sitio.
6. `SitemapService` se reconstruye de forma diferida o en la siguiente solicitud, con lock para evitar ejecuciones concurrentes.
7. `/sitemap.xml` entrega el XML cacheado vigente.

No se debe reescribir un archivo XML manual por cada guardado. El sitemap se genera desde consultas indexadas y caché por `organization_id`/host.

### Reglas XML

- Solo URLs canónicas e indexables.
- Una sola entrada por URL.
- `<loc>` absoluto HTTPS.
- `<lastmod>` desde `updated_at` en ISO 8601 UTC.
- Sin URLs de paginación, filtros, búsquedas internas, login, API, admin o parámetros de tracking.
- Sin redirects, errores, borradores, registros eliminados u ocultos.
- Validación XML antes de marcar la versión como vigente.

## 10. Datos y almacenamiento

Tablas sugeridas, ajustadas al esquema existente:

### `seo_audit_runs`

- `id`, `organization_id`, `trigger` (`event`, `manual`, `scheduled`), `status`, `started_at`, `finished_at`, `summary_json`, `initiated_by`.

### `seo_audit_results`

- `id`, `organization_id`, `auditable_type`, `auditable_id`, `canonical_url`, `is_indexable`, `is_in_sitemap`, `score`, `status`, `last_checked_at`, `last_http_status`, `lastmod_at`.

### `seo_audit_findings`

- `id`, `audit_result_id`, `rule_code`, `severity`, `message`, `evidence_json`, `is_resolved`, `resolved_at`, `resolved_by`.

### `sitemap_versions`

- `id`, `organization_id`, `host`, `checksum`, `url_count`, `generated_at`, `status`, `storage_key` o referencia de caché.

Los registros de auditoría no almacenarán credenciales, HTML completo, tokens de Search Console ni datos privados de leads.

## 11. Ejecuciones programadas

- Auditoría rápida por evento: una entidad afectada.
- Auditoría completa diaria: sitemap, rutas indexables, duplicados, canonicals y reglas globales.
- Auditoría de rendimiento: semanal o bajo demanda para plantillas públicas, no por cada propiedad.
- Limpieza de resultados históricos: política configurable, preservando trazabilidad suficiente.

Si la cola no está disponible, el sistema debe marcar la auditoría pendiente y mostrarlo en el dashboard; no debe declarar una URL sana sin haberla validado.

## 12. Rendimiento, seguridad y compatibilidad

- Consultas a propiedades/zona/posts deben usar índices y procesamiento por lotes.
- No ejecutar solicitudes HTTP internas masivas durante una petición web; usar queue/batches con límite de concurrencia.
- Proteger acciones manuales con autorización y rate limit.
- No permitir que usuarios no administradores alteren exclusiones de sitemap o configuración de dominio.
- Mantener separación por organización/tenant en todos los resultados, jobs, cachés y sitemap.
- Conservar middleware, permisos, rutas existentes y comportamiento Livewire fuera del módulo.
- Todo cambio de esquema será migración reversible y probado en staging.

## 13. Casos de prueba y criterios de aceptación

### Sitemap

- Al publicar una propiedad válida, aparece una sola vez en `/sitemap.xml` con URL HTTPS canónica y `lastmod` correcto.
- Al ocultar o retirar una propiedad, deja de aparecer en sitemap tras procesar el evento.
- Una URL 301, 404, 500, noindex o con dominio `.local` no entra al sitemap y genera hallazgo visible.
- El sitemap no contiene duplicados, URLs de otro tenant, páginas administrativas, filtros ni parámetros.
- El sitemap es XML válido y responde 200.

### Auditoría

- Un post sin meta description recibe amarillo si existe fallback válido; sin title/H1 o con noindex incluido recibe rojo.
- Una zona sin inventario ni contenido suficiente queda excluida o en rojo según configuración.
- Cambiar el dominio canónico invalida sitemap y vuelve a auditar URLs bajo el nuevo contexto.
- Una ruta heredada 301 a su equivalente canónico no entra al sitemap; la canónica final sí.
- El panel muestra hallazgos, severidad y acción de corrección sin modificar datos automáticamente.

### Aislamiento y permisos

- Un administrador de una organización no ve ni puede reauditar resultados de otra.
- Usuarios sin permiso no pueden activar indexación, alterar exclusiones ni disparar auditoría completa.
- Jobs y caché se segmentan por organización/host.

## 14. Fases de entrega

### Fase 1 — Base de indexabilidad

- Servicios de URL/canonical, modelo de resultados, reglas bloqueantes y sitemap filtrado.
- Eventos de propiedades, zonas y posts.
- Corrección de URLs `.local`, duplicadas y rutas no canónicas detectadas.

### Fase 2 — Panel y auditoría global

- Dashboard, listado semáforo, filtros, hallazgos y auditorías manuales/programadas.
- Robots, redirects y validación XML.

### Fase 3 — Calidad avanzada

- Schema, H1/meta, contenido mínimo, imágenes, enlaces internos y performance.
- Alertas y reportes de cambios relevantes.

### Fase 4 — Validación Search Console

- Con `https://realestate.voipcom.net` como primer dominio canónico, validar sitemap, inspeccionar URLs prioritarias y registrar línea base de indexación.

## 15. Riesgos y mitigación

| Riesgo | Mitigación |
|---|---|
| Sitemap queda desactualizado | Eventos, invalidación de caché y auditoría completa diaria. |
| Sobrecarga al editar masivamente propiedades | Jobs agrupados, debounce y procesamiento por lotes. |
| Falsos bloqueos por reglas demasiado estrictas | Separar reglas bloqueantes de recomendaciones y permitir configuración auditada. |
| Una URL antigua pierde tráfico | 301 uno a uno; no redirigir a listado general. |
| Datos de clientes se mezclan | Contexto obligatorio por organización/host en consultas, jobs y caché. |
| Se cree que sitemap garantiza ranking | Panel y documentación indican que valida indexabilidad, no posiciones. |

## 16. Entregables

- Módulo administrativo SEO e Indexación.
- Servicios, jobs, eventos, policies, migraciones y pruebas automatizadas.
- Sitemap XML dinámico y cacheado.
- Catálogo de reglas y panel de hallazgos con semáforo.
- Auditoría programada y manual.
- Documentación para administración y validación inicial en Google Search Console.

