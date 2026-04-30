# Auditoría de Rendimiento y Consultas — Portal Inmobiliario

**Fecha:** 2026-04-26  
**Stack:** Laravel + MySQL + Livewire  
**Autor:** Auditoría automatizada via GitHub Copilot

---

## Resumen ejecutivo

Se identificaron **5 categorías críticas** de problemas de rendimiento que afectan directamente la velocidad de carga del portal y el CRM:

| Categoría                                                    | Severidad  | Impacto estimado                          |
| ------------------------------------------------------------ | ---------- | ----------------------------------------- |
| Consultas sin índices en columnas de filtro                  | 🔴 Crítico | Escaneos completos de tabla en producción |
| `::all()` y `::first()` sin caché en cada render de Livewire | 🔴 Crítico | +10 queries extras por cada interacción   |
| `Propiedad::where()->get()` sin paginación                   | 🔴 Crítico | Carga toda la tabla en memoria            |
| Relaciones Eloquent no definidas (N+1 latente)               | 🟠 Alto    | N queries extra al iterar colecciones     |
| JOIN por `email` (string) en lugar de ID (integer)           | 🟠 Alto    | Comparación lenta en tablas grandes       |

---

## BLOQUE 1 — Índices faltantes en base de datos

### Problema

La tabla `propiedads` no tiene ningún índice en las columnas que se usan constantemente en `WHERE`, `JOIN` y `ORDER BY`. Con volumen real de datos, cada filtro hace un full table scan.

### Columnas sin índice en `propiedads`

| Columna           | Uso                              | Archivo afectado                                                      |
| ----------------- | -------------------------------- | --------------------------------------------------------------------- |
| `activa`          | WHERE en casi todos los listados | todos los controladores y Livewire                                    |
| `aprobada`        | WHERE en frontend y admin        | `BuscarPropiedadesPropiedades`, `MostrarInventario`, `HomeController` |
| `destacada`       | WHERE en home                    | `HomeController`                                                      |
| `vendida`         | WHERE en inventario y clientes   | `MostrarInventario`, `ClientesController`                             |
| `zona_id`         | JOIN con zonas + filtros         | prácticamente todo el sistema                                         |
| `estado_id`       | JOIN con estados                 | prácticamente todo el sistema                                         |
| `tipo`            | WHERE en filtros                 | `BuscarPropiedadesPropiedades`, `ClientesController`                  |
| `disponible_para` | JOIN con disponible_paras        | múltiples Livewire y controllers                                      |
| `asignada_a`      | WHERE en filtros por asesor      | `PropiedadesPorAgentes`, `ClientesController`                         |
| `captada_por`     | WHERE en filtros                 | `ClientesController`                                                  |
| `slug`            | WHERE para detalle de propiedad  | `Productdetails::show()`                                              |
| `moneda`          | WHERE en inventario              | `MostrarInventario`                                                   |
| `created_at`      | ORDER BY principal               | todos los listados                                                    |

### Columnas sin índice en `clientes`

| Columna          | Uso                                     | Archivo afectado                             |
| ---------------- | --------------------------------------- | -------------------------------------------- |
| `captado_por`    | WHERE en BuscarCliente y ContactosTodos | `BuscarCliente`, `ContactosTodos`            |
| `asignado_a`     | WHERE en BuscarCliente                  | `BuscarCliente`                              |
| `estatus`        | WHERE en filtro de clientes             | `BuscarCliente`, `ContactosTodos`            |
| `probabilidades` | WHERE en filtro de clientes             | `BuscarCliente`, `ContactosTodos`            |
| `created_at`     | WHERE en rango de fechas (ownership)    | `BuscarCliente`, `DashboardAsesorController` |

### Columnas sin índice en `to_dos`

| Columna        | Uso                                      |
| -------------- | ---------------------------------------- |
| `user_id`      | WHERE en TareaComponente                 |
| `cliente_id`   | WHERE en BuscarCliente y TareaComponente |
| `todo_estatus` | WHERE en filtros                         |
| `todo_tipo`    | WHERE en filtros                         |
| `fechaLimite`  | ORDER BY                                 |

### Columnas sin índice en `ventas`

| Columna            | Uso                                    |
| ------------------ | -------------------------------------- |
| `id_asesor`        | WHERE en dashboards                    |
| `id_propiedad`     | WHERE para buscar ventas por propiedad |
| `fechaVentaCierre` | WHERE en rangos de fecha (reports)     |

### Tarea BLOQUE 1 — Crear migración de índices

**Archivo a crear:** `database/migrations/2026_04_26_000001_add_performance_indexes.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('propiedads', function (Blueprint $table) {
            $table->index('activa',         'idx_propiedads_activa');
            $table->index('aprobada',       'idx_propiedads_aprobada');
            $table->index('destacada',      'idx_propiedads_destacada');
            $table->index('vendida',        'idx_propiedads_vendida');
            $table->index('zona_id',        'idx_propiedads_zona_id');
            $table->index('estado_id',      'idx_propiedads_estado_id');
            $table->index('tipo',           'idx_propiedads_tipo');
            $table->index('disponible_para','idx_propiedads_disponible_para');
            $table->index('asignada_a',     'idx_propiedads_asignada_a');
            $table->index('captada_por',    'idx_propiedads_captada_por');
            $table->index('slug',           'idx_propiedads_slug');
            $table->index('moneda',         'idx_propiedads_moneda');
            $table->index('created_at',     'idx_propiedads_created_at');
            // Índice compuesto: el filtro más frecuente en frontend
            $table->index(['activa', 'aprobada', 'vendida'], 'idx_propiedads_estado_general');
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->index('captado_por',    'idx_clientes_captado_por');
            $table->index('asignado_a',     'idx_clientes_asignado_a');
            $table->index('estatus',        'idx_clientes_estatus');
            $table->index('probabilidades', 'idx_clientes_probabilidades');
            $table->index('created_at',     'idx_clientes_created_at');
            // Compuesto para filtro de ownership
            $table->index(['captado_por', 'created_at'], 'idx_clientes_owner_date');
        });

        Schema::table('to_dos', function (Blueprint $table) {
            $table->index('user_id',    'idx_todos_user_id');
            $table->index('cliente_id', 'idx_todos_cliente_id');
            $table->index('todo_estatus','idx_todos_estatus');
            $table->index('todo_tipo',  'idx_todos_tipo');
            $table->index('fechaLimite','idx_todos_fecha');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->index('id_asesor',       'idx_ventas_asesor');
            $table->index('id_propiedad',    'idx_ventas_propiedad');
            $table->index('fechaVentaCierre','idx_ventas_fecha_cierre');
        });
    }

    public function down(): void
    {
        Schema::table('propiedads', function (Blueprint $table) {
            $table->dropIndex('idx_propiedads_activa');
            $table->dropIndex('idx_propiedads_aprobada');
            $table->dropIndex('idx_propiedads_destacada');
            $table->dropIndex('idx_propiedads_vendida');
            $table->dropIndex('idx_propiedads_zona_id');
            $table->dropIndex('idx_propiedads_estado_id');
            $table->dropIndex('idx_propiedads_tipo');
            $table->dropIndex('idx_propiedads_disponible_para');
            $table->dropIndex('idx_propiedads_asignada_a');
            $table->dropIndex('idx_propiedads_captada_por');
            $table->dropIndex('idx_propiedads_slug');
            $table->dropIndex('idx_propiedads_moneda');
            $table->dropIndex('idx_propiedads_created_at');
            $table->dropIndex('idx_propiedads_estado_general');
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropIndex('idx_clientes_captado_por');
            $table->dropIndex('idx_clientes_asignado_a');
            $table->dropIndex('idx_clientes_estatus');
            $table->dropIndex('idx_clientes_probabilidades');
            $table->dropIndex('idx_clientes_created_at');
            $table->dropIndex('idx_clientes_owner_date');
        });

        Schema::table('to_dos', function (Blueprint $table) {
            $table->dropIndex('idx_todos_user_id');
            $table->dropIndex('idx_todos_cliente_id');
            $table->dropIndex('idx_todos_estatus');
            $table->dropIndex('idx_todos_tipo');
            $table->dropIndex('idx_todos_fecha');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->dropIndex('idx_ventas_asesor');
            $table->dropIndex('idx_ventas_propiedad');
            $table->dropIndex('idx_ventas_fecha_cierre');
        });
    }
};
```

**Comando de ejecución:**

```bash
php artisan migrate
```

**Riesgos:** Ninguno. Las migraciones de índices son seguras y reversibles. En tablas grandes puede tomar segundos; ejecutar en horario de bajo tráfico.

---

## BLOQUE 2 — `Inmobiliaria::first()` repetido en cada render de Livewire

### Problema

`Inmobiliaria::first()` se llama **en cada método `render()`** de los componentes Livewire. Livewire re-renderiza el componente en cada interacción del usuario (cada tecla, cada click). Esto genera 1 query extra por interacción en cada componente activo.

### Archivos afectados

| Archivo                                                        | Línea aprox.      |
| -------------------------------------------------------------- | ----------------- |
| `app/Http/Livewire/BuscarPropiedadesPropiedades.php`           | render() línea 43 |
| `app/Http/Livewire/MostrarInventario.php`                      | render() línea 33 |
| `app/Http/Livewire/PropiedadesPorAgentes.php`                  | render() línea 22 |
| `app/Http/Livewire/BuscarPropiedadesPorZonas.php`              | render()          |
| `app/Http/Livewire/BuscarPropiedadesPorTipos.php`              | render()          |
| `app/Http/Livewire/BuscarCliente.php`                          | render()          |
| `app/Http/Controllers/Frontend/HomeController.php`             | index()           |
| `app/Http/Controllers/Frontend/ListaPropiedadesController.php` | index()           |
| `app/Http/Controllers/Frontend/Productdetails.php`             | show()            |
| `app/Http/Controllers/Admin/ClientesController.php`            | veropciones()     |
| `app/Http/Controllers/DashboardAsesorController.php`           | index()           |

### Solución

**Paso 1 — Crear un Service o usar caché de aplicación:**

```php
// app/Services/InmobiliariaService.php
<?php

namespace App\Services;

use App\Models\Inmobiliaria;
use Illuminate\Support\Facades\Cache;

class InmobiliariaService
{
    public static function get(): ?Inmobiliaria
    {
        return Cache::remember('inmobiliaria_config', now()->addMinutes(60), function () {
            return Inmobiliaria::first();
        });
    }

    public static function forget(): void
    {
        Cache::forget('inmobiliaria_config');
    }
}
```

**Paso 2 — Llamar al cache forget en el observer o al guardar:**

```php
// En EmpresaController cuando se guarda la inmobiliaria:
InmobiliariaService::forget();
```

**Paso 3 — Reemplazar en cada Livewire y controlador:**

```php
// Antes:
$inmobiliaria = Inmobiliaria::first();

// Después:
$inmobiliaria = \App\Services\InmobiliariaService::get();
```

**Impacto:** Elimina ~10–15 queries por carga de página del frontend y por cada interacción en el CRM.

---

## BLOQUE 3 — Tablas de catálogo (`::all()`) sin caché en cada render

### Problema

En cada render de componentes Livewire se ejecutan múltiples `::all()` sobre tablas que son prácticamente estáticas (zonas, tipos, estados, disponible_para, portadas):

```php
// BuscarPropiedadesPropiedades::render() — se ejecuta en cada keypress:
$portadas        = Portada::all();           // query innecesaria
$zonas           = Zonas::all();             // query innecesaria
$disponibles_para = Disponible_para::all(); // query innecesaria
$tipos           = TiposDePropiedad::all(); // query innecesaria
$testimonios     = Testimonio::all();        // query innecesaria
$enfoques        = Enfoque::all();           // query innecesaria
$posts           = Post::all();              // query innecesaria
```

Esto equivale a **7 queries extra por cada interacción** del usuario en la página de propiedades.

### Archivos afectados

| Archivo                            | Tablas cargadas sin caché                                                            |
| ---------------------------------- | ------------------------------------------------------------------------------------ |
| `BuscarPropiedadesPropiedades.php` | portadas, zonas, disponible_paras, tipos_de_propiedads, testimonios, enfoques, posts |
| `PropiedadesPorAgentes.php`        | portadas, zonas, disponible_paras, tipos_de_propiedads                               |
| `MostrarInventario.php`            | zonas                                                                                |
| `BuscarCliente.php`                | zonas, disponible_paras, tipos_de_propiedads, estados                                |
| `ContactosTodos.php`               | zonas, disponible_paras, tipos_de_propiedads, estados, `User::all()`                 |
| `TareaComponente.php`              | `Clientes::where(...)->get()` sin límite                                             |

### Caso especial crítico — `User::all()` en `ContactosTodos`

```php
// ContactosTodos::render() — carga TODOS los usuarios en cada render:
$user = User::all();
```

En una inmobiliaria con 50+ asesores esto es innecesario. Usar caché o `select('id','name','email')`.

### Solución — Caché de catálogos

```php
// app/Services/CatalogoService.php
<?php

namespace App\Services;

use App\Models\Zonas;
use App\Models\Estados;
use App\Models\Disponible_para;
use App\Models\TiposDePropiedad;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class CatalogoService
{
    public static function zonas()
    {
        return Cache::remember('cat_zonas', now()->addHours(6), fn() => Zonas::orderBy('zona')->get());
    }

    public static function tipos()
    {
        return Cache::remember('cat_tipos', now()->addHours(6), fn() => TiposDePropiedad::orderBy('tipo')->get());
    }

    public static function estados()
    {
        return Cache::remember('cat_estados', now()->addHours(6), fn() => Estados::orderBy('estado')->get());
    }

    public static function disponiblePara()
    {
        return Cache::remember('cat_disponible_para', now()->addHours(6), fn() => Disponible_para::all());
    }

    public static function asesores()
    {
        return Cache::remember('cat_asesores', now()->addMinutes(30), function () {
            return User::select('id', 'name', 'email', 'foto', 'activo')
                ->where('activo', 1)
                ->orderBy('name')
                ->get();
        });
    }

    public static function forgetAll(): void
    {
        Cache::forget('cat_zonas');
        Cache::forget('cat_tipos');
        Cache::forget('cat_estados');
        Cache::forget('cat_disponible_para');
        Cache::forget('cat_asesores');
    }
}
```

**Impacto:** Elimina 5–7 queries por cada interacción Livewire en el frontend. Las tablas de catálogo no cambian frecuentemente.

---

## BLOQUE 4 — Consultas críticas sin paginación (carga masiva en memoria)

### Problema 4.1 — `ListaPropiedadesController` carga TODAS las propiedades

```php
// app/Http/Controllers/Frontend/ListaPropiedadesController.php
// ⚠️ CRÍTICO: sin limit ni paginate — carga TODO en memoria
$propiedades = Propiedad::where('aprobada',1)->get();
```

Con 500+ propiedades esto carga todos los registros (con todos sus campos incluyendo textos largos) en memoria PHP. Es el problema de rendimiento más grave del sistema.

**Solución:**

```php
// La lógica real de filtrado ya está en el componente Livewire BuscarPropiedadesPropiedades
// El controlador debería simplemente renderizar la vista sin datos masivos:
$propiedades = collect(); // vacío, Livewire carga los datos
return view('frontend.propiedades', compact('portadas','zonas','disponibles_para','tipos_propiedades','propiedades','inmobiliaria'));
```

### Problema 4.2 — `PropiedadesController::misitemap()` itera todas las propiedades

```php
// app/Http/Controllers/Admin/PropiedadesController.php
$propiedades = Propiedad::where('activa', 1)->get(); // sin límite, carga todo
foreach ($propiedades as $propiedad) { ... }
```

**Solución:** Usar `chunk()` o `cursor()` para sitemaps grandes y seleccionar solo columnas necesarias:

```php
// Solo necesita slug y updated_at:
Propiedad::where('activa', 1)
    ->select('slug', 'updated_at')
    ->chunk(200, function ($propiedades) use ($myfile, $inmo) {
        foreach ($propiedades as $propiedad) {
            // escribir al archivo
        }
    });
```

### Problema 4.3 — `TareaComponente` carga todos los clientes sin límite

```php
// app/Http/Livewire/TareaComponente.php
$clientes = Clientes::where(function ($query) {
    $query->where('captado_por', Auth::id())
        ->orWhere('asignado_a', Auth::id());
})->get(); // sin límite — para el dropdown de selección de cliente
```

Un asesor con 300+ clientes carga todos en el dropdown. Implementar búsqueda en tiempo real o limitar con `->latest()->limit(50)->get()`.

---

## BLOQUE 5 — Relaciones Eloquent no definidas (N+1 potencial y JOIN por email)

### Problema 5.1 — JOIN por email (string) en lugar de ID (integer)

En múltiples lugares el join entre `propiedads` y `users` se hace por la columna `email`:

```php
// HomeController, ListaPropiedadesController, PropiedadesPorAgentes, etc.:
$propiedades->leftJoin('users', 'propiedads.asignada_a', '=', 'users.email');
```

`asignada_a` almacena el email del asesor como string. Los JOINs por string son **~3-5x más lentos** que por integer. Además, si un asesor cambia su email, los datos quedan huérfanos.

**Solución a largo plazo:** Agregar columna `asignada_a_id INTEGER` a `propiedads` y migrar la lógica. Mientras tanto, al menos asegurar índice en `users.email` y en `propiedads.asignada_a`.

### Problema 5.2 — Modelo `Propiedad` sin relaciones Eloquent definidas

El modelo `Propiedad` no tiene ninguna relación definida:

```php
// Propiedad.php — No tiene: zonas(), estado(), tipoPropiedad(), disponiblePara(), asignado()
```

Esto fuerza a usar JOINs manuales en cada controlador y Livewire, duplicando código y haciendo imposible usar eager loading.

**Solución — Agregar relaciones al modelo:**

```php
// app/Models/Propiedad.php

use App\Models\Zonas;
use App\Models\Estados;
use App\Models\TiposDePropiedad;
use App\Models\Disponible_para;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

public function zona(): BelongsTo
{
    return $this->belongsTo(Zonas::class, 'zona_id');
}

public function estado(): BelongsTo
{
    return $this->belongsTo(Estados::class, 'estado_id');
}

public function tipoPropiedad(): BelongsTo
{
    return $this->belongsTo(TiposDePropiedad::class, 'tipo');
}

public function disponiblePara(): BelongsTo
{
    return $this->belongsTo(Disponible_para::class, 'disponible_para');
}
```

Una vez definidas, en consultas donde se itera la colección usar eager loading:

```php
// En lugar de JOIN manual, usar with():
Propiedad::with(['zona', 'estado', 'tipoPropiedad', 'disponiblePara'])
    ->where('activa', 1)
    ->paginate(12);
```

### Problema 5.3 — `Clientes` usa `hasOne` en lugar de `belongsTo`

```php
// app/Models/Clientes.php — semánticamente incorrecto:
public function user(): HasOne
{
    return $this->hasOne(User::class, 'id', 'captado_por'); // debería ser belongsTo
}
```

`hasOne` es la relación "padre a hijo". Aquí `Clientes` pertenece a `User`, por lo tanto debe ser `belongsTo`. Aunque funciona, genera queries más complejas internamente.

```php
// Corrección:
public function captador(): BelongsTo
{
    return $this->belongsTo(User::class, 'captado_por');
}

public function asesor(): BelongsTo
{
    return $this->belongsTo(User::class, 'asignado_a');
}
```

---

## BLOQUE 6 — Otras ineficiencias detectadas

### 6.1 — Incremento de clicks con save() completo

```php
// app/Http/Controllers/Frontend/Productdetails.php
$propiedad_click = Propiedad::where('slug',$id)->first(); // 1 query
$propiedad_click->clicks++;
$propiedad_click->save(); // UPDATE con TODOS los campos
```

Guarda todos los atributos del modelo para solo incrementar un contador. Usar:

```php
Propiedad::where('slug', $id)->increment('clicks'); // 1 query eficiente, sin cargar el modelo
```

### 6.2 — Double query en `Productdetails::show()`

```php
// Productdetails.php — se busca la propiedad DOS veces:
$propiedad_click = Propiedad::where('slug', $id)->first(); // query 1
// ...
$propiedad = DB::table('propiedads')->...->where('propiedads.slug','=',$id)->first(); // query 2
```

Usar una sola query con todos los datos necesarios, o usar el primer resultado con `load()`.

### 6.3 — `SELECT *` implícito en `MostrarInventario` y `MostrarPropiedades`

Ambos componentes Livewire hacen SELECT de ~60 columnas (incluyendo todos los campos booleanos de amenidades) incluso en la vista de listado donde solo se muestran 10-12 columnas. Reducir a las columnas realmente necesarias para el listado.

### 6.4 — `HomeController::index()` sin límite en `Post::all()`

```php
// HomeController.php
$posts = Post::all(); // todos los posts sin límite ni select de columnas
```

Si hay 100+ posts, todos se cargan. Usar:

```php
$posts = Post::select('id', 'titulo', 'slug', 'foto', 'descripcion_corta', 'created_at')
    ->latest()
    ->limit(6)
    ->get();
```

### 6.5 — `ambiguous column` en ORDER BY de joins

```php
// MostrarPropiedades.php y MostrarInventario.php:
->orderBy('created_at','desc') // ⚠️ ambiguo cuando hay JOINs
```

Si zonas o estados también tienen `created_at`, MySQL puede lanzar error de columna ambigua. Usar siempre:

```php
->orderBy('propiedads.created_at','desc')
```

---

## Plan de implementación priorizado

### Prioridad ALTA — Impacto inmediato, bajo riesgo

| #   | Tarea                                                                    | Archivo                                           | Esfuerzo |
| --- | ------------------------------------------------------------------------ | ------------------------------------------------- | -------- |
| 1   | Crear migración de índices (Bloque 1)                                    | nueva migración                                   | 30 min   |
| 2   | Corregir `ListaPropiedadesController` — remover `::get()` sin paginación | `ListaPropiedadesController.php`                  | 15 min   |
| 3   | Corregir `clicks++` por `increment()` en Productdetails                  | `Productdetails.php`                              | 5 min    |
| 4   | Corregir `orderBy('created_at')` ambiguo → `propiedads.created_at`       | `MostrarPropiedades.php`, `MostrarInventario.php` | 10 min   |
| 5   | Corregir sitemap con `chunk()`                                           | `PropiedadesController.php`                       | 15 min   |

### Prioridad MEDIA — Reducción de queries por sesión

| #   | Tarea                                                                 | Esfuerzo |
| --- | --------------------------------------------------------------------- | -------- |
| 6   | Crear `InmobiliariaService` con caché                                 | 30 min   |
| 7   | Reemplazar `Inmobiliaria::first()` en todos los Livewire              | 60 min   |
| 8   | Crear `CatalogoService` con caché para catálogos                      | 45 min   |
| 9   | Reemplazar `Zonas::all()`, `TiposDePropiedad::all()` etc. en Livewire | 60 min   |
| 10  | Limitar `Clientes::get()` en TareaComponente                          | 15 min   |

### Prioridad BAJA — Refactor estructural

| #   | Tarea                                                                               | Esfuerzo                  |
| --- | ----------------------------------------------------------------------------------- | ------------------------- |
| 11  | Definir relaciones Eloquent en `Propiedad`                                          | 45 min                    |
| 12  | Corregir `hasOne` → `belongsTo` en `Clientes`                                       | 15 min                    |
| 13  | Agregar columna `asignada_a_id` INTEGER a `propiedads` para eliminar JOIN por email | 2-4h (migración + código) |
| 14  | Reemplazar JOINs manuales por `with()` eager loading donde corresponda              | 2-3h                      |

---

## Herramientas recomendadas para validar mejoras

### Instalar Laravel Debugbar (desarrollo)

```bash
composer require barryvdh/laravel-debugbar --dev
```

Muestra en el browser: cantidad de queries, tiempo por query, duplicadas, y memoria usada. Clave para verificar que las mejoras aplicadas realmente redujeron queries.

### Instalar Telescope (desarrollo)

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Permite ver queries N+1 en tiempo real, identificar las más lentas, y monitorear el comportamiento de Livewire.

### MySQL EXPLAIN

Para las queries más pesadas, ejecutar en MySQL Workbench o CLI:

```sql
EXPLAIN SELECT * FROM propiedads
WHERE activa = 1 AND aprobada = 1 AND vendida = 0
ORDER BY created_at DESC
LIMIT 12;
```

Si `type = ALL` significa full scan. Después de aplicar índices debe cambiar a `ref` o `range`.

---

## Notas de seguridad detectadas en la auditoría

- **SQL Injection latente:** En `MostrarPropiedades` y `BuscarCliente` se usan variables de Livewire directamente en `like "%$this->criterio%"`. Aunque Eloquent bindea correctamente, verificar que no hay casos con `DB::raw` sin bindeo.
- **`asignada_a` por email:** Exponer el email del asesor en la URL o en queries del frontend puede ser un vector de enumeración. Migrar a ID cuando se haga el refactor del JOIN.

---

_Documento generado como guía de trabajo. Cada bloque puede implementarse de forma independiente y verificable._
