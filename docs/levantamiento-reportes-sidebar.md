# Levantamiento de reportes en sidebar (admin y asesor)

Fecha: 2026-04-25

## Fuente revisada

- Sidebar: `resources/views/admin/menu.blade.php`
- Rutas: `routes/web.php`
- Controladores de reportes: `app/Http/Controllers/*`
- Vistas de reportes: `resources/views/estadisticas/*` y `resources/views/admin/dashboard/dashboardventas.blade.php`

## Seccion Reportes en sidebar

Menu padre:

- `Reportes` (submenu bajo `Estadisticas`)

Opciones visibles por rol:

1. Admin

- `Clientes potenciales` -> ruta `clientespotenciales` -> `/admin/clientespotenciales/`
- `Clientes cerrados` -> ruta `clientescerrados` -> `/admin/clientescerrados/`
- `Fuente de clientes` -> ruta `fuenteclientes` -> `/admin/fuenteclientes/`
- `Tareas por categoria` -> ruta `tareasporcategorias` -> `/admin/tareasporcategorias/`
- `Propiedades por click` -> ruta `propiedadesclick` -> `/admin/propiedadesclick/`
- `Ventas` -> ruta `dashboardventas` -> `/admin/dashboardventas/`

2. Asesor

- `Ventas` -> ruta `dashboardventas` -> `/admin/dashboardventas/`

## Mapeo ruta -> controlador -> vista

1. `clientespotenciales`

- Controlador: `ClientesPotencialesController@grafico`
- Vista: `estadisticas.clientespotenciales`
- Renderiza componente Livewire: `clientespotenciales`

2. `clientescerrados`

- Controlador: `ClientesPotencialesCerradosController@grafico`
- Vista: `estadisticas.clientespotencialescerrados`
- Renderiza componente Livewire: `clientespotencialescerrados`

3. `fuenteclientes`

- Controlador: `FuenteClientesController@grafico`
- Vista: `estadisticas.fuenteclientes`
- Renderiza componente Livewire: `fuenteclientes`

4. `tareasporcategorias`

- Controlador: `TareasPorCategoriasController@grafico`
- Vista: `estadisticas.tareasporcategorias`

5. `propiedadesclick`

- Controlador: `PropiedadesClickController@grafico`
- Vista: `estadisticas.propiedadesclicks`

6. `dashboardventas`

- Controlador: `DashboardVentasController@index`
- Vista: `admin.dashboard.dashboardventas`

## Hallazgos tecnicos previos a modernizacion

- El submenu `Reportes` ya estaba condicionado por rol en la vista del sidebar.
- Las tres vistas Livewire usaban un `emitActualizar` global desde JavaScript inline.
- Algunas vistas de reportes usan formularios con sintaxis invalida en el `action`.
- Hay estilos visuales inconsistentes entre reportes (cards, filtros, tipografia y espaciados).
