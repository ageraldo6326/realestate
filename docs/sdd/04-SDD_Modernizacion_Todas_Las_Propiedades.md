# SDD — Modernización del módulo “Todas las propiedades”

## 1. Propósito

Modernizar la pantalla existente “Todas las propiedades” del backend autenticado para que el usuario autorizado consulte el inventario completo de propiedades registrado en el sistema, sin limitar el resultado a las propiedades creadas por él.

La modernización debe conservar la consulta global que ya tiene el módulo, sus permisos, rutas, datos y reglas actuales. Su objetivo es ofrecer una experiencia más clara, rápida, mobile-first y coherente con el look & feel vigente de Laravel/AdminLTE.

## 2. Alcance

Incluye:

- Modernización visual y de interacción de la pantalla de índice “Todas las propiedades”.
- Visualización del inventario global conforme a la autorización ya existente.
- Búsqueda, filtros, ordenamiento y paginación existentes, presentados de manera más clara y responsive.
- Acceso al detalle de cada propiedad que el usuario ya tenga permiso de consultar.
- Estados visibles ya disponibles, por ejemplo aprobación, publicación, disponibilidad o cualquier estado existente.
- Mensajes de carga, estado vacío y error sin recargas innecesarias cuando el mecanismo actual permita actualización reactiva.
- Diseño responsive, accesible y consistente con el backend actual.

No incluye:

- Limitar el resultado a propiedades del usuario actual.
- Ampliar o reducir los permisos existentes para ver inventario, editar, aprobar, publicar o eliminar.
- Crear migraciones, tablas, campos, datos de prueba o cambios masivos de datos.
- Cambiar rutas, URLs, parámetros, métodos HTTP, reglas de publicación o controladores fuera de lo necesario para la presentación.
- Actualizar Laravel, AdminLTE, Bootstrap, Livewire, CKEditor u otras dependencias.
- Agregar edición de descripciones dentro del índice. Los campos con editor enriquecido se mantendrán únicamente en los formularios existentes que ya los utilicen.

## 3. Reglas de negocio

1. El módulo debe mostrar el inventario completo que la consulta actual expone, no solo las propiedades creadas por el usuario conectado.
2. La visibilidad de los registros será gobernada por los permisos, scopes, middleware y políticas ya existentes; la modernización no los reemplaza.
3. El usuario podrá abrir el detalle de una propiedad únicamente si ya cuenta con la autorización actual para hacerlo.
4. Los estados de cada propiedad se mostrarán como información; las acciones de edición, aprobación, publicación o eliminación conservarán exactamente sus permisos actuales.
5. El listado debe mantener filtros, búsqueda, orden y paginación actuales. Si alguno no existe, no se incorporará una regla de negocio nueva sin validación funcional previa.
6. La interfaz no debe revelar información de propiedades que el backend no entregue al usuario autorizado.

## 4. Experiencia de usuario

### Cabecera y resumen

- Título: `Todas las propiedades`.
- Breve texto de apoyo: “Consulta el inventario completo registrado en el sistema”.
- Mostrar el total de resultados únicamente cuando la consulta actual lo permita.
- Mantener las acciones existentes, como crear propiedad o exportar, sin modificar permisos ni comportamiento.

### Listado global

- En escritorio se podrá conservar tabla o tarjetas según el patrón existente; en móvil, cada propiedad se reorganizará como tarjeta vertical legible.
- Cada registro presentará los datos ya disponibles y relevantes: imagen principal o marcador, título, tipo, ubicación, precio, creador/agente cuando exista, fecha y estados.
- El título o acción `Ver detalle` permitirá acceder a la ficha existente.
- Badges de estado con texto explícito, icono opcional y color no exclusivo como medio de identificación.
- Acciones secundarias en un menú o grupo de botones accesible, respetando las autorizaciones actuales.

### Búsqueda, filtros y navegación

- La búsqueda y filtros existentes deben permanecer visibles y utilizables en móvil.
- En pantallas pequeñas, los filtros podrán mostrarse en un panel desplegable accesible, conservando los valores seleccionados.
- Los filtros aplicados se mostrarán como resumen o etiquetas removibles solo si ese comportamiento no altera los parámetros actuales.
- La paginación conservará URL, parámetros y orden existentes. Debe ofrecer objetivos táctiles adecuados y una indicación clara de la página actual.
- Cuando el proyecto ya disponga de un mecanismo reactivo, la aplicación de búsqueda, filtros o paginación mostrará carga y actualizará únicamente el contenido necesario.

### Estados de interfaz

- Estado de carga: indicador discreto, sin ocultar la estructura de la pantalla.
- Sin resultados: mensaje claro, con opción de limpiar filtros cuando corresponda.
- Error: alerta entendible sin mostrar detalles internos; conservar los filtros que el usuario había seleccionado cuando sea posible.

## 5. Requisitos técnicos

### Backend

- Reutilizar controlador, modelo, query scopes, rutas, middleware y políticas existentes como fuente de verdad.
- No reemplazar la consulta global por una consulta filtrada al usuario autenticado.
- Validar y normalizar los parámetros de búsqueda, filtros, orden y página conforme a las reglas actuales.
- Mantener los métodos HTTP, formato de respuesta, paginación y parámetros públicos ya usados por el módulo.
- Aplicar la autorización en servidor antes de devolver el listado y antes de exponer acciones por registro.
- Registrar errores con el mecanismo existente de Laravel sin enviar información sensible a la interfaz.

### Frontend

- Blade será la capa principal de renderizado.
- Usar JavaScript ligero o el mecanismo reactivo ya presente; no introducir un framework nuevo.
- Mantener CSS encapsulado con clases propias para no afectar componentes globales de AdminLTE.
- Evitar peticiones duplicadas en búsqueda y filtros; deshabilitar temporalmente los controles que estén procesando una acción.
- Mantener compatibilidad con la funcionalidad existente de detalle y acciones por propiedad.

### Contenido enriquecido

- CKEditor debe seguir utilizándose en los formularios existentes de crear o editar propiedades que acepten descripción, características u observaciones enriquecidas.
- La pantalla “Todas las propiedades” no debe cargar editores enriquecidos si solo presenta resúmenes o texto de solo lectura; esto evita peso innecesario y mantiene buen rendimiento en inventarios grandes.

## 6. Accesibilidad y diseño responsive

- Enfoque mobile-first y controles táctiles de al menos 44 × 44 px cuando aplique.
- Estructura semántica: encabezado, región de filtros, listado, navegación y mensajes de estado.
- Etiquetas asociadas a búsqueda y filtros; foco visible y navegación completa con teclado.
- Contraste AA para textos, botones, badges y fondos.
- Región `aria-live` para cambios de resultado, carga y errores.
- Sin desplazamiento horizontal evitable en móvil; las columnas no esenciales deben reordenarse o mostrarse dentro de la tarjeta.
- No depender solamente del color para expresar aprobación, publicación, disponibilidad u otros estados.

## 7. Seguridad y privacidad

- Autenticación obligatoria para el módulo backend.
- Autorización de consulta y acciones comprobada en servidor mediante el mecanismo actual de Laravel.
- Escape de salida en Blade para todos los campos, incluyendo resúmenes provenientes de contenido enriquecido.
- No exponer identificadores, datos de contacto, notas internas o acciones que la consulta actual no autorice.
- Protección CSRF en todas las acciones ya existentes que modifiquen información.

## 8. Criterios de aceptación

1. El módulo muestra el inventario completo permitido, sin limitarlo a propiedades creadas por el usuario conectado.
2. Las rutas, parámetros, paginación, permisos y acciones existentes siguen funcionando sin cambios funcionales.
3. Cada propiedad muestra datos clave y estados de forma clara y responsive.
4. La búsqueda, filtros, ordenamiento y paginación existentes son utilizables en móvil, tablet y escritorio.
5. El usuario puede abrir el detalle de una propiedad cuando ya tiene el permiso correspondiente.
6. Las acciones visibles para cada propiedad coinciden con las autorizaciones actuales; no se amplían permisos desde la interfaz.
7. Los estados de carga, lista vacía y error son claros y accesibles.
8. La pantalla funciona con teclado, foco visible, lectores de pantalla básicos y contraste AA.
9. El listado conserva buen rendimiento visual al navegar inventario paginado y no carga CKEditor innecesariamente.
10. No se introducen migraciones, cambios de datos, dependencias nuevas ni regresiones en módulos relacionados.

## 9. Pruebas requeridas

- Prueba de consulta global: confirmar que aparecen propiedades de distintos creadores conforme al comportamiento existente.
- Prueba de autorización: perfiles permitidos y perfiles restringidos según la política actual.
- Prueba de búsqueda, filtros, orden y paginación existentes.
- Prueba de acceso a detalle y acciones visibles por rol.
- Prueba de estado vacío, carga y error.
- Prueba responsive en móvil, tablet y escritorio.
- Prueba de teclado, foco, contraste y lector de pantalla básico.
- Prueba de regresión para creación, edición, aprobación y detalle de propiedades.

## 10. Entregable esperado

Una pantalla backend moderna de “Todas las propiedades” que permita consultar de forma clara el inventario completo autorizado del sistema, manteniendo intactos los datos, permisos y flujos existentes, con una experiencia rápida, accesible y consistente con la aplicación actual.
