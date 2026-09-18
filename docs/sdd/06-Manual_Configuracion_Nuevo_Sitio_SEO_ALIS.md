# Manual operativo — Configurar un nuevo sitio, dominio e indexación SEO en ALIS

## Antes de comenzar

Este manual aplica cuando esté implementada la funcionalidad descrita en el SDD `Funcionalidad reusable de SEO, indexación y preparación para IA en ALIS`.

La idea es simple: para un cliente nuevo no modificas rutas, canonicals, sitemap ni código. Configuras su marca y dominio en ALIS, conectas el dominio al servidor y validas la indexación.

Ejemplo usado en este manual:

- Dominio del cliente: `https://www.inmobiliariaejemplo.com`
- Dominio sin www: `https://inmobiliariaejemplo.com`

Reemplaza estos valores por los del cliente.

## Responsabilidades

| Responsable | Qué hace |
|---|---|
| Cliente | Da acceso al DNS o crea los registros solicitados; aprueba marca, textos legales y verificación de Google. |
| Administrador de servidor | Crea el sitio virtual, certificado SSL y redirecciones de host/protocolo. |
| Administrador ALIS | Configura la marca, dominio, SEO, contenido y estado de indexación. |
| Google Search Console | Verifica la propiedad, recibe el sitemap y muestra el estado de indexación. |

## Paso 1: Preparar los datos del cliente

Antes de tocar DNS o ALIS, reúne:

- Nombre comercial oficial.
- Dominio que se usará como principal, idealmente con `www`.
- Logo horizontal, favicon e imagen social.
- Teléfono, correo, WhatsApp, dirección y redes sociales.
- Texto de política de privacidad y términos de uso.
- Persona con acceso al panel DNS o proveedor de dominio.
- Cuenta de Google que administrará Google Search Console.

También define estas decisiones antes de publicar:

- ¿El dominio canónico será con `www` o sin `www`? Recomendado: con `www`.
- ¿El cliente trae un dominio anterior? Si sí, debe mantenerse como redirección 301.
- ¿Qué propiedades, zonas y posts pueden aparecer públicamente e indexarse?

## Paso 2: Conectar el dominio al servidor

Este paso se hace en el proveedor de DNS del cliente, como Cloudflare, GoDaddy, Namecheap o el registrador que utilice.

### Registros mínimos

| Tipo | Host | Valor | Uso |
|---|---|---|---|
| A | `@` | IP pública del servidor ALIS | Dominio sin www. |
| CNAME | `www` | `@` o hostname del servidor | Dominio con www. |

Si el proveedor no permite CNAME hacia `@`, crea un registro A para `www` con la misma IP pública del servidor.

No cambies los registros de correo (`MX`, SPF, DKIM, DMARC) del cliente.

### Verificación

Cuando DNS se haya propagado, valida que ambos hosts respondan:

- `http://inmobiliariaejemplo.com`
- `https://inmobiliariaejemplo.com`
- `http://www.inmobiliariaejemplo.com`
- `https://www.inmobiliariaejemplo.com`

Al final, las cuatro variantes deben terminar en:

`https://www.inmobiliariaejemplo.com/`

con código **301**. La ruta y los parámetros deben mantenerse; por ejemplo:

`http://inmobiliariaejemplo.com/propiedades/casa-ejemplo?utm_source=facebook`

debe terminar en:

`https://www.inmobiliariaejemplo.com/propiedades/casa-ejemplo?utm_source=facebook`

## Paso 3: Configurar HTTPS y redirecciones en el servidor

Este paso no se realiza dentro de ALIS. Se hace en Apache, Nginx, panel de hosting o proxy inverso.

Debe existir un certificado SSL válido para:

- `inmobiliariaejemplo.com`
- `www.inmobiliariaejemplo.com`

Configura estas reglas:

1. HTTP → HTTPS.
2. Host sin www → host con www.
3. Dominio antiguo → dominio nuevo, si el cliente trae uno.

No uses 302 para cambios permanentes de dominio. Usa 301.

Después de configurar el servidor, confirma que no exista un loop de redirecciones y que el certificado no muestre advertencias.

## Paso 4: Crear o seleccionar la organización/instalación en ALIS

En ALIS entra con una cuenta que tenga el permiso `site-settings.manage`.

Ruta esperada:

`Administración → Configuración del sitio público`

Si ALIS funciona como instalación única, abrirás la única configuración disponible. Si opera con varias inmobiliarias, primero selecciona la organización correcta. Nunca modifiques la configuración de otra organización.

## Paso 5: Configurar la marca y el dominio en ALIS

En `Configuración del sitio público`, completa los siguientes campos:

| Campo | Valor de ejemplo | Importancia |
|---|---|---|
| Nombre comercial | Inmobiliaria Ejemplo | Se usa en SEO y Schema. |
| Dominio canónico | `https://www.inmobiliariaejemplo.com` | Fuente oficial de URLs públicas. |
| Hosts alternos | `inmobiliariaejemplo.com` | Se redirige al dominio canónico. |
| Estado indexable | Desactivado inicialmente | Evita indexar antes de validar. |
| Logo y favicon | Archivos aprobados del cliente | Marca y resultados de búsqueda. |
| Imagen social predeterminada | Imagen 1200 × 630 px recomendada | Facebook, WhatsApp, LinkedIn. |
| Teléfono/WhatsApp/email/dirección | Datos verificados | Contacto y Schema. |
| Redes sociales | URLs oficiales | Schema y footer. |
| Meta descripción global | Texto breve y comercial | Fallback institucional. |
| Token de Search Console | Solo cuando Google lo entregue | Verificación del dominio. |

Guarda los cambios. El sistema debe invalidar la caché SEO/sitemap al modificar el dominio o la marca.

### Qué no debes modificar manualmente

- No edites `APP_URL` para cada cliente si la funcionalidad de contexto de sitio ya está implementada.
- No cambies URLs dentro de archivos Blade ni controladores.
- No edites `sitemap.xml` manualmente.
- No pongas el dominio en el código de Schema, Open Graph o canonical.

Los cambios de marca y dominio deben hacerse desde la configuración del sitio. `APP_URL` queda como configuración técnica del entorno y fallback seguro, no como fuente de SEO por cliente.

## Paso 6: Configurar contenido indexable

### Propiedades

En cada propiedad que el cliente quiera mostrar públicamente, confirma:

- estado publicado/público;
- slug único;
- zona asignada;
- precio, tipo, operación, habitaciones y disponibilidad correctos;
- imagen principal optimizada, con texto alternativo;
- título SEO y meta descripción cuando el caso lo requiera.

La URL esperada será:

`/propiedades/{slug}`

No publiques una propiedad si el detalle no abre con HTTP 200, si muestra datos incompletos o si debe permanecer privada.

### Zonas

En el módulo de zonas, completa:

- nombre;
- slug;
- H1;
- SEO title;
- meta description;
- descripción de la zona;
- imagen y texto alternativo, si aplica;
- estado público.

La URL esperada será:

`/propiedades/{slug-de-zona}`

Evita activar zonas vacías sin contenido editorial útil.

### Blog

Cada publicación debe tener:

- título;
- slug único;
- contenido revisado;
- estado publicado;
- SEO title y meta description;
- imagen de portada con texto alternativo.

La URL esperada será:

`/blog/{slug}`

No cambies un slug publicado por capricho. Si es imprescindible cambiarlo, registra la redirección 301 de la URL anterior a la nueva.

## Paso 7: Validación antes de permitir indexación

Mantén el campo `Estado indexable` desactivado hasta revisar esta lista.

| Verificación | Resultado esperado |
|---|---|
| Home | Responde 200, muestra marca correcta y canonical del dominio nuevo. |
| Propiedad | Responde 200, tiene H1, canonical propio y no redirige al listado. |
| Zona | Responde 200 y muestra únicamente inventario público de esa zona. |
| Post | Responde 200, H1, title, description y canonical propios. |
| URL antigua | Redirige 301 directamente a su equivalente actual. |
| Página inexistente | Responde 404; no se redirige a home ni al listado. |
| `/robots.txt` | Declara sitemap absoluto del dominio canónico. |
| `/sitemap.xml` | Es XML válido y todas sus URLs usan HTTPS y el dominio del cliente. |
| Sitemap | No incluye `.local`, `localhost`, staging, 3xx, 4xx, 5xx, borradores ni URLs de otra empresa. |
| Código fuente | Contiene canonical, Open Graph y JSON-LD con la marca/dominio correctos. |
| Celular | Navegación, filtros, formularios e imágenes funcionan correctamente. |

Cuando todo esté correcto, activa `Estado indexable` en ALIS.

## Paso 8: Configurar Google Search Console

Haz este paso usando la cuenta Google que administrará el sitio del cliente.

### Método recomendado: propiedad de dominio

1. Entra a Google Search Console.
2. Selecciona `Añadir propiedad`.
3. Elige `Dominio`.
4. Escribe: `inmobiliariaejemplo.com` sin `https` ni `www`.
5. Google mostrará un registro TXT.
6. Crea ese TXT en el DNS del cliente.
7. Espera propagación y pulsa `Verificar`.

Este método cubre HTTP, HTTPS, www y no-www.

### Alternativa: prefijo de URL

Si no tienes acceso DNS, crea una propiedad de prefijo exactamente con:

`https://www.inmobiliariaejemplo.com/`

Verifica con meta tag. Copia únicamente el token indicado en el campo `Google Search Console verification token` de ALIS; el sistema debe renderizar la etiqueta meta sin que tengas que editar código.

## Paso 9: Enviar sitemap e iniciar indexación

Dentro de Search Console:

1. Abre `Sitemaps`.
2. Introduce `sitemap.xml`.
3. Envía el sitemap.
4. Confirma que el estado sea correcto y que Google detecte las URLs.
5. Abre `Inspección de URL`.
6. Prueba la home, una propiedad, una zona y un post.
7. Si cada una puede indexarse, solicita indexación solo de esas URLs prioritarias.

No solicites indexación masiva de todas las páginas repetidamente. El sitemap actualizado es el mecanismo principal para descubrir cambios.

## Paso 10: Seguimiento durante las primeras semanas

Revisa semanalmente:

- Estado del sitemap.
- Páginas indexadas, excluidas y con errores.
- Canonical seleccionada por Google.
- Errores 404 y redirecciones.
- Core Web Vitals y rendimiento móvil.
- Consultas de búsqueda e impresiones.

Si Google muestra otra canonical, revisa primero:

1. si la página contiene un canonical correcto;
2. si existen duplicados por http, www, filtros o dominio anterior;
3. si hay una redirección incorrecta;
4. si el sitemap usa la URL canónica final.

## Cambio futuro de dominio

Cuando un cliente quiera mover su ALIS a un dominio nuevo:

1. Conecta DNS y SSL del nuevo dominio.
2. Agrega el nuevo dominio como canónico en ALIS.
3. Registra el dominio anterior como host alterno temporal.
4. Revisa todas las rutas principales antes de guardar.
5. Configura 301 en el servidor desde cada URL vieja a la misma ruta nueva.
6. Valida el nuevo sitemap y robots.
7. Verifica ambos dominios en Search Console.
8. Ejecuta `Cambio de dirección` en Search Console cuando aplique.
9. Mantén 301 por un mínimo de 12 meses.

Nunca retires el dominio viejo o sus redirecciones inmediatamente después del cambio.

## Problemas frecuentes

| Problema | Causa probable | Acción |
|---|---|---|
| Sitemap tiene `.local` | Dominio de desarrollo quedó en configuración/cache. | Verifica el dominio canónico, limpia caché SEO/sitemap y vuelve a validar. |
| Google no indexa una URL | `noindex`, canonical distinto, poco contenido, 404/redirect o bloqueo de robots. | Inspecciona la URL en Search Console y corrige la causa antes de volver a solicitar indexación. |
| Canonical muestra otro cliente | Contexto de sitio o host no está bien resuelto. | Revisa organización seleccionada, `site_hosts` y virtual host del servidor. |
| Propiedad va al listado | Ruta pública o slug no coincide con la entidad publicada. | Corrige la ruta/mapeo; no uses el listado como redirección de fallback. |
| Certificado SSL falla | DNS aún no apunta al servidor o faltan hosts en el certificado. | Confirma A/CNAME y vuelve a emitir/renovar el certificado. |
| Se ven datos de otra empresa | Falta filtro de contexto/tenant en consulta. | Desactiva indexación/API de inmediato y corrige aislamiento antes de publicar. |
| La web cambió pero Google muestra lo viejo | Caché, sitemap o rastreo pendiente. | Verifica respuesta pública/canonical, actualiza sitemap y espera nuevo rastreo. |

## Checklist final de publicación

- [ ] DNS de `@` y `www` apunta al servidor correcto.
- [ ] SSL válido para hosts requeridos.
- [ ] HTTP y hosts alternos redirigen 301 al canónico.
- [ ] Marca, contacto y redes configurados en ALIS.
- [ ] Dominio canónico configurado desde ALIS.
- [ ] Propiedades, zonas y posts revisados/publicados.
- [ ] Sitemap válido y limpio.
- [ ] Robots correcto.
- [ ] Canonical, Schema y Open Graph verificados en home, propiedad, zona y post.
- [ ] Estado indexable activado solo después de QA.
- [ ] Search Console verificada.
- [ ] Sitemap enviado.
- [ ] Baseline de PageSpeed/Lighthouse registrado.

## Nota sobre realestate.voipcom.net

La primera prueba debe realizarse con `https://realestate.voipcom.net/` configurado como dominio canónico e indexable. Cuando finalice la validación, el mismo procedimiento permitirá configurar cualquier dominio de cliente desde ALIS, sin editar código de SEO, sitemap, canonical o Schema.

