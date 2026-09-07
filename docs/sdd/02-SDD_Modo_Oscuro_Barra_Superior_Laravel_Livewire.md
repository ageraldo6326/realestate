---
title: "SDD — Modo oscuro con toggle en la barra superior"
product: "Aplicación Laravel + Livewire"
stack: "PHP 8.2.12 · Laravel y Livewire por confirmar · AdminLTE existente · MariaDB / MySQL"
status: "Aprobado para diseño; implementación condicionada a descubrimiento técnico"
version: "1.0"
date: "2026-09-07"
---

# SDD — Modo oscuro con toggle en la barra superior

## 1. Decisiones aprobadas

| Decisión | Valor acordado |
| --- | --- |
| Alcance visual | El modo oscuro se aplica a toda la aplicación autenticada, no solo a la barra superior. |
| Ubicación del control | Toggle visible en la barra superior. |
| Pantallas incluidas | Solo el panel autenticado. Login, páginas públicas y errores públicos permanecen sin cambios. |
| Tema inicial | Claro para usuarios nuevos y para quienes aún no tengan preferencia guardada. |
| Persistencia | Preferencia por usuario en base de datos mediante una migración aditiva. |
| Colores | Se conserva la identidad y los colores de marca existentes; se crean variantes oscuras accesibles. |
| Base de datos | Desarrollo con MariaDB y posible producción en MySQL. La solución debe ser compatible con ambos. |
| Seguridad de datos | Nunca borrar tablas, columnas, registros ni preferencias existentes. |

## 2. Objetivo

Agregar un control de claro/oscuro en la barra superior para que cada usuario autenticado pueda elegir el tema visual del panel. La selección se guarda en su perfil y se conserva al cambiar de dispositivo o iniciar una nueva sesión.

El cambio debe modernizar la experiencia sin alterar funcionalidades, navegación, rutas, permisos, datos de negocio, sesiones ni la integración existente con OpenAI para generación de textos.

## 3. Alcance

### Incluido

- Toggle accesible claro/oscuro dentro de la barra superior autenticada.
- Tema oscuro para el layout autenticado, menú lateral, cabecera, contenido, tarjetas, tablas, formularios, modales, dropdowns, alertas y estados visuales del panel.
- Persistencia por usuario del valor `light` o `dark`.
- Valor por defecto `light` para usuarios existentes y nuevos.
- Aplicación temprana del tema desde el servidor para evitar el destello de tema claro al cargar una página oscura.
- Implementación compatible con Laravel, Livewire, AdminLTE actual, MariaDB y MySQL.
- Feature flag para activar/desactivar la característica sin eliminar preferencias guardadas.
- Pruebas de contraste, teclado, móvil, escritorio, sesiones y aislamiento entre usuarios.

### Excluido

- Login, recuperación de contraseña, páginas públicas y páginas de error públicas.
- Modo automático según sistema operativo.
- Preferencias de color personalizadas por usuario.
- Cambios de marca, cambio de paleta principal o rediseño de módulos fuera de los estilos necesarios para tema oscuro.
- Cambio de rutas, controladores de negocio, políticas, roles, permisos, middleware, sesiones o endpoints.
- Cambios en la API de OpenAI, modelos, llaves, configuración o flujos de generación de textos.
- Actualizaciones de Laravel, PHP, Livewire, AdminLTE, Bootstrap, Font Awesome, Node o dependencias.

## 4. Restricciones de seguridad e integridad

El cambio es visual salvo una sola preferencia de usuario. Quedan prohibidos:

- `migrate:fresh`, `migrate:refresh`, `migrate:reset`, `db:seed`, `db:wipe`, `truncate`, `DELETE` masivo y cualquier comando de limpieza o reparación de datos.
- Borrar o renombrar tablas, columnas, filas, permisos, rutas, archivos de configuración o componentes existentes.
- Modificar datos de usuarios que no sean la preferencia del usuario autenticado que acciona el toggle.
- Ejecutar SQL manual en producción.
- Aplicar migraciones sin validar primero en un entorno de prueba y sin el respaldo operativo normal.

> **Excepción limitada aprobada:** se permite una única migración Laravel aditiva para agregar la preferencia de tema. Debe usar `ALTER TABLE` generado por Schema Builder, no eliminar datos y no tener una operación destructiva en `down()`.

## 5. Diseño de datos

### 5.1 Preferencia de tema

Antes de crear código se confirmará el modelo autenticable y su tabla real. Si corresponde a la tabla estándar `users`, se agregará una columna equivalente a:

| Campo | Tipo compatible MariaDB/MySQL | Nulo | Valor por defecto | Uso |
| --- | --- | --- | --- | --- |
| `ui_theme` | `VARCHAR(10)` | No | `light` | Preferencia visual: `light` o `dark`. |

No se usará `ENUM` para conservar flexibilidad y compatibilidad sencilla entre MariaDB y MySQL.

### 5.2 Migración no destructiva

La migración debe:

1. Verificar el nombre real de la tabla y confirmar que `ui_theme` no existe.
2. Agregar solo la columna nueva con `DEFAULT 'light'`.
3. No actualizar, borrar ni recrear registros existentes.
4. No ejecutar sentencias de limpieza ni de transformación masiva.
5. Tener `down()` explícitamente no destructivo: no eliminar la columna ni las preferencias si alguien intenta revertir código.

Pseudocódigo de referencia — la ruta y nombres se confirman en el repositorio:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('ui_theme', 10)->default('light');
});

// down(): sin operación destructiva deliberadamente.
```

La implementación real debe verificar la compatibilidad con las versiones concretas de MariaDB y MySQL antes de ejecutar `php artisan migrate`. La migración se ejecuta una sola vez, mediante el flujo normal de Laravel, únicamente después de aprobar la fase de pruebas.

### 5.3 Integridad y autorización

- El servidor acepta exclusivamente `light` o `dark`.
- El componente nunca recibe un `user_id` desde el navegador.
- Solo se actualiza `auth()->user()` o su equivalente actual.
- La preferencia no participa en permisos, roles, tenant/empresa, autenticación ni autorización.
- El campo se agrega a la configuración de asignación masiva solo si el proyecto la utiliza y después de revisar su modelo; se prefiere asignación explícita de una sola propiedad.

## 6. Diseño de interfaz

### 6.1 Toggle de la barra superior

El control se insertará en la barra superior del layout autenticado, en una posición que no desplace ni oculte notificaciones, perfil, acciones existentes o el botón de navegación móvil.

| Estado actual | Icono/etiqueta accesible | Acción |
| --- | --- | --- |
| Claro | `Activar modo oscuro` | Guarda `dark` y aplica el tema oscuro. |
| Oscuro | `Activar modo claro` | Guarda `light` y aplica el tema claro. |

Requisitos del control:

- Debe ser un `<button type="button">`, no un enlace ficticio.
- Debe incluir nombre accesible, `aria-pressed` y foco visible.
- Debe tener objetivo táctil mínimo de 44 × 44 px.
- Debe funcionar con teclado: `Tab`, `Enter` y `Space`.
- Mientras Livewire procesa el cambio, se deshabilita brevemente o comunica estado sin permitir clics duplicados.
- El icono nunca es la única indicación: tendrá texto accesible y *tooltip* visible en escritorio.

### 6.2 Ámbito de aplicación

Solo el layout autenticado añade el atributo de tema:

```html
<html data-theme="light">
```

o

```html
<html data-theme="dark">
```

El layout de login y las vistas públicas no reciben ese atributo ni cargan las variaciones específicas del panel. Por tanto, conservan exactamente su apariencia actual.

### 6.3 Paleta y contraste

La marca se conserva. No se invierten colores indiscriminadamente; cada superficie recibe un token oscuro con contraste suficiente.

| Token | Claro | Oscuro propuesto | Uso |
| --- | --- | --- | --- |
| `--app-bg` | Fondo actual claro | Azul/gris muy oscuro de la marca | Fondo de contenido autenticado. |
| `--surface` | Blanco actual | Superficie oscura elevada | Tarjetas, tablas, modales y dropdowns. |
| `--text-primary` | Tinta actual | Blanco/gris claro legible | Títulos y texto principal. |
| `--text-muted` | Gris actual | Gris claro de contraste AA | Metadatos y ayudas. |
| `--border` | Borde actual | Borde oscuro visible | Separadores y controles. |
| `--brand-*` | Colores actuales | Variantes oscuras o aclaradas | Marca, estados y acciones. |

Los colores semánticos de éxito, advertencia, error e información deben conservar significado y contraste. Ningún estado puede depender solamente del color.

## 7. Arquitectura técnica

### 7.1 Render inicial sin parpadeo

El layout autenticado obtiene la preferencia ya validada del usuario y renderiza `data-theme` desde el servidor. Esto evita que la página cargue primero clara y luego cambie a oscura mediante JavaScript.

Regla de resolución:

```text
si DARK_MODE_ENABLED es false  => light
si usuario autenticado no tiene ui_theme => light
si ui_theme es dark              => dark
en cualquier otro caso           => light
```

### 7.2 Componentes propuestos

Las rutas reales se determinan al revisar el repositorio y la versión de Livewire.

| Zona | Responsabilidad | Restricción |
| --- | --- | --- |
| Configuración UI | Expone `ui.dark_mode_enabled` desde `DARK_MODE_ENABLED`. | No modifica valores de la base de datos. |
| Layout autenticado | Define `data-theme` y carga los estilos del panel. | No cambia login ni vistas públicas. |
| Componente Livewire `ThemeToggle` | Cambia y persiste la preferencia del usuario actual. | Solo acepta `light`/`dark`; no acepta IDs de usuario. |
| Partial Blade de topbar | Ubica el botón sin alterar enlaces/acciones existentes. | Conserva todos los controles ya presentes. |
| Hoja CSS de tema | Declara tokens y overrides dentro de `[data-theme="dark"]`. | Sin selectores globales destructivos ni dependencias nuevas. |
| Pruebas | Verifican persistencia, aislamiento y visualización segura. | No requieren borrar ni resembrar datos. |

Estructura sugerida, pendiente de confirmar el árbol actual:

```text
config/ui.php                                 # o configuración existente
app/Livewire/ThemeToggle.php                  # o ruta equivalente de la versión instalada
resources/views/livewire/theme-toggle.blade.php
resources/views/layouts/<layout-auth>.blade.php
resources/views/<partial-topbar>.blade.php
resources/css/components/theme.css
database/migrations/<fecha>_add_ui_theme_to_users_table.php
tests/Feature/ThemeToggleTest.php
```

### 7.3 Cambio de preferencia

Flujo esperado:

1. Usuario autenticado pulsa el botón del topbar.
2. El componente determina el valor opuesto permitido.
3. El servidor valida el valor contra `light|dark`.
4. El servidor guarda solo `ui_theme` del usuario autenticado.
5. Livewire actualiza el atributo del layout o emite un evento local controlado para actualizarlo sin recarga completa.
6. En la siguiente página, el servidor vuelve a renderizar el mismo tema guardado.

No se utiliza API externa, petición remota adicional, `localStorage` como fuente de verdad ni consulta de datos de negocio.

## 8. Compatibilidad con AdminLTE y Livewire

- El CSS nuevo se carga después de los estilos existentes del panel para definir tokens, sin modificar archivos del proveedor.
- Los overrides se limitan a `[data-theme="dark"]` y a una clase raíz del panel autenticado; no afectan login ni páginas públicas.
- Deben revisarse con especial cuidado los estilos inline, colores hardcoded, gráficos, tablas de DataTables si existen, componentes Select2 si existen y *plugins* de AdminLTE detectados en el código real.
- El toggle debe reutilizar el mecanismo actual de componentes Livewire; no se agrega Alpine, Vue, React ni una librería de temas.
- No se cambian el menú lateral ni sus permisos. El SDD de modernización de navegación sigue siendo independiente y compatible.

## 9. Plan de implementación seguro

### Fase 0 — Descubrimiento y punto de control

1. Confirmar versión real de Laravel, Livewire, AdminLTE/Bootstrap, herramienta de assets y comando de pruebas.
2. Localizar el layout autenticado, partial de barra superior, modelo autenticable y tabla real de usuarios.
3. Identificar el mecanismo actual de roles/permisos y confirmar que el cambio no lo toca.
4. Verificar versiones objetivo de MariaDB y MySQL, además de respaldos y procedimiento de despliegue.
5. Si algún hallazgo exige modificar datos, rutas, dependencias, sesión, API de OpenAI o permisos, detenerse y pedir aprobación.

### Fase 1 — Migración aditiva en entorno de prueba

1. Crear una rama exclusiva; no trabajar directamente sobre la rama principal ni producción.
2. Crear la única migración aditiva para `ui_theme` después de confirmar tabla y columna.
3. Ejecutar únicamente `php artisan migrate` en un entorno de prueba autorizado.
4. Verificar conteo de usuarios antes y después, y comprobar que todos resuelven tema claro por defecto.
5. Probar la misma migración contra MariaDB y la versión MySQL prevista si hay ambiente disponible.

### Fase 2 — Toggle y tokens

1. Implementar el componente Livewire y las pruebas de autorización/validación.
2. Insertar el toggle en el topbar autenticado sin eliminar elementos existentes.
3. Implementar tokens y variaciones para superficies del panel.
4. Aplicar el atributo de tema en el render inicial y validar ausencia de parpadeo.

### Fase 3 — Cobertura visual y accesibilidad

1. Revisar dashboard, menú lateral, tarjetas, tablas, formularios, modales, dropdowns, alertas, paginación y estados de Livewire.
2. Validar a 320 px, 768 px, 1024 px y 1440 px.
3. Validar Android Chrome, Safari de iPhone, Chrome y Edge de escritorio.
4. Corregir solamente problemas visuales o de accesibilidad dentro del alcance; ante un riesgo funcional, detenerse y consultar.

### Fase 4 — Piloto, salida y rollback

1. Activar primero el flag para QA o usuarios internos, según la capacidad actual del proyecto.
2. Observar errores 4xx/5xx, errores JavaScript, carga de páginas y comentarios de usuarios.
3. Activar globalmente solo cuando la matriz de aceptación se complete.
4. Si aparece una regresión, desactivar el flag; no ejecutar `migrate:rollback` ni borrar la columna o las preferencias.

## 10. Plan de pruebas y criterios de aceptación

| ID | Escenario | Resultado esperado |
| --- | --- | --- |
| THEME-01 | Usuario sin preferencia | Layout autenticado aparece claro. |
| THEME-02 | Usuario nuevo | La columna toma `light` por defecto, sin modificar otros datos. |
| THEME-03 | Activar oscuro | Se guarda `dark` solo en el usuario actual y el panel cambia correctamente. |
| THEME-04 | Cambiar de página/sesión/dispositivo | El mismo usuario conserva su tema guardado. |
| THEME-05 | Dos usuarios distintos | Cada uno ve y conserva solo su propia preferencia. |
| THEME-06 | Valor inválido | El servidor rechaza cualquier valor distinto de `light` o `dark`. |
| THEME-07 | Flag apagado | Todo el panel autenticado se muestra claro sin borrar `ui_theme`. |
| THEME-08 | Login/páginas públicas | Se ven igual que antes, sin toggle ni tema oscuro. |
| THEME-09 | Teclado y lector | Botón con nombre, foco, `aria-pressed` y operación por teclado. |
| THEME-10 | Móvil | Toggle visible, tocable y sin desbordamiento en 320 px. |
| THEME-11 | Contraste | Texto, iconos, bordes y estados cumplen contraste AA. |
| THEME-12 | Datos | Sin registros borrados, sin tablas/columnas eliminadas y sin comandos destructivos. |

La entrega se acepta cuando:

- El panel autenticado opera completo en ambos temas.
- Los colores de marca se conservan con contraste adecuado.
- El usuario puede cambiar el tema desde la barra superior sin duplicar peticiones ni alterar otras preferencias.
- La preferencia es consistente tras recargar, navegar e iniciar sesión de nuevo.
- Login y páginas públicas no presentan cambios visuales.
- El flag permite volver a claro sin tocar datos.
- La migración es exclusivamente aditiva y las pruebas no revelan cambios en registros ajenos a `ui_theme` del usuario que actuó.

## 11. Rollback y gestión de riesgos

### 11.1 Rollback operativo

El rollback será de código/configuración, no de base de datos:

1. Establecer `DARK_MODE_ENABLED=false` o su equivalente de configuración.
2. Seguir el procedimiento normal del proyecto para recargar configuración y assets.
3. Confirmar que el panel autenticado vuelve a claro.
4. Conservar la columna `ui_theme` y sus valores para permitir una reactivación futura segura.

No se ejecuta `migrate:rollback`, no se elimina la columna y no se pierde ninguna preferencia.

### 11.2 Riesgos y respuesta

| Riesgo | Prevención | Respuesta |
| --- | --- | --- |
| Selector CSS afecta login | Limitar tokens a layout autenticado y `[data-theme="dark"]`. | Desactivar flag y aislar selector. |
| Bajo contraste | Revisar tokens y estados en cada componente. | Ajustar tonos, no reemplazar colores de marca. |
| Preferencia de otro usuario modificada | Usar siempre usuario autenticado; no aceptar ID cliente. | Desactivar flag si es necesario, auditar y detenerse para aprobación. |
| Migración incompatible | Probar primero en MariaDB/MySQL objetivo. | Detener despliegue, no ejecutar SQL manual ni destructivo. |
| Parpadeo de tema | Render inicial por servidor. | Corregir layout antes de liberar. |
| Estilo AdminLTE hardcoded | Inventario visual de componentes y override localizado. | Corregir CSS aislado o desactivar flag. |

## 12. Información que debe verificarse antes de implementar

- Salida de `php artisan --version` desde el proyecto, no del instalador Laravel.
- Versión instalada de Livewire y su estructura de componentes.
- Ubicación del layout autenticado y del partial actual de barra superior.
- Tabla y modelo de usuario efectivos, incluyendo configuración de asignación masiva.
- Versiones exactas de MariaDB y MySQL de producción.
- Comando de pruebas disponible y existencia de ambiente de QA/staging.
- Nombre de la rama principal y flujo de despliegue Git actual.

## 13. Aprobación

Este SDD autoriza el diseño y, tras la verificación de la fase 0, una sola migración aditiva de preferencia de tema y los cambios visuales asociados. No autoriza modificaciones de datos de negocio, borrados, cambios de autorización, rutas, dependencias, integraciones externas ni páginas públicas.

| Campo | Valor |
| --- | --- |
| Aprobado por |  |
| Fecha |  |
| Observaciones |  |
