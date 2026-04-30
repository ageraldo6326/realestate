---
applyTo: "app/Http/Controllers/Admin/**/*.php,app/Http/Livewire/**/*.php,app/Http/Requests/**/*.php,resources/views/admin/**/*.blade.php,resources/views/livewire/**/*.blade.php,routes/**/*.php"
description: "Guia reusable para migrar cualquier catalogo tomando el modulo de Usuarios como referencia: sin modales, CRUD en vistas propias, y misma UI/UX base del modulo Usuarios."
---

Contexto y objetivo

- Usa el modulo de Usuarios como referencia canonica de UI, UX y flujo CRUD.
- Para cualquier catalogo nuevo o legado, reemplaza modales de crear/editar por vistas propias.
- Mantiene el mismo look and feel base de Usuarios en index/create/edit.
- Reutiliza patrones estructurales de Usuarios: breadcrumb claro, vistas dedicadas create/edit, parcial de formulario reusable cuando aporte valor, mensajes flash y acciones visibles.
- Adapta solo los patrones reutilizables de Usuarios; no copies campos, reglas o bloques especificos del dominio de usuarios cuando no apliquen al catalogo.

Reglas obligatorias

- No usar modales para crear o editar registros.
- Si hay modales legacy en Livewire o Blade, eliminarlos y mover el flujo a rutas create/edit.
- Mantener rutas REST resource y nombres consistentes.
- Validar con Form Request (store/update separados).
- Mantener paginacion Bootstrap 4 en listados.
- Mantener confirmacion de eliminado con SweetAlert.

Patron de arquitectura recomendado

1. Rutas

- Definir resource route para el catalogo en admin.
- Usar index/create/store/edit/update/destroy.

2. Controlador admin

- index: renderiza la vista index del catalogo.
- create/edit: renderizan vistas propias (no modal).
- store/update: usan Form Request.
- destroy: elimina y redirige con mensaje de exito.

3. Listado (Livewire o Blade)

- El listado solo gestiona: buscar, paginar, eliminar.
- Boton Nuevo navega a la ruta create.
- Boton Editar navega a la ruta edit.
- No incluir formularios create/edit dentro del listado.

4. Validacion

- StoreRequest y UpdateRequest con reglas claras y mensajes utiles.
- En unique de update, ignorar el id actual de forma segura.

UI canonica del index (igual a Usuarios)

- Contenedor: container-fluid con px-3 o espaciado horizontal equivalente.
- Alertas simples: success/error con shadow-sm, border-0, rounded-lg.
- Encabezado alineado con el patron del modulo Usuarios:
    - Breadcrumb consistente con el modulo admin.
    - Titulo de pagina claro.
    - Boton primario visible para crear cuando aplique.
- Card 2 (busqueda + tabla):
    - Filtro arriba con label visible.
    - Input de busqueda y acciones Buscar/Limpiar.
    - Tabla responsive.
    - Header de tabla en uppercase small muted.
    - Columnas minimas: ID, nombre del catalogo, Acciones.
    - Acciones alineadas a la derecha: Editar y Eliminar.
    - Estado vacio con mensaje claro.
- Si el modulo usa Livewire para el listado, mantener el patron de componente dedicado solo para buscar, paginar y disparar acciones de estado/eliminacion.
- Paginacion: links('pagination::bootstrap-4').

UI canonica de create/edit (igual a Usuarios)

- Misma estructura visual entre create y edit.
- Vista dedicada con breadcrumb y page title consistentes.
- Preferir parcial de formulario compartido entre create/edit cuando reduzca duplicacion.
- Card o panel principal con shadow-sm, rounded-lg y body con padding comodo.
- Titulo h5 + descripcion breve.
- Formulario simple, un campo por linea (o pocos), labels visibles.
- Organizar campos por bloques solo si mejora legibilidad; no fragmentar de mas catalogos simples.
- Botones al final:
    - Primario: Guardar o Guardar cambios.
    - Secundario outline: Cancelar.
- Script minimo para deshabilitar submit y cambiar texto a Guardando... en submit.

SweetAlert para eliminar

- Mantener confirmacion explicita antes de eliminar.
- Textos claros: confirmar/cancelar.
- Si se confirma, ejecutar accion delete (Livewire emit o form submit).

Checklist de migracion de un catalogo

1. Identificar y eliminar modales de create/edit en listado.
2. Crear vistas dedicadas: admin/<catalogo>/create y admin/<catalogo>/edit.
3. Ajustar botones del listado para navegar a create/edit.
4. Mover logica de persistencia al controlador resource.
5. Crear/actualizar Form Requests de store y update.
6. Aplicar layout visual del index tomando Usuarios como referencia estructural.
7. Aplicar layout visual de create/edit tomando Usuarios como referencia estructural.
8. Validar mensajes flash success/error.
9. Verificar paginacion, busqueda y borrado con confirmacion.
10. Probar responsive en mobile y desktop.

Criterios de aceptacion

- El CRUD funciona sin modales de create/edit.
- La pantalla index del catalogo mantiene el mismo look and feel base que Usuarios.
- Create y edit son vistas propias con consistencia visual.
- La eliminacion requiere confirmacion.
- No hay regresiones en busqueda, paginacion ni validacion.

Anti-patrones a evitar

- Formularios create/edit embebidos en modales dentro de la grilla.
- Mezclar estilos visuales distintos a los de Usuarios en catalogos admin.
- Logica de negocio compleja en vistas Blade.
- Validacion manual en controlador si ya existe Form Request.
