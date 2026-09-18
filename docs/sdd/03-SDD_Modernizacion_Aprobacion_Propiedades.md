# SDD — Modernización del módulo de aprobación de propiedades

## 1. Propósito

Modernizar el módulo existente de administración de propiedades para que un usuario con rol de administrador pueda revisar y aprobar una propiedad creada por él mismo u otro usuario del sistema. La modernización aplica exclusivamente al backend autenticado y debe conservar el comportamiento, rutas, datos y permisos ya existentes.

La aprobación debe poder realizarse desde el listado de propiedades mediante un interruptor (toggle), sin obligar al administrador a entrar a la pantalla de edición. El administrador mantiene además la posibilidad de abrir la propiedad y revisar su información completa antes de tomar la decisión.

## 2. Alcance

Incluye:

- Modernización visual y de interacción de las pantallas existentes de índice, detalle, creación y edición de propiedades en el backend.
- Estado visible de aprobación en el índice de propiedades.
- Toggle reactivo para aprobar o retirar aprobación desde el índice.
- Autorización exclusiva para administradores.
- Mensajes de éxito, error y estado de carga sin recargar innecesariamente la pantalla.
- Uso de CKEditor (o el editor enriquecido que ya esté integrado en la aplicación) en los campos descriptivos que actualmente admitan contenido enriquecido.
- Diseño mobile-first, accesible y consistente con el look & feel actual de Laravel/AdminLTE.

No incluye:

- Crear, eliminar o migrar tablas, campos o datos sin confirmar que el estado actual no lo soporte.
- Cambiar rutas públicas, URLs, parámetros, estructura de permisos actual ni reglas de publicación ya implementadas.
- Actualizar Laravel, AdminLTE, Bootstrap, Livewire u otras dependencias.
- Cambiar la experiencia pública de búsqueda o detalle de propiedades, salvo que consuma el estado de aprobación que ya exista.

## 3. Reglas de negocio

1. Solo los usuarios autenticados con permiso o rol de administrador pueden aprobar o retirar la aprobación de una propiedad.
2. Un administrador puede aprobar propiedades creadas por sí mismo o por cualquier otro usuario autorizado a crear propiedades.
3. Los usuarios no administradores pueden conservar las acciones que ya poseen, pero no deben visualizar un toggle accionable ni ejecutar el endpoint de aprobación.
4. El índice debe mostrar claramente si cada propiedad está `Aprobada` o `Pendiente de aprobación`.
5. Cada cambio realizado desde el toggle debe persistirse inmediatamente y reflejarse en la fila sin recargar toda la página.
6. Si un usuario pierde autorización, la operación debe rechazarse en servidor incluso si intenta invocar la ruta manualmente.
7. El SDD debe reutilizar el campo y la lógica de estado existentes. Si el módulo no cuenta con un campo de aprobación, se documentará primero el hallazgo y se solicitará definición antes de introducir una migración.

## 4. Experiencia de usuario

### Índice de propiedades

- Cabecera coherente con el backend actual, título, acción existente de crear propiedad y filtros ya disponibles.
- Tarjetas o tabla responsiva, según el patrón actual del módulo. En móvil, cada registro debe reordenarse en bloques legibles sin desplazamiento horizontal evitable.
- Cada propiedad mostrará como mínimo imagen principal o marcador, título, ubicación/resumen existente, creador cuando ya esté disponible, y badge de estado.
- El toggle se ubicará junto al estado, con etiqueta textual visible: `Aprobada` / `Pendiente`.
- Antes de cambiar de estado, se solicitará confirmación ligera y clara cuando el patrón actual de la aplicación lo permita: “¿Deseas aprobar esta propiedad?” o “¿Deseas retirar la aprobación?”.
- Durante la petición, el toggle queda deshabilitado y muestra un indicador de progreso; al finalizar se actualizan badge, etiqueta y control.
- Ante error, el estado visual vuelve al valor anterior y se muestra una alerta comprensible.

### Detalle, crear y editar

- Mantener los campos, validaciones y flujos actuales.
- Modernizar jerarquía visual, espaciado, agrupación de campos, botones y ayudas para que coincidan con el backend actual.
- Los campos de descripción, características, observaciones u otros contenidos largos que permitan formato enriquecido usarán CKEditor ya instalado o una integración compatible sin duplicar dependencias.
- CKEditor debe cargar el contenido existente sin alterarlo y enviar HTML saneado/validado según la estrategia ya utilizada por la aplicación.

## 5. Requisitos técnicos

### Backend

- Laravel conservará controladores, modelos, rutas y convenciones existentes siempre que sean compatibles.
- La autorización se implementará en servidor mediante middleware, policy/gate o la verificación de rol ya usada por la aplicación. No se confiará solamente en ocultar controles en Blade.
- El cambio de estado debe usar una acción explícita y protegida contra CSRF, preferiblemente `PATCH` o `POST` según la convención existente.
- Validar que la propiedad exista, que el administrador tenga autorización y que el estado enviado sea booleano válido.
- Responder JSON para la actualización reactiva, incluyendo identificador, estado final y texto de estado.
- Registrar los errores en el mecanismo existente de Laravel sin exponer detalles internos al usuario.

### Frontend

- Blade será la capa principal de renderizado.
- Usar JavaScript ligero o el mecanismo reactivo ya presente en el proyecto; no añadir un framework nuevo solo para el toggle.
- CSS con clases específicas y sin afectar componentes globales de AdminLTE.
- Mantener las rutas, identificadores y acciones existentes como fuente de verdad.
- Los cambios deben funcionar con teclado y no depender exclusivamente del color para indicar el estado.

## 6. Accesibilidad y diseño responsive

- Enfoque mobile-first; controles táctiles de al menos 44 × 44 px cuando aplique.
- Toggle con `label` asociada, nombre accesible, estado `checked` verificable por lector de pantalla y foco visible.
- Contraste mínimo AA entre texto, badges, fondo y controles.
- Mensajes de resultado anunciables con región `aria-live`.
- En pantallas pequeñas, acciones por fila apiladas o en menú accesible; no ocultar la información esencial.
- El texto del estado debe acompañar siempre al color e icono.

## 7. Seguridad

- Autenticación obligatoria en todas las rutas del backend.
- Autorización de administrador verificada en cada solicitud de cambio.
- Protección CSRF para solicitudes web.
- Escape de salida en Blade y sanitización/validación del HTML ingresado con CKEditor, conforme a las prácticas existentes.
- No exponer campos de edición, botones ni datos no permitidos a perfiles no administradores.

## 8. Criterios de aceptación

1. Un administrador ve todas las propiedades que ya puede consultar y puede abrir el detalle de cualquiera.
2. Un administrador puede aprobar una propiedad desde el índice mediante toggle.
3. Al aprobar, la fila cambia inmediatamente a `Aprobada` y conserva el resultado tras recargar la página.
4. Un administrador puede retirar la aprobación y ve el estado `Pendiente de aprobación`.
5. Un usuario no administrador no puede cambiar el estado desde la interfaz ni mediante una solicitud directa.
6. Un fallo de red o validación no deja un estado visual incorrecto; se informa el error y se restaura el valor anterior.
7. El índice y formularios son utilizables en móvil, tablet y escritorio.
8. Los campos enriquecidos conservan contenido existente y permiten editarlo correctamente con CKEditor.
9. Las rutas, datos existentes y funcionalidades no relacionadas siguen operando sin regresiones.

## 9. Pruebas requeridas

- Prueba de autorización: administrador permitido; no administrador rechazado.
- Prueba de persistencia: aprobar y retirar aprobación.
- Prueba de interfaz: actualización reactiva, carga, éxito y error.
- Prueba responsive en móvil y escritorio.
- Prueba de teclado, foco y lector de pantalla básico del toggle.
- Prueba de regresión de creación, edición, visualización y listado de propiedades.
- Prueba de CKEditor con contenido nuevo, contenido existente y caracteres especiales.

## 10. Entregable esperado

Una modernización del módulo backend de propiedades que conserve el comportamiento actual de la aplicación y permita a los administradores revisar y cambiar el estado de aprobación de manera rápida, clara, segura, accesible y reactiva desde el índice.
