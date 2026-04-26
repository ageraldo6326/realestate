<?php

use App\Models\Propiedad;
use App\Models\Disponible_para;
use App\Http\Controllers\Sitemap;
use App\Http\Livewire\Admin\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
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
use App\Http\Controllers\Admin\EnfoquesController;
use App\Http\Controllers\Admin\PortadasController;
use App\Http\Controllers\FuenteClientesController;
use App\Http\Controllers\Frontend\EquipoController;
use App\Http\Controllers\RegistrarVentasController;
use App\Http\Controllers\PropiedadesClickController;
use App\Http\Controllers\Admin\PropiedadesController;
use App\Http\Controllers\Admin\TestimoniosController;
use App\Http\Controllers\Admin\TipostareasController;
use App\Http\Controllers\Admin\PortadasParaController;
use App\Http\Controllers\Frontend\ContactosController;
use App\Http\Controllers\ClientesPotencialesController;
use App\Http\Controllers\TareasPorCategoriasController;
use App\Http\Controllers\Admin\DisponibleParaController;
use App\Http\Controllers\Admin\MostrarClienteController;
use App\Http\Controllers\Frontend\QuienesSomosController;
use App\Http\Controllers\Admin\TiposPropiedadesController;
use App\Http\Controllers\Frontend\ListaPropiedadesController;
use App\Http\Controllers\ClientesPotencialesCerradosController;
use App\Http\Controllers\Admin\VerClientesPorAsesoresController;
use App\Http\Controllers\ContactosTodos;
use App\Http\Controllers\ContactosTodosController;
use App\Http\Controllers\DashboardAsesorController;
use App\Http\Controllers\DashboardVentasController;
use App\Http\Controllers\Frontend\propiedadesPorAgenteController;
use App\Http\Controllers\Frontend\ListaPropiedadesPorAgenteController;

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






Route::get('/sitemap',[Sitemap::class,'sitemap']);


Route::get('/admin/clientes/veropciones/{id}',[ClientesController::class,"veropciones"])->name("veropciones");
Route::get('/admin/clientes/veropcionesendolares/{id}',[ClientesController::class,"veropcionesendolares"])->name("veropcionesendolares");


// frontend
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/propiedad/{id}',[Productdetails::class,'show'])->name('propiedad');
Route::get('/propiedades',[ListaPropiedadesController::class,'index'])->name("listapropiedades");
Route::get('/propiedades/agente/{id}',[ListaPropiedadesPorAgenteController::class,'index'])->name("listapropiedadesporagentes");
Route::get('/equipo',[EquipoController::class,'index'])->name("equipo");
Route::get('/contacto',[ContactosController::class,'index'])->name("contactos");
Route::get('/blog',[BlogController::class,'index'])->name("blog");
Route::get('/quienessomos',[QuienesSomosController::class,'index'])->name("quienessomos");


Route::get('/admin/vercualquierpropiedad/{id}',[PropiedadesController::class,'vercualquierpropiedad'])->name("vercualquierpropiedad");
Route::get('/admin/verpropiedades',[PropiedadesController::class,'verpropiedades'])->name("verpropiedades");


// Opciones para administradores

Route::middleware(['auth','role'])->group(function () {

    Route::get('/consulta/cliente-por-asesor',function(){
        return view('consultas.consultaClientesPorAsesor');
    })->name('consultaClientesAsesor');

    Route::get('/admin/contactostodos',[ContactosTodosController::class,'index'])->name('contactostodos');

    Route::get('/admin/dashboardventas/',[DashboardVentasController::class,"index"])->name('dashboardventas');

    Route::get('/admin/poraprobar/',[PropiedadesController::class,'aprobar'])->name("poraprobar");
    Route::get('/admin/borrarpropiedad/{id}',[PropiedadesController::class,'borrarpropiedad'])->name("borrarpropiedad");
    Route::get('/admin/consultarpropiedades',[PropiedadesController::class,'consultarpropiedades'])->name("consultarpropiedades");
    Route::get('/admin/editarpendientes/{id}',[PropiedadesController::class,'editPendiente'])->name("editarpendientes");
    Route::get('/admin/editarpendientescualquiera/{id}',[PropiedadesController::class,'editarpendientescualquiera'])->name("editarpendientescualquiera");
    Route::put('/admin/updatependientes/{id}',[PropiedadesController::class,'updatependientes'])->name("updatependientes");
    Route::put('/admin/updatecualquiera/{id}',[PropiedadesController::class,'updatecualquiera'])->name("updatecualquiera");

    Route::get('/admin/borrarusuario/{id}',[UsuarioController::class,'borrarusuario'])->name("borrarusuario");
    Route::get('/admin/borrarventa/{id}',[CrearVentasController::class,'borrarventa'])->name("borrarventa");

    Route::get('/consulta/verclientesporasesor/{asesorid}/{fecha_ini}/{fecha_fin}',[VerClientesPorAsesoresController::class,'index'])->name("verclientesporasesor");

    Route::get('/consulta/vercliente/{clienteid}',[MostrarClienteController::class,'show'])->name("vercliente");
    Route::get('/admin/registrarventa/',[RegistrarVentasController::class,'index'])->name("registrarventa");
    Route::get('/admin/crearventa/',[CrearVentasController::class,'index'])->name("crearventa");
    Route::get('/admin/editarventa/{id}',[CrearVentasController::class,'edit'])->name("editarventa");
    Route::post('/admin/grabarventa/',[CrearVentasController::class,'grabarventa'])->name("grabarventa");
    Route::post('/admin/actualizarventa/',[CrearVentasController::class,'actualizarventa'])->name("actualizarventa");

    Route::resource('/admin/testimonios',TestimoniosController::class);
    Route::resource('/admin/posts',PostsController::class);
    Route::resource('/admin/enfoques',EnfoquesController::class);
    Route::resource('/admin/inmobiliaria',EmpresaController::class);
    Route::resource('/admin/zonas',ZonasController::class);
    Route::resource('/admin/tipopropiedades',TiposPropiedadesController::class);
    Route::resource('/admin/estados',EstadosController::class);
    Route::resource('/admin/disponiblepara',DisponibleParaController::class);
    Route::resource('/admin/portadas',PortadasController::class);
    Route::resource('/admin/todo/tipostareas',TipostareasController::class);
    Route::resource('/admin/usuarios',UsuarioController::class);
});

// fin opciones para administradores

//  Opciones para asesores

Route::get('/admin/dashboard',function(){
    return view('admin.adminlte.dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('/admin/propiedades', PropiedadesController::class);    
    Route::resource('/admin/todo',TodoController::class);
    Route::get('/admin/clientes/verificar',[ClientesController::class,'verificar'])->name("verificar");   
    Route::resource('/admin/clientes',ClientesController::class);
    Route::get('/admin/dashboardasesor/',[DashboardAsesorController::class,"index"])->name('dashboardasesor');


    Route::get('/admin/clientespotenciales/',[ClientesPotencialesController::class,"grafico"])->name('clientespotenciales');
    Route::get('/admin/clientescerrados/',[ClientesPotencialesCerradosController::class,"grafico"])->name('clientescerrados');
    Route::get('/admin/fuenteclientes/',[FuenteClientesController::class,"grafico"])->name('fuenteclientes');
    Route::get('/admin/tareasporcategorias/',[TareasPorCategoriasController::class,"grafico"])->name('tareasporcategorias');
    Route::get('/admin/propiedadesclick/',[PropiedadesClickController::class,"grafico"])->name('propiedadesclick');  
    
    Route::get('/admin/mostrarinventario',[PropiedadesController::class,'mostrarinventario'])->name("mostrarinventario");

    Route::post('/admin/propiedad/duplicar/{id}',[PropiedadesController::class,'duplicar'])->name('duplicarPropiedad');
  
    Route::get('/admin/clientes/enviarpropiedad/{id}',[ClientesController::class,"enviarPropiedad"])->name("enviarpropiedad");
    Route::get('/admin/tareas/calendario',[TodoController::class,"calendario"])->name("calendario");

});
//  Opciones para asesores fin

Route::get('/admin/login/',function () {
    if (Auth::user() and Auth::user()->activo == 1) {
        // return view('admin.adminlte.dashboard2');
    }
    else {
        return view('admin.login');
    }
})->name('login');


Route::get('/admin/input/',function () {
        return view('admin.propiedades.input');
})->name('input');

Route::post('/admin/loguearse/',[EntrarController::class,"login"])->name("loguearse");

Route::get('/admin/register', function() {
    return view("admin.register");
})->name("registro");

Route::post('/admin/registrarse/',[EntrarController::class,"registrarse"])->name("registrarse");

Route::get('/logout/',function () {
    Auth::logout();
    return Redirect::route('login');
})->name('logout');

Route::post('/logout/', function () {
    Auth::logout();
    return Redirect::route('login');
})->name('logout');

Route::get('/propiedadesPorAgente/{id_agente}',[propiedadesPorAgenteController::class,"show"])->name("propiedadesPorAgente");