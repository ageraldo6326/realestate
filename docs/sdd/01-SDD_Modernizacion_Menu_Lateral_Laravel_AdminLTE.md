---
title: "SDD — Modernización no disruptiva del menú lateral"
product: "Aplicación CRM / gestión inmobiliaria"
stack: "Laravel + Livewire + PHP 8.2.12 + AdminLTE existente"
status: "Pendiente de validación técnica del repositorio"
version: "1.1"
date: "2026-09-07"
---

# Modernización no disruptiva del menú lateral

## 1. Propósito

Modernizar la apariencia y experiencia del menú lateral existente basado en AdminLTE, manteniendo intactas sus funciones, rutas, permisos, contadores, sesiones y acciones.

La aplicación usa Laravel, Livewire y PHP 8.2.12. La versión exacta del framework, Livewire, AdminLTE, Bootstrap y el pipeline de assets se confirmará al inspeccionar el repositorio. La base de datos actual es MariaDB y producción podría operar con MySQL; este alcance no modifica la base de datos.

> **Decisión principal:** reemplazar únicamente la capa visual e interactiva de navegación. El nuevo menú reutilizará el origen actual de ítems, rutas, condiciones de visibilidad, badges y formularios.

## 2. Objetivos

- Ofrecer una navegación clara, moderna, amigable y *mobile-first*.
- Mantener la paridad funcional uno a uno con el menú actual para cada rol.
- Usar componentes Blade/Livewire, CSS aislado y JavaScript ligero compatible con el proyecto.
- Permitir la activación gradual y el retorno inmediato al menú legacy mediante *feature flag*.
- Cumplir accesibilidad básica: teclado, foco visible, contraste AA, etiquetas semánticas y controles táctiles adecuados.

## 3. Fuera de alcance y prohibiciones

Esta entrega **no autoriza**:

- Modificar, borrar, truncar, sembrar o actualizar masivamente datos.
- Crear o modificar migraciones, tablas, columnas, índices, modelos o consultas de negocio.
- Ejecutar `php artisan migrate`, `db:seed`, `migrate:fresh`, `migrate:refresh`, `migrate:reset`, `truncate`, `DELETE` masivo ni comandos de reparación de datos.
- Cambiar rutas, controladores, endpoints, métodos HTTP, políticas, Gates, middleware, roles o permisos.
- Actualizar Laravel, PHP, Livewire, AdminLTE, Bootstrap, Font Awesome, Node, Vite/Mix o dependencias como parte de este trabajo.
- Alterar la integración de OpenAI, su modelo, endpoint, credenciales, límites o flujos de generación de texto.
- Rediseñar pantallas internas, tablas, formularios, módulos CRM o lógica de negocio ajena a la navegación.

Si una necesidad técnica parece exigir alguno de esos cambios, el trabajo se detiene, se documenta el riesgo y se solicita aprobación explícita antes de continuar.

## 4. Referencia de experiencia

La referencia visual esperada es un lateral claro, con jerarquía por secciones, buscador local de opciones, *badges* discretos, ítem activo visible y perfil de usuario anclado al pie. La imagen de referencia debe mantenerse en el proyecto como `design/screen.png`.

| Elemento | Especificación propuesta | Regla de compatibilidad |
| --- | --- | --- |
| Lateral | Fondo blanco, borde sutil; 304 px expandido y 76 px compacto en escritorio. | No modifica el contenido ni el ancho de módulos existentes fuera de la clase de layout controlada. |
| Marca | Logo y enlace actuales; texto visible expandido y nombre accesible en compacto. | Reutiliza el asset y URL actuales. |
| Secciones | Grupos semánticos surgidos del inventario real: Principal, Reportes, Administración u otros. | Ningún ítem actual se elimina por estética. |
| Ítem activo | Fondo lavanda suave, acento verde, icono y texto de alto contraste. | Usa la misma regla actual de ruta/request. |
| Badges | Píldoras compactas para contadores y estados. | Reutiliza el valor ya calculado; no añade consultas. |
| Perfil y logout | Tarjeta de usuario fija al pie. | Conserva el formulario `POST`, CSRF y middleware del cierre de sesión. |

### 4.1 Tokens visuales iniciales

```css
--sidebar-bg: #ffffff;
--sidebar-ink: #18233f;
--sidebar-muted: #667085;
--sidebar-active-bg: #f3f1ff;
--sidebar-active-accent: #047857;
--sidebar-badge: #e8e9ff;
--sidebar-border: #dde2ea;
```

Los tokens podrán ajustarse a la identidad visual real, siempre verificando contraste y sin afectar estilos globales de AdminLTE.

## 5. Requisitos funcionales

### 5.1 Inventario obligatorio antes de editar

Antes de modificar una vista, se debe inventariar el menú real. Cada entrada del menú legacy debe tener un identificador estable y una fila de comparación con su representación moderna.

| Campo | Validación |
| --- | --- |
| ID lógico y etiqueta | Conserva la etiqueta actual, salvo cambio de texto aprobado. |
| Destino | Misma URL o nombre de ruta, parámetros, *query string*, `target` y comportamiento externo. |
| Autorización | Misma condición de rol, permiso, Gate, Policy o tenant/empresa. |
| Jerarquía | Mismo padre, submenú, orden funcional y expansión para la ruta activa. |
| Badge | Misma fuente, valor y condición de visibilidad; sin *queries* duplicadas. |
| Acción | Mismo método HTTP, CSRF, confirmación y *handler*; especialmente logout. |

### 5.2 Escritorio

- Desde 1200 px, el lateral permanece visible y puede colapsarse mediante un botón accesible.
- El modo compacto conserva iconos, *tooltips*, foco visible, etiquetas accesibles y destinos funcionales.
- Cada submenú usa un botón propio con `aria-expanded`; la rama activa se abre automáticamente.
- La preferencia visual de colapsado puede guardarse en `localStorage` con clave versionada `ui.sidebar.v1`; nunca en base de datos.

### 5.3 Tableta y móvil

- Por debajo de 1200 px, el lateral pasa a ser un *drawer* superpuesto, sin deformar los módulos existentes.
- El *drawer* incluye fondo modal, cierre por botón, `Escape`, toque fuera y navegación a un enlace.
- Al abrir, el foco queda dentro del *drawer* y al cerrar regresa al control que lo abrió.
- A 768 px o menos, cada objetivo táctil mide al menos 44 × 44 px.
- El menú tiene desplazamiento interno; al cerrarlo se restaura el estado de scroll del documento.
- La interfaz debe funcionar correctamente desde 320 px de ancho.

### 5.4 Búsqueda de acciones

La búsqueda filtra localmente solo los ítems ya autorizados y renderizados para el usuario actual. Puede buscar etiqueta, sinónimos aprobados y grupo de navegación.

No es un buscador global: no consulta propiedades, clientes, contactos, ni datos de negocio; no llama APIs y no revela entradas no autorizadas.

## 6. Diseño técnico

### 6.1 Principio de adaptación

La fuente de verdad de la navegación sigue siendo la existente. Un adaptador normaliza el arreglo, *builder*, configuración o *partial* que AdminLTE ya consume. Así el menú moderno es intercambiable y no duplica reglas de negocio.

| Capa | Responsabilidad | Restricción |
| --- | --- | --- |
| Origen actual de menú | Labels, rutas, iconos, permisos, submenús, badges y acciones. | No se reescribe ni se mueve a la base de datos. |
| `NavigationAdapter` | Normaliza datos hacia un DTO de vista. | No consulta modelos de negocio ni decide permisos nuevos. |
| Blade / Livewire | Renderiza secciones, enlaces, badges, perfil y controles interactivos. | Escapa contenido y no construye URLs manualmente. |
| CSS aislado | Estados, tokens, responsive y transiciones. | Usa namespace; no sobrescribe AdminLTE globalmente. |
| JavaScript ligero | Drawer, foco, submenús y filtro local. | Sin nuevas dependencias, llamadas remotas ni mutación de datos. |

### 6.2 Modelo normalizado de ítem

```php
[
    'key' => 'crm.contacts.index',
    'label' => 'Contactos',
    'searchTerms' => ['clientes', 'leads'],
    'url' => '...',
    'icon' => '...',
    'visible' => true,
    'active' => false,
    'expanded' => false,
    'badge' => null,
    'children' => [],
    'action' => null,
]
```

Todos los campos se derivan del menú existente y viven solo durante el *request* actual.

### 6.3 Estructura propuesta

Las rutas exactas se validarán en el repositorio. Esta es una propuesta, no una instrucción de crear archivos sin verificar el stack actual.

| Archivo o zona | Uso |
| --- | --- |
| `config/ui.php` o configuración existente | Feature flag `ui.modern_sidebar` respaldado por `MODERN_SIDEBAR=false`. |
| `app/Support/Navigation/NavigationAdapter.php` | Adaptador puro del menú legacy. |
| `app/View/Composers/NavigationComposer.php` | Solo si el proyecto ya usa *composers*. |
| `resources/views/components/navigation/modern-sidebar.blade.php` | Marcado semántico del menú moderno. |
| `resources/views/layouts/partials/sidebar-switcher.blade.php` | Selecciona legacy o moderno por flag. |
| `resources/css/components/modern-sidebar.css` | Estilos bajo `.app-modern-sidebar`. |
| `resources/js/navigation/modern-sidebar.js` | Drawer, foco, submenús y filtro local. |
| `tests/Feature/Navigation/` | Pruebas de paridad, permisos, logout y DOM responsive. |

### 6.4 Selección segura por feature flag

```php
$sidebarView = config('ui.modern_sidebar')
    ? 'navigation.modern-sidebar'
    : $legacySidebarPartial;

@include($sidebarView, ['menu' => $navigation])
```

El flag solo decide qué vista se renderiza. No cambia datos, rutas ni contratos. Ante un incidente, `MODERN_SIDEBAR=false` devuelve al menú legacy en el siguiente *request*.

## 7. Compatibilidad, seguridad e integridad

| Área | Compromiso | Evidencia |
| --- | --- | --- |
| Base de datos | Cero cambios a tablas, registros o esquema. | Diff sin migraciones y registro de comandos sin `artisan migrate`. |
| Rutas y URLs | Cada `href` o `action` conserva destino y parámetros. | Matriz de paridad y prueba manual por rol. |
| Permisos | Se reutilizan las condiciones actuales. | Casos autenticados y no autorizados. |
| Sesión | Login, logout, CSRF, expiración y redirecciones no cambian. | Prueba de sesión y formulario `POST`. |
| API OpenAI | No se modifica código, configuración, credenciales ni flujo. | Diff sin cambios en su integración. |
| Operación | Legacy permanece activo durante el piloto. | Rollback por flag probado en QA. |

Reglas adicionales:

- Escapar etiquetas, badges y atributos mediante Blade; no renderizar HTML arbitrario.
- Mantener acciones sensibles como formularios protegidos; no convertir logout en enlace `GET`.
- Filtrar en servidor los ítems no visibles, sin enviarlos al DOM.
- Permitir solo iconos y clases de un mapa conocido.
- No añadir CDN ni dependencias de producción.

## 8. Accesibilidad

- Usar `<nav aria-label="Navegación principal">`, listas y enlaces reales.
- Dar nombres accesibles a contraer, abrir/cerrar submenú y cerrar *drawer*.
- Mantener orden de tabulación lógico, foco siempre visible y `Escape` funcional.
- Asegurar contraste WCAG AA como mínimo.
- No comunicar estado, selección o alerta solo por color.
- Mantener texto legible al aumentar el zoom del navegador al 200 %.

## 9. Plan de implementación

### Fase 0 — Preparación

1. Crear una rama exclusiva; no trabajar directamente sobre producción ni sobre la rama principal.
2. Confirmar versiones reales con `php artisan --version`, Composer y `package.json`.
3. Confirmar comando de pruebas y ambiente de QA.
4. Realizar el respaldo operativo normal antes de un despliegue, sin restaurar ni manipular datos durante este cambio.

### Fase 1 — Descubrimiento

1. Localizar el origen efectivo del menú: configuración AdminLTE, *partial* Blade, *composer*, clase de menú o combinación.
2. Completar el inventario para todos los roles, subítems, badges, enlaces externos y acciones `POST`.
3. Identificar scripts, selectores y plugins legacy dependientes del HTML actual.
4. Si aparece una ambigüedad funcional o un posible impacto, detenerse y preguntar antes de modificar.

### Fase 2 — Render paralelo

1. Crear y probar el adaptador, usando el menú actual como entrada.
2. Implementar el nuevo lateral detrás del flag, sin editar el *partial* legacy salvo el punto de selección previamente validado.
3. Comparar cada URL, permiso y acción contra el inventario.

### Fase 3 — Estilos y comportamiento

1. Agregar CSS con namespace y sin sustituir estilos globales.
2. Implementar comportamiento móvil, manejo de foco, submenús y preferencia local.
3. Revisar visualmente 320 px, 768 px, 1024 px y 1440 px.

### Fase 4 — QA, piloto y liberación

1. Ejecutar pruebas automatizadas y la matriz manual.
2. Activar primero para usuarios internos o piloto mediante feature flag/allowlist, si el proyecto lo permite.
3. Revisar errores frontend, respuestas 403/404/5xx y comentarios del piloto.
4. Activar globalmente solo tras cumplir los criterios de aceptación.

## 10. Matriz de pruebas

| ID | Escenario | Resultado esperado |
| --- | --- | --- |
| NAV-01 | Ítems de Super Admin | Etiqueta, icono, badge y URL coinciden con el inventario. |
| NAV-02 | Roles restringidos | Ningún ítem no autorizado aparece ni es accesible. |
| NAV-03 | Ruta activa en submenú | Padre expandido e hijo marcado, sin alterar URL. |
| NAV-04 | Badge | Mismo valor/fuente; no aparecen consultas adicionales. |
| NAV-05 | Logout | `POST` con CSRF, cierre y redirección actuales. |
| NAV-06 | Escritorio compacto | Tooltips, iconos, foco y teclado funcionan. |
| NAV-07 | Drawer móvil | Backdrop, foco, Escape, cierre y scroll correctos. |
| NAV-08 | Flag desactivado | Se renderiza el menú AdminLTE original. |
| NAV-09 | Datos | Sin migraciones ni cambios de contenido atribuibles a la entrega. |
| NAV-10 | Navegadores | Chrome Android, Safari iPhone, Chrome y Edge escritorio sin errores JS. |

### Criterios de aceptación

- Paridad de navegación del 100 % con el inventario para el mismo perfil.
- Cero cambios de base de datos.
- Cero regresiones en autenticación, autorización, logout, enlaces externos y badges.
- Diseño utilizable desde 320 px y hasta escritorio amplio.
- Rollback por feature flag probado antes de liberar.

## 11. Rollback y riesgos

El rollback no requiere restaurar una base de datos porque el cambio no la toca. Ante un incidente, se desactiva `MODERN_SIDEBAR`, se sigue el procedimiento normal de carga de configuración del proyecto y se valida la vuelta al *partial* AdminLTE original.

| Riesgo | Prevención | Respuesta |
| --- | --- | --- |
| Colisión CSS | Namespace `.app-modern-sidebar` y pruebas representativas. | Desactivar flag, aislar selector y repetir QA. |
| Ítem omitido o URL alterada | Inventario y pruebas de paridad. | Desactivar flag, corregir adaptador y validar rol. |
| Permiso expuesto | Filtrado servidor con condiciones existentes. | Desactivar de inmediato; revisar logs; solicitar revisión si hay datos expuestos. |
| Plugin dependiente del markup legacy | Mapear handlers antes de editar. | Restaurar legacy y definir solución en un SDD adicional. |
| Rendimiento de badges | Reutilizar datos existentes y medir requests. | Eliminar consulta nueva y pasar valor ya calculado. |

## 12. Anexo — Inventario inicial por completar

| Sección | Ítem actual | Ruta / acción | Permiso | Badge | Estado |
| --- | --- | --- | --- | --- | --- |
| Principal | Dashboard | Pendiente de código | Pendiente | Opcional | Pendiente |
| Principal | Propiedades | Pendiente de código | Pendiente | Activas | Pendiente |
| Principal | Contactos | Pendiente de código | Pendiente | Total | Pendiente |
| Principal | Tareas y agenda | Pendiente de código | Pendiente | Pendientes | Pendiente |
| Reportes | Reportes y métricas | Pendiente de código | Pendiente | Opcional | Pendiente |
| Administración | Sistema y ajustes | Pendiente de código | Pendiente | No | Pendiente |
| Acción | Cerrar sesión | POST actual + CSRF | Autenticado | No | Pendiente |

## 13. Aprobación

La aprobación de este SDD autoriza solo el descubrimiento y la implementación de la capa de navegación descrita. Cualquier cambio de datos, permisos, rutas, dependencias, API de OpenAI o arquitectura requiere una ampliación documentada y aprobación separada.

| Campo | Valor |
| --- | --- |
| Aprobado por |  |
| Fecha |  |
| Observaciones |  |
