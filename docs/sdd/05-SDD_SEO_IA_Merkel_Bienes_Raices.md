# SDD — SEO, rendimiento e integración de IA para Merkel Bienes Raíces

## 1. Propósito

Implementar en ALIS CRM Inmobiliario los cambios necesarios para que la nueva web pública sea publicable bajo `https://www.merkelbienesraices.com.do/`, tenga una base SEO técnicamente correcta, mejore su rendimiento y quede preparada para consumir y actualizar datos del CRM mediante una API segura orientada a futuros asistentes de inteligencia artificial.

Ambientes actuales:

- Staging actual: `https://realestate.voipcom.net/`
- Dominio de producción objetivo: `https://www.merkelbienesraices.com.do/`

Este documento cubre los siete puntos solicitados por Merkel y los hallazgos de la auditoría pública inicial. No autoriza cambios destructivos en datos de propiedades, zonas, blog, leads, proyectos ni usuarios.

## 2. Hallazgos que motivan el cambio

- El sitemap publicado contiene URLs de desarrollo `http://realestate.local/...`.
- El sitemap incluye rutas de propiedades que deben responder con una ficha pública indexable; al menos una ruta auditada redirige a `/propiedades`.
- Las zonas públicas ya existen, pero usan rutas raíz como `/santo-domingo-este` en vez de una estructura explícita `/propiedades/{zona}`.
- Los posts individuales existen bajo `/post/{slug}`; se requiere una convención final y estable bajo `/blog/{slug}`.
- Las páginas públicas responden con `Cache-Control: no-cache, no-store, private`, lo que impide aprovechar caché de navegador/CDN.
- No se detectó Schema JSON-LD público en la portada.
- El editor administrativo CKEditor 4.20.0 requiere revisión y actualización o mitigación de seguridad.

## 3. Objetivos y resultados esperados

1. Declarar una única versión indexable: `https://www.merkelbienesraices.com.do/`.
2. Generar un sitemap XML dinámico con páginas públicas reales, canónicas e indexables.
3. Dar a cada publicación de blog una URL permanente, campos SEO propios y presencia automática en sitemap.
4. Publicar páginas SEO administrables por zona y alimentadas por las propiedades vigentes del CRM.
5. Mejorar el rendimiento móvil sin alterar el diseño ni los flujos existentes.
6. Completar SEO técnico, accesibilidad básica y datos estructurados.
7. Exponer una API REST/JSON protegida, documentada y auditable para futuras integraciones de IA.

## 4. Alcance funcional

### 4.1 Dominio, HTTPS y canonical

- Configurar el virtual host de producción para `www.merkelbienesraices.com.do` con certificado TLS válido.
- Redirigir con **301**, preservando ruta y query string:
  - `http://merkelbienesraices.com.do/*` → `https://www.merkelbienesraices.com.do/*`
  - `https://merkelbienesraices.com.do/*` → `https://www.merkelbienesraices.com.do/*`
  - `http://www.merkelbienesraices.com.do/*` → `https://www.merkelbienesraices.com.do/*`
- Configurar `APP_URL=https://www.merkelbienesraices.com.do` en producción y limpiar/configurar caché de Laravel durante el despliegue.
- Generar canonicals absolutos desde la URL configurada, nunca desde un dominio hardcodeado o de staging.
- Mantener `realestate.voipcom.net` fuera de indexación una vez esté activo el dominio final, preferiblemente restringido por autenticación o con `X-Robots-Tag: noindex, nofollow` mientras continúe como staging.

### 4.2 Sitemap XML dinámico

Ruta pública: `/sitemap.xml`.

Debe incluir únicamente rutas con respuesta final 200, canonical indexable y sin `noindex`:

- Inicio, catálogo, contacto y demás páginas institucionales aprobadas.
- Fichas públicas de propiedades activas/publicadas.
- Páginas SEO de zonas activas.
- Páginas por operación/tipo solo si tienen contenido indexable y no duplicado.
- Índice de blog y posts individuales publicados.

Reglas:

- Todas las `<loc>` usarán `https://www.merkelbienesraices.com.do/...`.
- `lastmod` se tomará de `updated_at` de cada entidad y se emitirá en ISO 8601 UTC.
- No incluir propiedades borrador, vendidas/ocultas si no son públicas, rutas redirigidas, errores 404, filtros con parámetros ni páginas paginadas.
- El sitemap se generará dinámicamente o mediante caché invalidada cuando se publique/edite una entidad SEO relevante. No se mantendrá como archivo manual.
- `robots.txt` declarará la URL absoluta: `Sitemap: https://www.merkelbienesraices.com.do/sitemap.xml`.

### 4.3 Blog público y SEO editorial

Convención definitiva:

- Índice: `/blog`
- Detalle: `/blog/{slug}`

Para compatibilidad, las rutas existentes `/post/{slug}` devolverán 301 a `/blog/{slug}`. No se modificará el slug de un artículo ya publicado sin crear su 301 de preservación.

Campos administrables por post:

- `title`
- `slug` único
- contenido enriquecido sanitizado
- estado (`draft`, `published`)
- fecha de publicación
- `seo_title` opcional
- `meta_description` opcional
- imagen principal, texto alternativo y crédito cuando aplique

Fallbacks: si no se completan campos SEO, el sistema usará título y extracto controlado. Cada post publicado mostrará un solo H1, canonical propio, Open Graph, Twitter Card y Schema `BlogPosting`.

### 4.4 Páginas SEO por zonas

Convención definitiva: `/propiedades/{zone_slug}`.

El módulo de zonas de ALIS incorporará o validará estos campos:

- `slug` único e inmutable salvo acción explícita.
- `is_public`.
- `name`.
- `seo_h1`.
- `seo_title`.
- `meta_description`.
- `seo_description` enriquecida y sanitizada.
- imagen opcional y `image_alt`.

Comportamiento público:

- Mostrar solo propiedades públicas, disponibles y asociadas a la zona.
- Aplicar paginación indexable y canonical a la primera página; las páginas posteriores usarán canonical propio solo si contienen una URL válida y contenido navegable.
- Si una zona no tiene propiedades, mostrar contenido editorial solo cuando sea estratégicamente útil; de lo contrario responder 404 para evitar páginas vacías indexables.
- Las rutas raíz anteriores (`/{zona}`) serán redirigidas con 301 a `/propiedades/{zone_slug}` tras validar colisiones de rutas.
- Enlazar propiedades y zonas mediante rutas canónicas internas.

### 4.5 Fichas de propiedades y catálogo

- La ruta pública final será `/propiedades/{slug}`. Si existe una convención distinta ya usada por el negocio, se definirá una sola antes de publicación.
- Cada ficha pública debe responder 200, tener un único H1, title, meta description, canonical, imagen principal con alt y Schema `RealEstateListing`/`Product` apropiado.
- Las rutas históricas como `/propiedad/{slug}` deberán responder 301 a la ruta final equivalente, nunca al listado general.
- Una propiedad no pública, eliminada o sin disponibilidad debe devolver 404 o 410 según su política comercial; no debe aparecer en sitemap.
- Se verificará que cada enlace del listado conduzca a su ficha y no a una redirección genérica.

### 4.6 Rendimiento y frontend

Objetivo inicial: **PageSpeed móvil ≥80** para portada y plantilla de propiedad; objetivo de mejora posterior: aproximarse a 90 sin degradar UX ni funcionalidades.

Medidas:

- Definir el elemento LCP por plantilla y optimizar su imagen: formato WebP/AVIF cuando sea viable, tamaño adaptativo, compresión, `srcset`, `sizes`, `fetchpriority="high"` para el LCP y dimensiones explícitas `width`/`height`.
- Aplicar `loading="lazy"` y `decoding="async"` a imágenes que no estén sobre el pliegue.
- Evitar carga de imágenes de tamaño original cuando se muestra una miniatura.
- Extraer, minificar y versionar CSS/JS mediante el pipeline actual del proyecto; eliminar dependencias, estilos y scripts no utilizados por plantilla.
- Cargar JavaScript no crítico con `defer` y evitar bloqueos de renderizado.
- Optimizar fuentes: `font-display: swap`, menos variantes y preload solo de las necesarias para el contenido visible.
- Aplicar caché pública a páginas, CSS, JS, imágenes y fuentes. Las páginas públicas no deben responder `private, no-store` salvo rutas con datos de sesión.
- Configurar compresión Brotli/Gzip y cache-control de assets con fingerprint.
- Corregir errores de consola y solicitudes fallidas antes de liberar.
- Mantener diseño mobile-first, accesibilidad de teclado y comportamiento Livewire existente.

### 4.7 SEO técnico, accesibilidad y seguridad

- Mantener un H1 único por vista; usar H2/H3 en jerarquía semántica.
- Mantener un `<main>` único con enlace de salto al contenido cuando aplique.
- Configurar páginas 404 y 410 útiles, sin indexación, y revisar enlaces internos rotos.
- Añadir metadatos Open Graph y Twitter Card coherentes por plantilla.
- Implementar Schema JSON-LD:
  - `Organization` y `RealEstateAgent` en portada/contacto.
  - `WebSite` y `SearchAction` si el buscador público cumple los requisitos.
  - `BreadcrumbList` en catálogo, zona, blog y fichas.
  - `BlogPosting` en posts.
  - Schema de propiedad/listing según datos realmente disponibles; no inventar disponibilidad, precio o ubicación.
- Añadir headers de seguridad compatibles con Laravel/Livewire: HSTS en producción, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy` y una CSP inicialmente en modo reporte antes de bloquear recursos legítimos.
- Revisar CKEditor 4.20.0. Preferencia: migrar a una versión soportada o a CKEditor 5 en una tarea controlada. Como mínimo, actualizar a una versión con parches, sanitizar HTML al guardar y al renderizar, restringir plugins, validar carga de archivos y aplicar autorización por rol.

### 4.8 API REST para IA

Base: `/api/v1`.

Autenticación y autorización:

- Laravel Sanctum o mecanismo equivalente ya aprobado por la arquitectura.
- Tokens revocables, con expiración, rotación y scopes separados: `properties:read`, `projects:read`, `leads:read`, `leads:write`, `advisors:read`, `interactions:write`.
- Nunca exponer contraseñas, tokens, documentos internos, notas privadas o datos personales no requeridos.
- Validar que cada token solo acceda a la organización/tenant autorizado.
- Rate limit por token/IP, auditoría de acceso, `request_id`, logs de errores y alertas para uso anómalo.
- Las acciones de escritura sensibles requerirán revisión/confirmación humana o una política explícita de autorización; la IA no podrá borrar ni modificar precios, propiedades, proyectos ni usuarios.

Endpoints mínimos:

| Método | Endpoint | Scope | Propósito |
|---|---|---|---|
| GET | `/properties` | `properties:read` | Listar propiedades públicas/disponibles con filtros `zone`, `min_price`, `max_price`, `bedrooms`, `type`, `operation`, paginación y orden seguro. |
| GET | `/properties/{id-or-slug}` | `properties:read` | Consultar ficha y disponibilidad actual. |
| GET | `/zones` | `properties:read` | Consultar zonas disponibles. |
| GET | `/projects` | `projects:read` | Consultar proyectos, rangos de precio y disponibilidad permitida. |
| GET | `/projects/{id}` | `projects:read` | Consultar detalle de proyecto. |
| POST | `/leads` | `leads:write` | Registrar lead con validación, consentimiento y fuente. |
| PATCH | `/leads/{id}` | `leads:write` | Actualizar campos permitidos del lead. |
| GET | `/advisors` | `advisors:read` | Consultar asesores activos aptos para asignación. |
| POST | `/leads/{id}/assignments` | `leads:write` | Solicitar/asignar asesor según política comercial. |
| POST | `/leads/{id}/interactions` | `interactions:write` | Registrar interacción, canal, resumen y resultado. |

Convenciones API:

- JSON UTF-8, versionado por URL, validación con Form Requests y respuestas de error RFC 7807 o formato uniforme aprobado.
- Filtros permitidos explícitamente; no aceptar nombres de columnas ni SQL desde el cliente.
- Paginación con límite máximo configurable.
- Idempotency-Key obligatoria para creación de leads e interacciones para evitar duplicados en reintentos de IA/WhatsApp.
- Documentación OpenAPI 3.0 accesible solo a administradores técnicos autenticados.
- Webhooks no forman parte de esta primera entrega; se evaluarán después de estabilizar los endpoints.

## 5. Modelo de datos y migraciones

Las migraciones se crearán solo después de mapear el esquema existente. No se eliminarán ni renombrarán columnas existentes sin una estrategia de compatibilidad.

Entidades a revisar:

- `properties`: estado público, slug, fechas de publicación/actualización, zona, operación, tipo, precio, habitaciones, imágenes y disponibilidad.
- `zones`: campos SEO y publicación descritos en 4.4.
- `posts`: campos editoriales y SEO descritos en 4.3.
- `projects`: disponibilidad y rangos de precio autorizados para API.
- `leads`, `advisors`, asignaciones e interacciones: trazabilidad, consentimiento, autor/origen de cambio y tenant.
- `api_tokens` o almacenamiento de tokens del mecanismo seleccionado.
- `api_audit_logs`: token/actor, endpoint, método, respuesta, IP protegida/anonimizada según política y `request_id`.

Se crearán índices para `slug`, estado público, zona, tipo, operación, rango de precio, habitaciones y relaciones utilizadas en filtros. Cada migración será reversible y se validará en staging con una copia anonimizada de datos cuando sea necesario.

## 6. Arquitectura propuesta

### Capas

- Rutas web separadas por dominio/entorno y nombres de ruta estables.
- Controladores públicos ligeros; consultas encapsuladas en servicios o repositorios existentes.
- `SeoMetadataService` para title, description, canonical, Open Graph y JSON-LD.
- `SitemapService` para reunir exclusivamente entidades indexables y generar/cachear XML.
- `PublicPropertyService` para resolver propiedad pública y evitar que una ruta válida termine en redirección genérica.
- `Api/V1/*Controller`, Form Requests, API Resources, Policies y middleware de scopes/rate limit.
- Eventos de dominio (`PropertyPublished`, `PropertyUpdated`, `ZoneUpdated`, `PostPublished`, etc.) para invalidar sitemap y cachés relacionados.

### Criterios de compatibilidad

- Conservar permisos administrativos actuales, sesiones, middleware y datos existentes.
- No introducir una API pública sin autenticación.
- No exponer endpoints administrativos existentes a la IA.
- No cambiar rutas indexadas sin su redirección 301 correspondiente.
- No aplicar cambios de dependencias globales sin pruebas de regresión de Livewire/AdminLTE.

## 7. Requisitos no funcionales

- Mobile-first y WCAG 2.1 AA en controles nuevos y contenidos administrables relevantes.
- Páginas públicas sin datos de sesión, cookies innecesarias ni caché privada.
- Latencia objetivo del catálogo/API p95 definida durante baseline; consultas filtradas deben evitar N+1 y cargar relaciones necesarias de forma explícita.
- Logs sin tokens, contraseñas, tarjetas ni contenido sensible completo de leads.
- Backups y plan de reversión antes de migraciones y del cambio de dominio.

## 8. Plan de implementación por fases

### Fase 0 — Descubrimiento y baseline

- Inventariar rutas, controladores, modelos, roles, tablas, CKEditor, configuración de servidor y dominio.
- Ejecutar baseline de PageSpeed/Lighthouse para portada, catálogo, zona, ficha de propiedad y post.
- Exportar sitemap actual y validar todas sus URLs, códigos HTTP, canonicals y enlaces.
- Definir la convención final de URL de propiedad antes de implementar redirecciones.

### Fase 1 — Correcciones críticas SEO

- Corregir generación de URLs de sitemap usando configuración de producción.
- Corregir fichas de propiedades y exclusión de redirecciones/errores del sitemap.
- Implementar rutas canónicas de blog, zonas y propiedades con 301 de compatibilidad.
- Implementar campos SEO faltantes y metadatos centralizados.

### Fase 2 — Publicación y SEO técnico

- Configurar dominio, TLS, redirecciones 301, robots y staging no indexable.
- Agregar Schema, breadcrumbs, 404/410, headers de seguridad y auditoría de enlaces.
- Registrar sitemap y dominio final en Google Search Console después del despliegue.

### Fase 3 — Rendimiento

- Optimizar LCP, imágenes, fuentes, bundles, caché y errores de consola.
- Comparar resultados contra baseline y corregir regresiones visuales/mobile.

### Fase 4 — API de IA

- Diseñar contrato OpenAPI, tokens/scopes, policies, logs y límites.
- Construir endpoints de lectura y pruebas automatizadas.
- Habilitar escrituras de leads/interacciones con idempotencia y autorización.
- Prueba piloto controlada antes de conectar web chat o WhatsApp.

### Fase 5 — CKEditor

- Auditar uso real de CKEditor y plugins.
- Ejecutar actualización/migración aislada, con pruebas de edición, pegado, imágenes, sanitización y renderizado de contenido existente.

## 9. Pruebas y criterios de aceptación

### Dominio y SEO

- Todas las combinaciones HTTP/sin www redirigen 301 a la URL HTTPS con www, preservando ruta y parámetros.
- Cada página pública indexable tiene canonical absoluto con `www.merkelbienesraices.com.do`.
- `sitemap.xml` no contiene `localhost`, `.local`, staging, URLs HTTP, 3xx, 4xx, 5xx, borradores ni noindex.
- Todas las URLs del sitemap responden 200 y su canonical coincide con la URL publicada.
- Posts, zonas y propiedades tienen un H1 único y metadata verificable.
- Rutas antiguas relevantes responden 301 a su equivalente, no al listado genérico.

### Rendimiento

- Comparativa Lighthouse/PageSpeed antes/después almacenada para las cinco plantillas.
- Rendimiento móvil ≥80 en portada y ficha de propiedad bajo condiciones equivalentes de prueba.
- LCP, CLS y TBT mejoran frente al baseline sin errores nuevos de consola.
- Imágenes no críticas cargan diferido y las principales tienen dimensiones/fuentes optimizadas.

### API

- Sin token, token vencido, token inválido y token sin scope devuelven 401/403 correctos.
- Filtros de propiedades devuelven solo datos autorizados, paginados y actualizados.
- La escritura de leads/interacciones valida payload, consentimiento, política de asignación e idempotencia.
- Ningún endpoint permite borrar o modificar precios, propiedades, proyectos o usuarios mediante token de IA.
- Todas las llamadas relevantes dejan log de auditoría sin exponer secretos.
- OpenAPI y pruebas automatizadas cubren casos correctos, permisos insuficientes y validaciones fallidas.

## 10. Riesgos y mitigaciones

| Riesgo | Mitigación |
|---|---|
| Pérdida temporal de posicionamiento por cambio de URL | 301 uno a uno, canonicals correctos, sitemap limpio, monitoreo en Search Console. |
| Contenido duplicado entre staging y producción | Bloquear indexación de staging antes de publicar el dominio final. |
| URLs históricas ambiguas de propiedades | Inventario previo y tabla de mapeo explícita; no usar redirecciones masivas al listado. |
| IA altera información comercial sensible | Scopes mínimos, políticas, confirmación humana y ausencia de endpoints destructivos. |
| Actualización CKEditor rompe contenido existente | Pruebas con contenido real anonimizado, backup y rollout controlado. |
| Caché muestra disponibilidad desactualizada | TTL corto/invalidation por eventos para fichas y catálogo; no cachear respuestas autenticadas. |

## 11. Fuera de alcance de esta entrega

- Implementación completa del chatbot web o bot de WhatsApp.
- Automatización de cierre de ventas, cobros, contratos o cambios masivos de inventario.
- Migración de datos de la web vieja sin inventario y reglas aprobadas.
- Rediseño visual completo del portal o del backend administrativo.
- Exposición pública de datos privados de clientes, propietarios, asesores o documentos.

## 12. Dependencias y decisiones requeridas

- Acceso al repositorio Laravel, configuración de rutas y entorno staging.
- Acceso de lectura a hosting/DNS para preparar dominio y redirecciones.
- Decisión comercial sobre URL final de propiedades y migración de posts `/post` a `/blog`.
- Inventario de estados de propiedad que pueden ser públicos e indexables.
- Política de privacidad/consentimiento para leads y retención de registros API.
- Cuenta/configuración de Google Search Console y herramienta de analítica para validación posterior.

## 13. Entregables

- Código Laravel, migraciones reversibles y pruebas automatizadas.
- Configuración documentada de dominio, redirecciones, robots, sitemap y cache headers.
- Matriz de redirecciones antiguas → nuevas.
- Documentación OpenAPI de `/api/v1` y guía de autenticación/scopes.
- Registro de baseline y resultados de rendimiento antes/después.
- Checklist de QA y plan de reversión del despliegue.

