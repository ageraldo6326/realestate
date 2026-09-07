<?php

use App\Models\Propiedad;
use App\Models\Disponible_para;
use App\Http\Controllers\Sitemap;
use App\Http\Livewire\Admin\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactosTodos;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\SelectController;
use App\Http\Livewire\Clientespotenciales;
use App\Http\Controllers\Admin\TodoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ZonasController;
use App\Http\Controllers\CrearVentasController;
use App\Http\Controllers\Admin\EntrarController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\EstadosController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Productdetails;
use App\Http\Controllers\Admin\ClientesController;
use App\Http\Controllers\Admin\CsvController;
use App\Http\Controllers\Admin\EnfoquesController;
use App\Http\Controllers\Admin\PortadasController;
use App\Http\Controllers\ContactosTodosController;
use App\Http\Controllers\FuenteClientesController;
use App\Http\Controllers\DashboardAsesorController;
use App\Http\Controllers\DashboardVentasController;
use App\Http\Controllers\Frontend\EquipoController;
use App\Http\Controllers\RegistrarVentasController;
use App\Http\Controllers\PropiedadesClickController;
use App\Http\Controllers\propiedadPorZonaController;
use App\Http\Controllers\Admin\PropiedadesController;
use App\Http\Controllers\Admin\TestimoniosController;
use App\Http\Controllers\Admin\TipostareasController;
use App\Http\Controllers\OptimizarImagenesController;
use App\Http\Controllers\Admin\PortadasParaController;
use App\Http\Controllers\Frontend\ContactosController;
use App\Http\Controllers\ClientesPotencialesController;
use App\Http\Controllers\TareasPorCategoriasController;
use App\Http\Controllers\Admin\DisponibleParaController;
use App\Http\Controllers\Admin\MetaController;
use App\Http\Controllers\Admin\MostrarClienteController;
use App\Http\Controllers\Admin\AiContentController;
use App\Http\Controllers\verclientespotencialeslivewire;
use App\Http\Controllers\Frontend\QuienesSomosController;
use App\Http\Controllers\Admin\TiposPropiedadesController;
use App\Http\Controllers\Frontend\ListaPropiedadesController;
use App\Http\Controllers\ClientesPotencialesCerradosController;
use App\Http\Controllers\Admin\VerClientesPorAsesoresController;
use App\Http\Controllers\Frontend\propiedadesPorAgenteController;
use App\Http\Controllers\Frontend\ListaPropiedadesPorAgenteController;
use Illuminate\Support\Facades\File;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/clientespotenciales',[verclientespotencialeslivewire::class,'index'])->name('clientespotenciales'); 


Route::get('webhook', [MetaController::class, 'register'])->name('webhook');

Route::post('webhook', [MetaController::class, 'handle'])->name('webhookhandle');

// Legacy endpoint retirado: evita exponer contenido incorrecto como sitemap.
Route::any('/seo/sitemap', function () {
    return response('', 410);
});

Route::get('/sitemap.xml', [Sitemap::class, 'sitemap'])->name('sitemap.xml');
Route::redirect('/sitemap', '/sitemap.xml', 301);

Route::get('/admin/clientes/veropciones/{id}', [ClientesController::class, "veropciones"])->name("veropciones");
Route::get('/admin/clientes/veropcionesendolares/{id}', [ClientesController::class, "veropcionesendolares"])->name("veropcionesendolares");

Route::get('/select', [SelectController::class, 'index'])->name('select');
// frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/propiedad/{id}', [Productdetails::class, 'show'])->name('propiedad');
Route::get('/propiedades', [ListaPropiedadesController::class, 'index'])->name("listapropiedades");
Route::get('/propiedades/agente/{id}', [ListaPropiedadesPorAgenteController::class, 'index'])->name("listapropiedadesporagentes");
Route::get('/equipo', [EquipoController::class, 'index'])->name("equipo");
Route::get('/contacto', [ContactosController::class, 'index'])->name("contactos");
Route::get('/blog', [BlogController::class, 'index'])->name("blog");
Route::get('/post/{slug}', [BlogController::class, 'show'])->name("post.show");
Route::get('/quienessomos', [QuienesSomosController::class, 'index'])->name("quienessomos");




Route::get('/admin/vercualquierpropiedad/{id}', [PropiedadesController::class, 'vercualquierpropiedad'])->name("vercualquierpropiedad");
Route::get('/admin/verpropiedades', [PropiedadesController::class, 'verpropiedades'])->name("verpropiedades");



// Opciones para administradores

Route::middleware(['auth', 'enforce.superadmin.password.rotation'])->group(function () {
    Route::get('/admin/security/superadmin/password', [EntrarController::class, 'showSuperadminPasswordRotationForm'])
        ->name('admin.superadmin.password.edit');
    Route::post('/admin/security/superadmin/password', [EntrarController::class, 'rotateSuperadminPassword'])
        ->name('admin.superadmin.password.update');
});

Route::group(['middleware' => ['auth', 'enforce.superadmin.password.rotation', 'role:admin|superadmin']], function () {



    Route::get('/consulta/cliente-por-asesor', function () {
        return view('consultas.consultaClientesPorAsesor');
    })->name('consultaClientesAsesor');

    Route::get('/admin/import/', [CsvController::class, 'index'])->name('import.index');
    Route::get('/admin/import/template', [CsvController::class, 'downloadTemplate'])->name('import.template');

    Route::post('/admin/import_csv/', [CsvController::class, 'import'])->name('import.csv');

    Route::get('/admin/contactostodos', [ContactosTodosController::class, 'index'])->name('contactostodos');

    Route::get('/admin/poraprobar/', [PropiedadesController::class, 'aprobar'])->name("poraprobar");
    Route::get('/admin/borrarpropiedad/{id}', [PropiedadesController::class, 'borrarpropiedad'])->name("borrarpropiedad");
    Route::get('/admin/consultarpropiedades', [PropiedadesController::class, 'consultarpropiedades'])->name("consultarpropiedades");
    Route::get('/admin/editarpendientes/{id}', [PropiedadesController::class, 'editPendiente'])->name("editarpendientes");
    Route::get('/admin/editarpendientescualquiera/{id}', [PropiedadesController::class, 'editarpendientescualquiera'])->name("editarpendientescualquiera");
    Route::put('/admin/updatependientes/{id}', [PropiedadesController::class, 'updatependientes'])->name("updatependientes");
    Route::put('/admin/updatecualquiera/{id}', [PropiedadesController::class, 'updatecualquiera'])->name("updatecualquiera");

    Route::delete('/admin/borrarusuario/{id}', [UsuarioController::class, 'borrarusuario'])->name("borrarusuario");
    Route::get('/admin/borrarventa/{id}', [CrearVentasController::class, 'borrarventa'])->name("borrarventa");

    Route::get('/consulta/verclientesporasesor/{asesorid}/{fecha_ini}/{fecha_fin}', [VerClientesPorAsesoresController::class, 'index'])->name("verclientesporasesor");

    Route::get('/consulta/vercliente/{clienteid}', [MostrarClienteController::class, 'show'])->name("vercliente");
    Route::get('/admin/registrarventa/', [RegistrarVentasController::class, 'index'])->name("registrarventa");
    Route::get('/admin/crearventa/', [CrearVentasController::class, 'index'])->name("crearventa");
    Route::get('/admin/editarventa/{id}', [CrearVentasController::class, 'edit'])->name("editarventa");
    Route::post('/admin/grabarventa/', [CrearVentasController::class, 'grabarventa'])->name("grabarventa");
    Route::post('/admin/actualizarventa/', [CrearVentasController::class, 'actualizarventa'])->name("actualizarventa");

    Route::resource('/admin/testimonios', TestimoniosController::class);
    Route::resource('/admin/posts', PostsController::class);
    Route::resource('/admin/enfoques', EnfoquesController::class);
    Route::match(['post', 'put'], '/admin/inmobiliaria/{id}/restore-default', [EmpresaController::class, 'restoreDefaultTheme'])->name('inmobiliaria.restore-default');
    Route::match(['post', 'put'], '/admin/inmobiliaria/{id}/restore-previous', [EmpresaController::class, 'restorePreviousTheme'])->name('inmobiliaria.restore-previous');
    Route::resource('/admin/inmobiliaria', EmpresaController::class);
    Route::resource('/admin/zonas', ZonasController::class);
    Route::resource('/admin/tipopropiedades', TiposPropiedadesController::class);
    Route::resource('/admin/estados', EstadosController::class);
    Route::resource('/admin/disponiblepara', DisponibleParaController::class);
    Route::resource('/admin/portadas', PortadasController::class);
    Route::resource('/admin/todo/tipostareas', TipostareasController::class);
    Route::resource('/admin/usuarios', UsuarioController::class);
});

// fin opciones para administradores

//  Opciones para asesores

Route::group(['middleware' => ['auth', 'enforce.superadmin.password.rotation', 'role:asesor|admin|superadmin']], function () {

    Route::get('/admin/dashboard', function () {
        $user    = Auth::user();
        $isAdmin = $user && $user->hasAnyRole(['admin', 'superadmin']);

        // Evita mostrar dashboard global a asesores: redirige al tablero filtrado por usuario.
        if (!$isAdmin) {
            return Redirect::route('dashboardasesor');
        }

        // KPIs propiedades
        $propBase        = \App\Models\Propiedad::query();
        $totalPropiedades = (clone $propBase)->count();
        $propPublicadas   = (clone $propBase)->where('activa', 1)->count();
        $propPendientes   = (clone $propBase)->where('activa', 0)->count();

        // KPIs contactos
        $contBase        = \App\Models\Clientes::query();
        $totalContactos  = (clone $contBase)->count();
        $contactosMes    = (clone $contBase)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // KPIs tareas
        $tareaBase         = \App\Models\ToDo::query()->where('user_id', $user->id);
        $tareasPendientes  = (clone $tareaBase)->where('todo_estatus', 0)->count();
        $tareasCompletadas = (clone $tareaBase)->where('todo_estatus', 1)->count();

        // Últimos registros
        $ultimasPropiedades = (clone $propBase)->latest()->take(5)->get();
        $ultimosContactos   = (clone $contBase)->latest()->take(5)->get();

        return view('admin.adminlte.dashboard', compact(
            'totalPropiedades',
            'propPublicadas',
            'propPendientes',
            'totalContactos',
            'contactosMes',
            'tareasPendientes',
            'tareasCompletadas',
            'ultimasPropiedades',
            'ultimosContactos'
        ));
    })->name('dashboard');
});


Route::group(['middleware' => ['auth', 'role:asesor|admin|superadmin']], function () {

    Route::post('/admin/ai/generar-contenido', [AiContentController::class, 'generate'])
        ->middleware('throttle:20,1')
        ->name('admin.ai.generate');

    Route::get('/admin/calendario', [TodoController::class, "calendario"])->name("calendario");

    Route::get('/admin/clientes/asignar', [ClientesController::class, 'asignar'])->name("asignar");

    Route::resource('/admin/propiedades', PropiedadesController::class);
    Route::get('/admin/api/sectores', [PropiedadesController::class, 'sectoresPorProvincia'])->name('admin.api.sectores');
    Route::get('/admin/api/barrios', [PropiedadesController::class, 'barriosPorSector'])->name('admin.api.barrios');
    Route::resource('/admin/todo', TodoController::class);
    Route::resource('/admin/clientes', ClientesController::class)->except(['show']);

    Route::get('/admin/clientes/verificar', [ClientesController::class, 'verificar'])->name("verificar");
    Route::get('/admin/dashboardasesor/', [DashboardAsesorController::class, "index"])->name('dashboardasesor');


    Route::get('/admin/clientespotenciales/', [ClientesPotencialesController::class, "grafico"])->name('clientespotenciales');
    Route::get('/admin/clientescerrados/', [ClientesPotencialesCerradosController::class, "grafico"])->name('clientescerrados');
    Route::get('/admin/fuenteclientes/', [FuenteClientesController::class, "grafico"])->name('fuenteclientes');
    Route::get('/admin/tareasporcategorias/', [TareasPorCategoriasController::class, "grafico"])->name('tareasporcategorias');
    Route::get('/admin/propiedadesclick/', [PropiedadesClickController::class, "grafico"])->name('propiedadesclick');
    Route::get('/admin/dashboardventas/', [DashboardVentasController::class, "index"])->name('dashboardventas');


    Route::get('/admin/mostrarinventario', [PropiedadesController::class, 'mostrarinventario'])->name("mostrarinventario");

    Route::post('/admin/propiedad/duplicar/{id}', [PropiedadesController::class, 'duplicar'])->name('duplicarPropiedad');

    Route::get('/admin/clientes/enviarpropiedad/{id}', [ClientesController::class, "enviarPropiedad"])->name("enviarpropiedad");
});
//  Opciones para asesores fin

Route::get('/admin/login/', function () {
    if (Auth::user() and Auth::user()->activo == 1) {
        return Redirect::route('dashboard');
    } else {
        return view('admin.login');
    }
})->name('login');


Route::get('/admin/input/', function () {
    return view('admin.propiedades.input');
})->name('input');

Route::post('/admin/loguearse/', [EntrarController::class, "login"])->name("loguearse");

Route::get('/admin/register', function () {
    return view("admin.register");
})->name("registro");

Route::post('/admin/registrarse/', [EntrarController::class, "registrarse"])->name("registrarse");

Route::get('/logout/', function () {
    Auth::logout();
    return Redirect::route('login');
})->name('logoutmenulateral');

Route::post('/logout/', function () {
    Auth::logout();
    return Redirect::route('login');
})->name('logout');

Route::get('/assets/{path}', function ($path) {
    $normalizedPath = ltrim($path, '/');

    if (str_contains($normalizedPath, '..')) {
        abort(404);
    }

    $candidates = [
        public_path('assets/' . $normalizedPath),
        storage_path('app/' . $normalizedPath),
    ];

    if (str_starts_with($normalizedPath, 'img/')) {
        $candidates[] = public_path($normalizedPath);
    }

    foreach ($candidates as $filePath) {
        if (File::exists($filePath) && File::isFile($filePath)) {
            return response()->file($filePath, ['Cache-Control' => 'public, max-age=86400']);
        }
    }

    $defaultImage = public_path('img/logo.png');
    if (File::exists($defaultImage)) {
        return response()->file($defaultImage, ['Cache-Control' => 'public, max-age=3600']);
    }

    abort(404);
})->where('path', '.*');

Route::get('/propiedadesPorAgente/{id_agente}', [propiedadesPorAgenteController::class, "show"])->name("propiedadesPorAgente");

Route::get('/{zona}', [propiedadPorZonaController::class, "index"])->name("propiedadesPorZona");

Route::get('/venta/{tipo}/', [propiedadPorZonaController::class, "tipo"])->name("propiedadesPorTipo");

Route::get('/tool/optimizar-imagenes', [OptimizarImagenesController::class, 'optimizar'])->name('optimizar-imagenes');
