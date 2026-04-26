<?php

namespace App\Http\Controllers\Admin;


use Throwable;
use App\Models\Zonas;
use App\Models\Estados;
use App\Models\Clientes;
use App\Models\Propiedad;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Mail\EnviarPropiedad;
use App\Models\Disponible_para;
use App\Models\TiposDePropiedad;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;


class ClientesController extends Controller
{
    //

    public function enviarPropiedad($id)
    {

        $cliente = Clientes::where('id', $id)->first();

        Mail::to($cliente->email)->queue(new EnviarPropiedad($cliente));

        return back()->with('success', 'Mensaje enviado!');
    }

    public function veropciones($id)
    {

        $cliente = Clientes::where('id', $id)->first();

        $propiedades = Propiedad::query();

        $propiedades->select('estado_id', 'estado', 'referencia', 'moneda', 'propiedads.id', 'slug', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipos_de_propiedads.tipo', 'foto_vendedor', 'propiedads.disponible_para', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $propiedades->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id');
        $propiedades->orderBy('created_at', 'desc');
        $propiedades->where("propiedads.zona_id", "=", "$cliente->zona_id");
        $propiedades->where("propiedads.precio", ">=", "$cliente->precio_mini");
        $propiedades->where("propiedads.precio", "<=", "$cliente->precio_max");
        $propiedades->where("propiedads.habitaciones", ">=", "$cliente->habitaciones");
        $propiedades->where("propiedads.banos", ">=", "$cliente->banos");
        $propiedades->where("propiedads.parqueos", ">=", "$cliente->parqueos");
        $propiedades->where("propiedads.estado_id", "=", "$cliente->estado");
        $propiedades->where("propiedads.tipo", "=", "$cliente->tipo");
        $propiedades->where("propiedads.vendida", "=", 0);
        $propiedades->where("propiedads.activa", "=", 1);
        $propiedades->where("propiedads.moneda", "=", "RD$");

        if ($cliente->captadas_por == "mi") {
            $propiedades->where(function ($query) {
                $query->where('asignada_a', Auth::user()->email)
                    ->orWhere('captada_por', Auth::id())
                    ->orWhere('captada_por', Auth::user()->email)
                    ->orWhere('asignada_a', (string) Auth::id());
            });
        }


        $propiedades = $propiedades->get();



        $inmobiliaria = Inmobiliaria::first();

        $zonas = Zonas::all();

        $disponibles_para = Disponible_para::all();

        $tipos_propiedades = TiposDePropiedad::all();

        $propiedades_dolar = Propiedad::query();

        $propiedades_dolar->select('estado_id', 'estado', 'referencia', 'moneda', 'propiedads.id', 'slug', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipos_de_propiedads.tipo', 'foto_vendedor', 'propiedads.disponible_para', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades_dolar->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $propiedades_dolar->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades_dolar->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades_dolar->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id');
        $propiedades_dolar->orderBy('created_at', 'desc');
        $propiedades_dolar->where("propiedads.zona_id", "=", "$cliente->zona_id");
        $propiedades_dolar->where("propiedads.precio", ">=", "$cliente->precio_mini_dolar");
        $propiedades_dolar->where("propiedads.precio", "<=", "$cliente->precio_max_dolar");
        $propiedades_dolar->where("propiedads.habitaciones", ">=", "$cliente->habitaciones");
        $propiedades_dolar->where("propiedads.banos", ">=", "$cliente->banos");
        $propiedades_dolar->where("propiedads.parqueos", ">=", "$cliente->parqueos");
        $propiedades_dolar->where("propiedads.estado_id", "=", "$cliente->estado_en_dolares");
        $propiedades_dolar->where("propiedads.tipo", "=", "$cliente->tipo_en_dolares");
        $propiedades_dolar->where("propiedads.vendida", "=", 0);
        $propiedades_dolar->where("propiedads.activa", "=", 1);
        $propiedades_dolar->where("propiedads.moneda", "=", "US$");

        if ($cliente->captadas_por == "mi") {
            $propiedades_dolar->where(function ($query) {
                $query->where('asignada_a', Auth::user()->email)
                    ->orWhere('captada_por', Auth::id())
                    ->orWhere('captada_por', Auth::user()->email)
                    ->orWhere('asignada_a', (string) Auth::id());
            });
        }

        $propiedades_dolar = $propiedades_dolar->get();

        $usuario = User::where('id', '=', $cliente->asignado_a)->first();

        return view('admin.clientes.veropciones', compact('propiedades', 'propiedades_dolar', 'inmobiliaria', 'zonas', 'disponibles_para', 'tipos_propiedades', 'cliente', 'usuario'));
    }

    public function veropcionesendolares($id)
    {

        $cliente = Clientes::where('id', $id)->first();

        $propiedades_dolar = Propiedad::query();

        $propiedades_dolar->select('estado_id', 'estado', 'referencia', 'moneda', 'propiedads.id', 'slug', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipos_de_propiedads.tipo', 'foto_vendedor', 'propiedads.disponible_para', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades_dolar->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $propiedades_dolar->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades_dolar->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades_dolar->leftJoin('tipos_de_propiedads', 'propiedads.tipo', '=', 'tipos_de_propiedads.id');
        $propiedades_dolar->orderBy('created_at', 'desc');
        $propiedades_dolar->where("propiedads.zona_id", "=", "$cliente->zona_id");
        $propiedades_dolar->where("propiedads.precio", ">=", "$cliente->precio_mini_dolar");
        $propiedades_dolar->where("propiedads.precio", "<=", "$cliente->precio_max_dolar");
        $propiedades_dolar->where("propiedads.habitaciones", ">=", "$cliente->habitaciones");
        $propiedades_dolar->where("propiedads.banos", ">=", "$cliente->banos");
        $propiedades_dolar->where("propiedads.parqueos", ">=", "$cliente->parqueos");
        $propiedades_dolar->where("propiedads.estado_id", "=", "$cliente->estado");
        $propiedades_dolar->where("propiedads.tipo", "=", "$cliente->tipo");
        $propiedades_dolar->where("propiedads.vendida", "=", 0);
        $propiedades_dolar->where("propiedads.activa", "=", 1);
        $propiedades_dolar->where("propiedads.moneda", "=", "US$");

        if ($cliente->captadas_por == "mi") {
            $propiedades_dolar->where(function ($query) {
                $query->where('asignada_a', Auth::user()->email)
                    ->orWhere('captada_por', Auth::id())
                    ->orWhere('captada_por', Auth::user()->email)
                    ->orWhere('asignada_a', (string) Auth::id());
            });
        }

        $propiedades_dolar = $propiedades_dolar->get();

        $usuario = Auth::user();

        $inmobiliaria = Inmobiliaria::first();

        $zonas = Zonas::all();

        $disponibles_para = Disponible_para::all();

        $tipos_propiedades = TiposDePropiedad::all();

        return view('admin.clientes.veropciones', compact('propiedades', 'inmobiliaria', 'zonas', 'disponibles_para', 'tipos_propiedades', 'cliente', 'usuario'));
    }

    public function verificar(Request $request)
    {
        return view('admin.clientes.verificar');
    }


    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasAnyRole(['admin', 'superadmin']);
        $contactOwnershipDays = (int) (optional(Inmobiliaria::query()->first())->dias_propiedad_contactos ?? 90);
        if ($contactOwnershipDays < 1) {
            $contactOwnershipDays = 90;
        }
        $contactOwnershipStart = now()->subDays($contactOwnershipDays)->startOfDay();

        $baseQuery = Clientes::query();

        if (!$isAdmin) {
            $baseQuery->where(function ($query) {
                $query->where('captado_por', Auth::id())
                    ->orWhere('asignado_a', Auth::id());
            })->where('created_at', '>=', $contactOwnershipStart);
        }

        $hasEstatusColumn = Schema::hasColumn('clientes', 'estatus');

        $nuevosCount = $hasEstatusColumn
            ? (clone $baseQuery)->where('estatus', 'NUEVO')->count()
            : 0;

        $cierresCount = $hasEstatusColumn
            ? (clone $baseQuery)->where('estatus', 'CIERRE')->count()
            : 0;

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'activos' => (clone $baseQuery)->where('activo', 1)->count(),
            'nuevos' => $nuevosCount,
            'cierres' => $cierresCount,
        ];

        return view("admin.clientes.index", compact('stats'));
    }

    public function asignar()
    {

        return view("admin.clientes.asignar");
    }




    public function create()
    {
        $zonas = Zonas::all();
        $estados_propiedad = Estados::all();
        $tipos_propiedades = TiposDePropiedad::all();
        return view("admin.clientes.create", compact('zonas', 'estados_propiedad', 'tipos_propiedades'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
        ]);

        if (Clientes::where('telefono', $request->telefono)->exists()) {
            return back()->with('existe', 'Cliente Ya Existe');
        }


        try {

            $cliente = new Clientes();
            $cliente->nombre = $request->nombre;
            $cliente->titulo = $request->titulo;
            $cliente->tipo_contacto = $request->tipo_contacto;
            $cliente->telefono = $request->telefono;
            $cliente->email = $request->correo;
            $cliente->tipo_contacto2 = $request->tipo_contacto2;
            $cliente->medio = $request->medio;
            $cliente->testimonio = $request->testimonio;
            $cliente->captado_por = Auth::user()->id;
            $cliente->asignado_a = Auth::user()->id;
            $cliente->comentario = $request->comentario;
            $cliente->contact_at = $request->contact_at;

            if (is_numeric($request->zona_id))
                $cliente->zona_id = $request->zona_id;
            if (is_numeric($request->precio_mini))
                $cliente->precio_mini = $request->precio_mini;
            if (is_numeric($request->precio_max))
                $cliente->precio_max = $request->precio_max;
            if (is_numeric($request->habitaciones))
                $cliente->habitaciones = $request->habitaciones;
            if (is_numeric($request->parqueos))
                $cliente->parqueos = $request->parqueos;
            if (is_numeric($request->estadopropiedad))
                $cliente->estado = $request->estadopropiedad;
            if (is_numeric($request->tipo))
                $cliente->tipo = $request->tipo;


            if ($request->has('activo')) {
                $cliente->activo = 1;
            } else {
                $cliente->activo = 0;
            }

            $cliente->save();

            return Redirect::route('clientes.index');
        } catch (Throwable $e) {
            return back()->with('existe', 'Cliente Ya Existe');
        }
    }

    public function edit($id)
    {

        $cliente = Clientes::where('id', $id)->first();

        $zonas = Zonas::all();
        $estados_propiedad = Estados::all();
        $tipos_propiedades = TiposDePropiedad::all();

        return view('admin.clientes.edit', compact('cliente', 'zonas', 'estados_propiedad', 'tipos_propiedades'));
    }

    public function update(Request $request, $id)
    {

        try {

            $cliente = Clientes::where('id', $id)->first();

            $cliente->nombre = $request->nombre;
            $cliente->titulo = $request->titulo;
            $cliente->tipo_contacto = $request->tipo_contacto;
            $cliente->tipo_contacto2 = $request->tipo_contacto2;
            $cliente->medio = $request->medio;
            $cliente->testimonio = $request->testimonio;
            $cliente->captado_por = Auth::user()->id;
            $cliente->asignado_a = Auth::user()->id;
            $cliente->comentario = $request->comentario;
            $cliente->contact_at = $request->contact_at;
            $cliente->email = $request->email;

            if (is_numeric($request->zona_id))
                $cliente->zona_id = $request->zona_id;
            if (is_numeric($request->precio_mini))
                $cliente->precio_mini = $request->precio_mini;
            if (is_numeric($request->precio_max))
                $cliente->precio_max = $request->precio_max;
            if (is_numeric($request->habitaciones))
                $cliente->habitaciones = $request->habitaciones;
            if (is_numeric($request->parqueos))
                $cliente->parqueos = $request->parqueos;
            if (is_numeric($request->estadopropiedad))
                $cliente->estado = $request->estadopropiedad;
            if (is_numeric($request->tipo))
                $cliente->tipo = $request->tipo;


            if ($request->has('activo')) {
                $cliente->activo = 1;
            } else {
                $cliente->activo = 0;
            }

            $cliente->save();

            return Redirect::route('clientes.index');
        } catch (Throwable $e) {
            return back()->with('existe', 'Cliente Ya Existe');
        }
    }
}
