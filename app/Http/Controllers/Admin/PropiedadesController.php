<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Jorenvh\Share\Share;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use App\Services\SitemapService;

class PropiedadesController extends Controller
{
    //

    public function misitemap()
    {
        $inmo = InmobiliariaService::get();

        if (!$inmo) {
            return '';
        }

        app(SitemapService::class)->refresh();

        return rtrim((string) $inmo->dominio, '/') . '/sitemap.xml';
    }

    public function duplicar(Request $request, $id)
    {

        // $id = $request->id;

        $propiedad = Propiedad::where('id', $id)->first();
        $nuevaPropiedad = $propiedad->replicate();
        $nuevaPropiedad->created_at = Carbon::now();
        $nuevaPropiedad->captada_por = Auth::user()->id;
        $nuevaPropiedad->asignada_a = Auth::user()->email;
        $nuevaPropiedad->asignada_a_id = Auth::id();
        $nuevaPropiedad->destacada = 0;
        $nuevaPropiedad->activa = 0;
        $nuevaPropiedad->clicks = 0;
        $nuevaPropiedad->foto1 = "";
        $nuevaPropiedad->foto2 = "";
        $nuevaPropiedad->foto3 = "";
        $nuevaPropiedad->foto4 = "";
        $nuevaPropiedad->foto5 = "";
        $nuevaPropiedad->foto6 = "";
        $nuevaPropiedad->foto7 = "";
        $nuevaPropiedad->foto8 = "";
        $nuevaPropiedad->titulo = "";

        $id = Propiedad::max('id');

        if ($id == null) {
            $id = 0;
        }

        $id = ++$id;

        $id = 'PROP-' . str_pad($id, 10, '0', STR_PAD_LEFT);

        $nuevaPropiedad->referencia = $id;

        $directorio = public_path() . '/img/propiedades/img/' . $nuevaPropiedad->referencia . '/';

        $nuevaPropiedad->foto_portada = "COLOCAR TITULO REF:" . $nuevaPropiedad->referencia;

        if (!is_dir($directorio)) {
            File::makeDirectory($directorio, 0777, true, true);
        }


        $nuevaPropiedad->save();
        $this->misitemap();

        $propiedades = DB::table('propiedads')
            ->select('propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->orderBy('created_at', 'desc')
            ->where(function ($query) {
                $query->where('asignada_a', Auth::user()->email)
                    ->orWhere('captada_por', Auth::id())
                    ->orWhere('captada_por', Auth::user()->email)
                    ->orWhere('asignada_a', (string) Auth::id());
            })
            ->paginate(5);

        return view('admin.propiedades.index', compact('propiedades'));
    }

    public function aprobar()
    {


        $inmobiliaria = InmobiliariaService::get();

        if ((bool) optional($inmobiliaria)->aprobacion) {

            $propiedades_pendientes = Propiedad::query();

            $propiedades_pendientes->where('aprobada', '=', 0);


            return view('admin.propiedades.pendientes', compact('propiedades_pendientes'));
        }
    }

    public function consultarpropiedades()
    {


        return view('admin.propiedades.consultarpropiedades');
    }

    public function mostrarinventario()
    {
        return view('admin.inventario.index');
    }

    public function verpropiedades()
    {


        return view('admin.propiedades.consultarpropiedades');
    }

    public function index(Request $request)
    {

        if ($request->criterio == "") {
            $propiedades = DB::table('propiedads')
                ->select('propiedads.id', 'referencia', 'referencia', 'comision', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
                ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
                ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
                ->orderBy('created_at', 'desc')
                ->where(function ($query) {
                    $query->where('asignada_a', Auth::user()->email)
                        ->orWhere('captada_por', Auth::id())
                        ->orWhere('captada_por', Auth::user()->email)
                        ->orWhere('asignada_a', (string) Auth::id());
                })
                ->paginate(5);
        } else {

            $propiedades = DB::table('propiedads')
                ->select('propiedads.id', 'referencia', 'referencia', 'comision', 'foto_portada', 'aprobada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
                ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
                ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
                ->orderBy('created_at', 'desc')
                ->where(function ($query) use ($request) {
                    $query->where('titulo', 'like', "%{$request->criterio}%")
                        ->orWhere('propiedads.id', $request->criterio)
                        ->orWhere('zona', 'like', "%{$request->criterio}%");
                })
                ->where(function ($query) {
                    $query->where('asignada_a', Auth::user()->email)
                        ->orWhere('captada_por', Auth::id())
                        ->orWhere('captada_por', Auth::user()->email)
                        ->orWhere('asignada_a', (string) Auth::id());
                })
                ->paginate(5);
        };

        return view('admin.propiedades.index', compact('propiedades'));
    }

    public function create()
    {
        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $estados_propiedad = CatalogoService::estados();

        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores();
        $barrios = CatalogoService::barrios();

        return view('admin.propiedades.create', compact('estados_propiedad', 'disponibles_para', 'tipos_propiedades', 'provincias', 'sectores', 'barrios'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'foto_portada' => 'required',
            'titulo' => 'required|min:10|max:60',
            'descripcion_corta' => 'required|min:20|max:160',
            'descripcion' => 'required',
            'metadescription' => 'required|min:20|max:160',
            'provincia' => 'required|exists:provincias,id',
            'sector_id' => 'required|exists:sectores,id',
            'tipomoneda' => 'required',
            'precio' => 'required',
            'tipo' => 'required',
            'habitaciones' => 'required',
            'banos' => 'required',
            'parqueos' => 'required',
            'metraje' => 'required',
            'tipo' => 'required',
            'disponible_para' => 'required'
        ]);


        $id = Propiedad::max('id');

        if ($id == null) {
            $id = 0;
        }

        $id = ++$id;

        $propiedad = new Propiedad();

        $id = 'PROP-' . str_pad($id, 10, '0', STR_PAD_LEFT);

        $propiedad->referencia = $id;

        $directorio = public_path() . '/img/propiedades/img/' . $propiedad->referencia . '/';

        if (!is_dir($directorio)) {
            File::makeDirectory($directorio, 0777, true, true);
        }

        if ($request->hasFile('foto_portada')) {

            $urlfoto = $request->file("foto_portada");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'portada.' . $urlfoto->extension();

            $propiedad->foto_portada = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'portada.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        $propiedad->provincia = $request->provincia;
        $propiedad->ciudad = null;
        $propiedad->sector_id = $request->sector_id;
        $propiedad->barrio_id = null;
        $propiedad->direccion = $request->direccion;
        $propiedad->precio = str_replace([','], '', $request->precio);
        $propiedad->comision = $request->filled('comision') ? (float) $request->comision : 0;
        $propiedad->titulo = $request->titulo;
        $propiedad->slug = $this->buildUniquePropertySlug($request->titulo);
        $propiedad->descripcion_corta = $request->descripcion_corta;
        $propiedad->descripcion = $request->descripcion;
        $propiedad->metadescripcion = $request->metadescripcion;
        $propiedad->habitaciones = $request->habitaciones;
        $propiedad->banos = $request->banos;
        $propiedad->parqueos = $request->parqueos;
        $propiedad->metraje = $request->metraje;
        $propiedad->metraje_construccion = $request->metraje_construccion;
        $propiedad->asignada_a = Auth::user()->email;
        $propiedad->asignada_a_id = Auth::id();
        $propiedad->captada_por = Auth::id();
        $propiedad->tipo = $request->tipo;
        $propiedad->foto_vendedor = $request->foto_vendedor;
        $propiedad->disponible_para = $request->disponible_para;
        if ($request->has('destacada'))
            $propiedad->destacada = 1;


        if ($request->hasFile('foto1')) {

            $urlfoto = $request->file("foto1");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto1.' . $urlfoto->extension();

            $propiedad->foto1 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto1.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto2')) {

            $urlfoto = $request->file("foto2");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto2.' . $urlfoto->extension();

            $propiedad->foto2 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto2.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto3')) {

            $urlfoto = $request->file("foto3");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto3.' . $urlfoto->extension();

            $propiedad->foto3 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto3.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto4')) {

            $urlfoto = $request->file("foto4");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto4.' . $urlfoto->extension();

            $propiedad->foto4 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto4.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto5')) {

            $urlfoto = $request->file("foto5");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto5.' . $urlfoto->extension();

            $propiedad->foto5 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto5.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto6')) {

            $urlfoto = $request->file("foto6");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto6.' . $urlfoto->extension();

            $propiedad->foto6 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto6.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto7')) {

            $urlfoto = $request->file("foto7");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto7.' . $urlfoto->extension();

            $propiedad->foto7 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto7.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('foto8')) {

            $urlfoto = $request->file("foto8");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto8.' . $urlfoto->extension();

            $propiedad->foto8 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto8.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        $propiedad->video1 = str_replace('watch?v=', 'embed/', $request->video1);


        $propiedad->Moneda = $request->tipomoneda;

        $propiedad->estado_id = $request->estadopropiedad;

        if ($request->has('vendida'))
            $propiedad->vendida = 1;
        if ($request->has('lobby'))
            $propiedad->lobby = 1;
        if ($request->has('plantaelectrica'))
            $propiedad->plantaelectrica = 1;
        if ($request->has('camaravigilancia'))
            $propiedad->camaravigilancia = 1;
        if ($request->has('escaleraemergencia'))
            $propiedad->escaleraemergencia = 1;
        if ($request->has('maderapreciosa'))
            $propiedad->maderapreciosa = 1;
        if ($request->has('balcon'))
            $propiedad->balcon = 1;
        if ($request->has('walkincloset'))
            $propiedad->walkincloset = 1;
        if ($request->has('jacuzzi'))
            $propiedad->jacuzzi = 1;
        if ($request->has('areainfantil'))
            $propiedad->areainfantil = 1;
        if ($request->has('banovisitas'))
            $propiedad->banovisitas = 1;
        if ($request->has('cisterna'))
            $propiedad->cisterna = 1;
        if ($request->has('inversorareacomun'))
            $propiedad->inversorareacomun = 1;
        if ($request->has('gascomun'))
            $propiedad->gascomun = 1;
        if ($request->has('gazebo'))
            $propiedad->gazebo = 1;
        if ($request->has('pozo'))
            $propiedad->pozo = 1;
        if ($request->has('piscina'))
            $propiedad->piscina = 1;
        if ($request->has('familyroom'))
            $propiedad->familyroom = 1;
        if ($request->has('cuartodeservicio'))
            $propiedad->cuartodeservicio = 1;
        if ($request->has('patio'))
            $propiedad->patio = 1;
        if ($request->has('portonelectrico'))
            $propiedad->portonelectrico = 1;
        if ($request->has('seguridad24horas'))
            $propiedad->seguridad24horas = 1;
        if ($request->has('ascensor'))
            $propiedad->ascensor = 1;
        if ($request->has('parqueostechados'))
            $propiedad->parqueostechados = 1;
        if ($request->has('preinstalacionairetinacoinversor'))
            $propiedad->preinstalacionairetinacoinversor = 1;
        if ($request->has('terraza'))
            $propiedad->terraza = 1;
        if ($request->has('estudio'))
            $propiedad->estudio = 1;
        if ($request->has('gimnasio'))
            $propiedad->gimnasio = 1;
        if ($request->has('controldeacceso'))
            $propiedad->controldeacceso = 1;

        $propiedad->clicks = 0;
        $propiedad->metadescription = $request->metadescription;
        $propiedad->aprobada = $this->shouldRequireReviewForCurrentUser() ? 0 : 1;
        $propiedad->activa = 1;

        $propiedad->save();
        $this->misitemap();

        return Redirect::route('propiedades.index');
    }

    public function ver($id)
    {


        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'comision', 'referencia', 'estado', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            // ->where('asignada_a',Auth::user()->email)
            ->where('propiedads.id', $id)
            ->first();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $zonas = CatalogoService::zonas();
        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores();
        $barrios = CatalogoService::barrios();

        $estados_propiedad = CatalogoService::estados();

        return view('admin.propiedades.ver', compact('estados_propiedad', 'propiedad', 'zonas', 'disponibles_para', 'tipos_propiedades', 'provincias', 'sectores', 'barrios'));
    }

    public function edit($id)
    {


        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'comision', 'referencia', 'fechacierre', 'estado', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->where(function ($query) {
                $query->where('asignada_a', Auth::user()->email)
                    ->orWhere('captada_por', Auth::id())
                    ->orWhere('captada_por', Auth::user()->email)
                    ->orWhere('asignada_a', (string) Auth::id());
            })
            ->where('propiedads.id', $id)
            ->first();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $zonas = CatalogoService::zonas();
        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores();
        $barrios = CatalogoService::barrios();

        $estados_propiedad = CatalogoService::estados();

        $inmobiliaria = InmobiliariaService::get();

        return view('admin.propiedades.edit', compact('estados_propiedad', 'propiedad', 'zonas', 'disponibles_para', 'tipos_propiedades', 'provincias', 'sectores', 'barrios', 'inmobiliaria'));
    }

    public function editPendiente($id)
    {


        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'comision', 'referencia', 'estado', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->where('propiedads.id', $id)
            ->first();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores();
        $barrios = CatalogoService::barrios();

        $estados_propiedad = CatalogoService::estados();

        $inmobiliaria = InmobiliariaService::get();

        return view('admin.propiedades.editPendientes', compact('estados_propiedad', 'propiedad', 'zonas', 'disponibles_para', 'tipos_propiedades', 'provincias', 'sectores', 'barrios', 'inmobiliaria'));
    }

    public function borrarpropiedad($id)
    {
        $propiedad = Propiedad::where('id', '=', $id);
        $propiedad->delete();
        return back()->with('borrarpropiedad', 'Propiedad ' . $id . ' borrada!');
    }

    public function editarpendientescualquiera($id)
    {


        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'comision', 'estado', 'referencia', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->where('propiedads.id', $id)
            ->first();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $provincias = CatalogoService::provincias();
        $sectores = CatalogoService::sectores();
        $barrios = CatalogoService::barrios();

        $estados_propiedad = CatalogoService::estados();

        $inmobiliaria = InmobiliariaService::get();

        return view('admin.propiedades.editarpendientescualquiera', compact('estados_propiedad', 'propiedad', 'zonas', 'disponibles_para', 'tipos_propiedades', 'provincias', 'sectores', 'barrios', 'inmobiliaria'));
    }

    function vercualquierpropiedad($id)
    {

        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'comision', 'estado', 'referencia', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa')
            ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
            ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
            ->where('propiedads.id', $id)
            ->first();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $provincias = \App\Models\provincia::all();

        $estados_propiedad = CatalogoService::estados();

        $inmobiliaria = InmobiliariaService::get();

        return view('admin.propiedades.vercualquierpropiedad', compact('estados_propiedad', 'propiedad', 'zonas', 'disponibles_para', 'tipos_propiedades', 'provincias', 'inmobiliaria'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'titulo' => 'required|min:10|max:60',
            'descripcion' => 'required',
            'descripcion_corta' => 'required|max:160',
            'metadescription' => 'required|min:20|max:160',
            'provincia' => 'required|exists:provincias,id',
            'sector_id' => 'required|exists:sectores,id',
            'tipomoneda' => 'required',
            'precio' => 'required',
            'tipo' => 'required',
            'habitaciones' => 'required',
            'banos' => 'required',
            'parqueos' => 'required',
            'metraje' => 'required',
            'tipo' => 'required',
            'disponible_para' => 'required'
        ]);

        $propiedad = Propiedad::where('id', $id)->first();

        $directorio = public_path() . '/img/propiedades/img/' . $propiedad->referencia . '/';

        if (!is_dir($directorio)) {
            File::makeDirectory($directorio, 0777, true, true);
        }

        if ($request->hasFile('foto_portada')) {

            $urlfoto = $request->file("foto_portada");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'portada.' . $urlfoto->extension();

            $propiedad->foto_portada = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'portada.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }


        $propiedad->provincia = $request->provincia;
        $propiedad->ciudad = null;
        $propiedad->sector_id = $request->sector_id;
        $propiedad->barrio_id = null;
        $propiedad->direccion = $request->direccion;
        $propiedad->precio = str_replace([','], '', $request->precio);
        $propiedad->comision = $request->filled('comision') ? (float) $request->comision : 0;
        $propiedad->titulo = $request->titulo;
        $propiedad->slug = $this->buildUniquePropertySlug($request->titulo, $propiedad->id);
        $propiedad->descripcion_corta = $request->descripcion_corta;
        $propiedad->descripcion = $request->descripcion;
        $propiedad->metadescripcion = $request->metadescripcion;
        $propiedad->habitaciones = $request->habitaciones;
        $propiedad->banos = $request->banos;
        $propiedad->parqueos = $request->parqueos;
        $propiedad->metraje = $request->metraje;
        $propiedad->metraje_construccion = $request->metraje_construccion;
        $propiedad->captada_por = $request->captada_por;
        $propiedad->tipo = $request->tipo;
        $propiedad->foto_vendedor = $request->foto_vendedor;
        $propiedad->disponible_para = $request->disponible_para;
        $propiedad->fechacierre = $request->fechacierre;

        if ($request->has('destacada'))
            $propiedad->destacada = 1;
        else
            $propiedad->destacada = 0;

        if ($this->canManagePropertyApproval()) {
            $propiedad->aprobada = $request->has('aprobada') ? 1 : 0;
        }

        if ($request->hasFile('foto1')) {

            $urlfoto = $request->file("foto1");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto1.' . $urlfoto->extension();

            $propiedad->foto1 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto1.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto1')) {
            if (file_exists(public_path($propiedad->foto1))) {
                unlink(public_path($propiedad->foto1));
                $propiedad->foto1 = "";
            }
        }

        if ($request->hasFile('foto2')) {

            $urlfoto = $request->file("foto2");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto2.' . $urlfoto->extension();

            $propiedad->foto2 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto2.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto2')) {
            if (file_exists(public_path($propiedad->foto2))) {
                unlink(public_path($propiedad->foto2));
                $propiedad->foto2 = "";
            }
        }

        if ($request->hasFile('foto3')) {

            $urlfoto = $request->file("foto3");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto3.' . $urlfoto->extension();

            $propiedad->foto3 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto3.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto3')) {
            if (file_exists(public_path($propiedad->foto3))) {
                unlink(public_path($propiedad->foto3));
                $propiedad->foto3 = "";
            }
        }

        if ($request->hasFile('foto4')) {

            $urlfoto = $request->file("foto4");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto4.' . $urlfoto->extension();

            $propiedad->foto4 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto4.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto4')) {
            if (file_exists(public_path($propiedad->foto4))) {
                unlink(public_path($propiedad->foto4));
                $propiedad->foto4 = "";
            }
        }

        if ($request->hasFile('foto5')) {

            $urlfoto = $request->file("foto5");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto5.' . $urlfoto->extension();

            $propiedad->foto5 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto5.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto5')) {
            if (file_exists(public_path($propiedad->foto5))) {
                unlink(public_path($propiedad->foto5));
                $propiedad->foto5 = "";
            }
        }

        if ($request->hasFile('foto6')) {

            $urlfoto = $request->file("foto6");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto6.' . $urlfoto->extension();

            $propiedad->foto6 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto6.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto6')) {
            if (file_exists(public_path($propiedad->foto6))) {
                unlink(public_path($propiedad->foto6));
                $propiedad->foto6 = "";
            }
        }

        if ($request->hasFile('foto7')) {

            $urlfoto = $request->file("foto7");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto7.' . $urlfoto->extension();

            $propiedad->foto7 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto7.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto7')) {
            if (file_exists(public_path($propiedad->foto7))) {
                unlink(public_path($propiedad->foto7));
                $propiedad->foto7 = "";
            }
        }

        if ($request->hasFile('foto8')) {

            $urlfoto = $request->file("foto8");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto8.' . $urlfoto->extension();

            $propiedad->foto8 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto8.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto8')) {
            if (file_exists(public_path($propiedad->foto8))) {
                unlink(public_path($propiedad->foto8));
                $propiedad->foto8 = "";
            }
        }


        if ($request->video1 != "") {
            $propiedad->video1 = str_replace('watch?v=', 'embed/', $request->video1);
        } else {
            $propiedad->video1 = "";
        }

        $propiedad->estado_id = $request->estadopropiedad;

        $propiedad->Moneda = $request->tipomoneda;

        if ($request->has('activa'))
            $propiedad->activa = 1;
        else $propiedad->activa = 0;

        if ($request->has('vendida'))
            $propiedad->vendida = 1;
        else $propiedad->vendida = 0;

        if ($request->has('lobby'))
            $propiedad->lobby = 1;
        else $propiedad->lobby = 0;

        if ($request->has('plantaelectrica'))
            $propiedad->plantaelectrica = 1;
        else $propiedad->plantaelectrica = 0;

        if ($request->has('camaravigilancia'))
            $propiedad->camaravigilancia = 1;
        else $propiedad->camaravigilancia = 0;

        if ($request->has('escaleraemergencia'))
            $propiedad->escaleraemergencia = 1;
        else $propiedad->escaleraemergencia = 0;

        if ($request->has('maderapreciosa'))
            $propiedad->maderapreciosa = 1;
        else $propiedad->maderapreciosa = 0;

        if ($request->has('balcon'))
            $propiedad->balcon = 1;
        else $propiedad->balcon = 0;

        if ($request->has('walkincloset'))
            $propiedad->walkincloset = 1;
        else $propiedad->walkincloset = 0;

        if ($request->has('jacuzzi'))
            $propiedad->jacuzzi = 1;
        else $propiedad->jacuzzi = 0;

        if ($request->has('areainfantil'))
            $propiedad->areainfantil = 1;
        else $propiedad->areainfantil = 0;

        if ($request->has('banovisitas'))
            $propiedad->banovisitas = 1;
        else $propiedad->banovisitas = 0;

        if ($request->has('cisterna'))
            $propiedad->cisterna = 1;
        else $propiedad->cisterna = 0;

        if ($request->has('inversorareacomun'))
            $propiedad->inversorareacomun = 1;
        else $propiedad->inversorareacomun = 0;

        if ($request->has('gascomun'))
            $propiedad->gascomun = 1;
        else $propiedad->gascomun = 0;

        if ($request->has('gazebo'))
            $propiedad->gazebo = 1;
        else $propiedad->gazebo = 0;

        if ($request->has('pozo'))
            $propiedad->pozo = 1;
        else $propiedad->pozo = 0;

        if ($request->has('piscina'))
            $propiedad->piscina = 1;
        else $propiedad->piscina = 0;

        if ($request->has('familyroom'))
            $propiedad->familyroom = 1;
        else $propiedad->familyroom = 0;

        if ($request->has('cuartodeservicio'))
            $propiedad->cuartodeservicio = 1;
        else $propiedad->cuartodeservicio = 0;

        if ($request->has('patio'))
            $propiedad->patio = 1;
        else $propiedad->patio = 0;

        if ($request->has('portonelectrico'))
            $propiedad->portonelectrico = 1;
        else $propiedad->portonelectrico = 0;

        if ($request->has('seguridad24horas'))
            $propiedad->seguridad24horas = 1;
        else $propiedad->seguridad24horas = 0;

        if ($request->has('ascensor'))
            $propiedad->ascensor = 1;
        else $propiedad->ascensor = 0;

        if ($request->has('parqueostechados'))
            $propiedad->parqueostechados = 1;
        else $propiedad->parqueostechados = 0;

        if ($request->has('preinstalacionairetinacoinversor'))
            $propiedad->preinstalacionairetinacoinversor = 1;
        else $propiedad->preinstalacionairetinacoinversor = 0;

        if ($request->has('terraza'))
            $propiedad->terraza = 1;
        else $propiedad->terraza = 0;

        if ($request->has('estudio'))
            $propiedad->estudio = 1;
        else $propiedad->estudio = 0;

        if ($request->has('gimnasio'))
            $propiedad->gimnasio = 1;
        else $propiedad->gimnasio = 0;

        if ($request->has('controldeacceso'))
            $propiedad->controldeacceso = 1;
        else $propiedad->controldeacceso = 0;


        $propiedad->metadescription = $request->metadescription;

        $propiedad->save();
        $this->misitemap();

        return Redirect::route('propiedades.index');
    }

    public function updatependientes(Request $request, $id)
    {

        $request->validate([
            'titulo' => 'required|min:10|max:60',
            'descripcion_corta' => 'required|min:20|max:160',
            'descripcion' => 'required',
            'descripcion_corta' => 'required|max:160',
            'metadescription' => 'required|min:20|max:160',
            'provincia' => 'required',
            'sector_id' => 'required|exists:sectores,id',
            'tipomoneda' => 'required',
            'precio' => 'required',
            'tipo' => 'required',
            'habitaciones' => 'required',
            'banos' => 'required',
            'parqueos' => 'required',
            'metraje' => 'required',
            'tipo' => 'required',
            'disponible_para' => 'required'
        ]);

        $propiedad = Propiedad::where('id', $id)->first();

        $directorio = public_path() . '/img/propiedades/img/' . $propiedad->referencia . '/';

        if (!is_dir($directorio)) {
            File::makeDirectory($directorio, 0777, true, true);
        }

        if ($request->hasFile('foto_portada')) {

            $urlfoto = $request->file("foto_portada");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'portada.' . $urlfoto->extension();

            $propiedad->foto_portada = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'portada.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }


        $propiedad->provincia = $request->provincia;
        $propiedad->ciudad = null;
        $propiedad->sector_id = $request->sector_id;
        $propiedad->barrio_id = null;
        $propiedad->direccion = $request->direccion;
        $propiedad->precio = $request->precio;
        $propiedad->comision = $request->filled('comision') ? (float) $request->comision : 0;
        $propiedad->titulo = $request->titulo;
        $propiedad->slug = $this->buildUniquePropertySlug($request->titulo, $propiedad->id);
        $propiedad->descripcion_corta = $request->descripcion_corta;
        $propiedad->descripcion = $request->descripcion;
        $propiedad->metadescripcion = $request->metadescripcion;
        $propiedad->habitaciones = $request->habitaciones;
        $propiedad->banos = $request->banos;
        $propiedad->parqueos = $request->parqueos;
        $propiedad->metraje = $request->metraje;
        $propiedad->metraje_construccion = $request->metraje_construccion;
        $propiedad->captada_por = $request->captada_por;
        $propiedad->tipo = $request->tipo;
        $propiedad->foto_vendedor = $request->foto_vendedor;
        $propiedad->disponible_para = $request->disponible_para;

        if ($request->has('destacada'))
            $propiedad->destacada = 1;
        else
            $propiedad->destacada = 0;

        if ($this->canManagePropertyApproval()) {
            $propiedad->aprobada = $request->has('aprobada') ? 1 : 0;
        }

        if ($request->hasFile('foto1')) {

            $urlfoto = $request->file("foto1");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto1.' . $urlfoto->extension();

            $propiedad->foto1 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto1.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto1')) {
            if (file_exists(public_path($propiedad->foto1))) {
                unlink(public_path($propiedad->foto1));
                $propiedad->foto1 = "";
            }
        }

        if ($request->hasFile('foto2')) {

            $urlfoto = $request->file("foto2");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto2.' . $urlfoto->extension();

            $propiedad->foto2 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto2.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto2')) {
            if (file_exists(public_path($propiedad->foto2))) {
                unlink(public_path($propiedad->foto2));
                $propiedad->foto2 = "";
            }
        }

        if ($request->hasFile('foto3')) {

            $urlfoto = $request->file("foto3");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto3.' . $urlfoto->extension();

            $propiedad->foto3 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto3.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto3')) {
            if (file_exists(public_path($propiedad->foto3))) {
                unlink(public_path($propiedad->foto3));
                $propiedad->foto3 = "";
            }
        }

        if ($request->hasFile('foto4')) {

            $urlfoto = $request->file("foto4");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto4.' . $urlfoto->extension();

            $propiedad->foto4 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto4.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto4')) {
            if (file_exists(public_path($propiedad->foto4))) {
                unlink(public_path($propiedad->foto4));
                $propiedad->foto4 = "";
            }
        }

        if ($request->hasFile('foto5')) {

            $urlfoto = $request->file("foto5");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto5.' . $urlfoto->extension();

            $propiedad->foto5 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto5.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto5')) {
            if (file_exists(public_path($propiedad->foto5))) {
                unlink(public_path($propiedad->foto5));
                $propiedad->foto5 = "";
            }
        }

        if ($request->hasFile('foto6')) {

            $urlfoto = $request->file("foto6");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto6.' . $urlfoto->extension();

            $propiedad->foto6 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto6.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto6')) {
            if (file_exists(public_path($propiedad->foto6))) {
                unlink(public_path($propiedad->foto6));
                $propiedad->foto6 = "";
            }
        }

        if ($request->hasFile('foto7')) {

            $urlfoto = $request->file("foto7");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto7.' . $urlfoto->extension();

            $propiedad->foto7 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto7.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto7')) {
            if (file_exists(public_path($propiedad->foto7))) {
                unlink(public_path($propiedad->foto7));
                $propiedad->foto7 = "";
            }
        }

        if ($request->hasFile('foto8')) {

            $urlfoto = $request->file("foto8");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto8.' . $urlfoto->extension();

            $propiedad->foto8 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto8.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto8')) {
            if (file_exists(public_path($propiedad->foto8))) {
                unlink(public_path($propiedad->foto8));
                $propiedad->foto8 = "";
            }
        }


        if ($request->video1 != "") {
            $propiedad->video1 = str_replace('watch?v=', 'embed/', $request->video1);
        } else {
            $propiedad->video1 = "";
        }

        $propiedad->estado_id = $request->estadopropiedad;

        $propiedad->Moneda = $request->tipomoneda;

        if ($request->has('activa'))
            $propiedad->activa = 1;
        else $propiedad->activa = 0;

        if ($request->has('vendida'))
            $propiedad->vendida = 1;
        else $propiedad->vendida = 0;

        if ($request->has('lobby'))
            $propiedad->lobby = 1;
        else $propiedad->lobby = 0;

        if ($request->has('plantaelectrica'))
            $propiedad->plantaelectrica = 1;
        else $propiedad->plantaelectrica = 0;

        if ($request->has('camaravigilancia'))
            $propiedad->camaravigilancia = 1;
        else $propiedad->camaravigilancia = 0;

        if ($request->has('escaleraemergencia'))
            $propiedad->escaleraemergencia = 1;
        else $propiedad->escaleraemergencia = 0;

        if ($request->has('maderapreciosa'))
            $propiedad->maderapreciosa = 1;
        else $propiedad->maderapreciosa = 0;

        if ($request->has('balcon'))
            $propiedad->balcon = 1;
        else $propiedad->balcon = 0;

        if ($request->has('walkincloset'))
            $propiedad->walkincloset = 1;
        else $propiedad->walkincloset = 0;

        if ($request->has('jacuzzi'))
            $propiedad->jacuzzi = 1;
        else $propiedad->jacuzzi = 0;

        if ($request->has('areainfantil'))
            $propiedad->areainfantil = 1;
        else $propiedad->areainfantil = 0;

        if ($request->has('banovisitas'))
            $propiedad->banovisitas = 1;
        else $propiedad->banovisitas = 0;

        if ($request->has('cisterna'))
            $propiedad->cisterna = 1;
        else $propiedad->cisterna = 0;

        if ($request->has('inversorareacomun'))
            $propiedad->inversorareacomun = 1;
        else $propiedad->inversorareacomun = 0;

        if ($request->has('gascomun'))
            $propiedad->gascomun = 1;
        else $propiedad->gascomun = 0;

        if ($request->has('gazebo'))
            $propiedad->gazebo = 1;
        else $propiedad->gazebo = 0;

        if ($request->has('pozo'))
            $propiedad->pozo = 1;
        else $propiedad->pozo = 0;

        if ($request->has('piscina'))
            $propiedad->piscina = 1;
        else $propiedad->piscina = 0;

        if ($request->has('familyroom'))
            $propiedad->familyroom = 1;
        else $propiedad->familyroom = 0;

        if ($request->has('cuartodeservicio'))
            $propiedad->cuartodeservicio = 1;
        else $propiedad->cuartodeservicio = 0;

        if ($request->has('patio'))
            $propiedad->patio = 1;
        else $propiedad->patio = 0;

        if ($request->has('portonelectrico'))
            $propiedad->portonelectrico = 1;
        else $propiedad->portonelectrico = 0;

        if ($request->has('seguridad24horas'))
            $propiedad->seguridad24horas = 1;
        else $propiedad->seguridad24horas = 0;

        if ($request->has('ascensor'))
            $propiedad->ascensor = 1;
        else $propiedad->ascensor = 0;

        if ($request->has('parqueostechados'))
            $propiedad->parqueostechados = 1;
        else $propiedad->parqueostechados = 0;

        if ($request->has('preinstalacionairetinacoinversor'))
            $propiedad->preinstalacionairetinacoinversor = 1;
        else $propiedad->preinstalacionairetinacoinversor = 0;

        if ($request->has('terraza'))
            $propiedad->terraza = 1;
        else $propiedad->terraza = 0;

        if ($request->has('estudio'))
            $propiedad->estudio = 1;
        else $propiedad->estudio = 0;

        if ($request->has('gimnasio'))
            $propiedad->gimnasio = 1;
        else $propiedad->gimnasio = 0;

        if ($request->has('controldeacceso'))
            $propiedad->controldeacceso = 1;
        else $propiedad->controldeacceso = 0;


        $propiedad->metadescription = $request->metadescription;

        $propiedad->save();
        $this->misitemap();

        return Redirect::route('poraprobar');
    }

    public function updatecualquiera(Request $request, $id)
    {

        $request->validate([
            'titulo' => 'required|min:10|max:60',
            'descripcion_corta' => 'required|min:20|max:160',
            'descripcion' => 'required',
            'descripcion_corta' => 'required|max:160',
            'metadescription' => 'required|min:20|max:160',
            'provincia' => 'required',
            'sector_id' => 'required|exists:sectores,id',
            'tipomoneda' => 'required',
            'precio' => 'required',
            'tipo' => 'required',
            'habitaciones' => 'required',
            'banos' => 'required',
            'parqueos' => 'required',
            'metraje' => 'required',
            'tipo' => 'required',
            'disponible_para' => 'required'
        ]);

        $propiedad = Propiedad::where('id', $id)->first();

        $directorio = public_path() . '/img/propiedades/img/' . $propiedad->referencia . '/';

        if (!is_dir($directorio)) {
            File::makeDirectory($directorio, 0777, true, true);
        }

        if ($request->hasFile('foto_portada')) {

            $urlfoto = $request->file("foto_portada");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'portada.' . $urlfoto->extension();

            $propiedad->foto_portada = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'portada.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }


        $propiedad->provincia = $request->provincia;
        $propiedad->ciudad = null;
        $propiedad->sector_id = $request->sector_id;
        $propiedad->barrio_id = null;
        $propiedad->direccion = $request->direccion;
        $propiedad->precio = $request->precio;
        $propiedad->comision = $request->filled('comision') ? (float) $request->comision : 0;
        $propiedad->titulo = $request->titulo;
        $propiedad->slug = $this->buildUniquePropertySlug($request->titulo, $propiedad->id);
        $propiedad->descripcion_corta = $request->descripcion_corta;
        $propiedad->descripcion = $request->descripcion;
        $propiedad->metadescripcion = $request->metadescripcion;
        $propiedad->habitaciones = $request->habitaciones;
        $propiedad->banos = $request->banos;
        $propiedad->parqueos = $request->parqueos;
        $propiedad->metraje = $request->metraje;
        $propiedad->metraje_construccion = $request->metraje_construccion;
        $propiedad->captada_por = $request->captada_por;
        $propiedad->tipo = $request->tipo;
        $propiedad->foto_vendedor = $request->foto_vendedor;
        $propiedad->disponible_para = $request->disponible_para;

        if ($request->has('destacada'))
            $propiedad->destacada = 1;
        else
            $propiedad->destacada = 0;

        if ($this->canManagePropertyApproval()) {
            $propiedad->aprobada = $request->has('aprobada') ? 1 : 0;
        }

        if ($request->hasFile('foto1')) {

            $urlfoto = $request->file("foto1");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto1.' . $urlfoto->extension();

            $propiedad->foto1 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto1.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto1')) {
            if (file_exists(public_path($propiedad->foto1))) {
                unlink(public_path($propiedad->foto1));
                $propiedad->foto1 = "";
            }
        }

        if ($request->hasFile('foto2')) {

            $urlfoto = $request->file("foto2");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto2.' . $urlfoto->extension();

            $propiedad->foto2 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto2.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto2')) {
            if (file_exists(public_path($propiedad->foto2))) {
                unlink(public_path($propiedad->foto2));
                $propiedad->foto2 = "";
            }
        }

        if ($request->hasFile('foto3')) {

            $urlfoto = $request->file("foto3");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto3.' . $urlfoto->extension();

            $propiedad->foto3 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto3.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto3')) {
            if (file_exists(public_path($propiedad->foto3))) {
                unlink(public_path($propiedad->foto3));
                $propiedad->foto3 = "";
            }
        }

        if ($request->hasFile('foto4')) {

            $urlfoto = $request->file("foto4");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto4.' . $urlfoto->extension();

            $propiedad->foto4 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto4.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto4')) {
            if (file_exists(public_path($propiedad->foto4))) {
                unlink(public_path($propiedad->foto4));
                $propiedad->foto4 = "";
            }
        }

        if ($request->hasFile('foto5')) {

            $urlfoto = $request->file("foto5");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto5.' . $urlfoto->extension();

            $propiedad->foto5 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto5.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto5')) {
            if (file_exists(public_path($propiedad->foto5))) {
                unlink(public_path($propiedad->foto5));
                $propiedad->foto5 = "";
            }
        }

        if ($request->hasFile('foto6')) {

            $urlfoto = $request->file("foto6");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto6.' . $urlfoto->extension();

            $propiedad->foto6 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto6.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto6')) {
            if (file_exists(public_path($propiedad->foto6))) {
                unlink(public_path($propiedad->foto6));
                $propiedad->foto6 = "";
            }
        }

        if ($request->hasFile('foto7')) {

            $urlfoto = $request->file("foto7");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto7.' . $urlfoto->extension();

            $propiedad->foto7 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto7.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto7')) {
            if (file_exists(public_path($propiedad->foto7))) {
                unlink(public_path($propiedad->foto7));
                $propiedad->foto7 = "";
            }
        }

        if ($request->hasFile('foto8')) {

            $urlfoto = $request->file("foto8");

            $ruta = public_path('/img/propiedades/img/' . $propiedad->referencia . '/') . 'foto8.' . $urlfoto->extension();

            $propiedad->foto8 = '/img/propiedades/img/' . $propiedad->referencia . '/' . 'foto8.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->has('ckfoto8')) {
            if (file_exists(public_path($propiedad->foto8))) {
                unlink(public_path($propiedad->foto8));
                $propiedad->foto8 = "";
            }
        }


        if ($request->video1 != "") {
            $propiedad->video1 = str_replace('watch?v=', 'embed/', $request->video1);
        } else {
            $propiedad->video1 = "";
        }

        $propiedad->estado_id = $request->estadopropiedad;

        $propiedad->Moneda = $request->tipomoneda;

        if ($request->has('activa'))
            $propiedad->activa = 1;
        else $propiedad->activa = 0;

        if ($request->has('vendida'))
            $propiedad->vendida = 1;
        else $propiedad->vendida = 0;

        if ($request->has('lobby'))
            $propiedad->lobby = 1;
        else $propiedad->lobby = 0;

        if ($request->has('plantaelectrica'))
            $propiedad->plantaelectrica = 1;
        else $propiedad->plantaelectrica = 0;

        if ($request->has('camaravigilancia'))
            $propiedad->camaravigilancia = 1;
        else $propiedad->camaravigilancia = 0;

        if ($request->has('escaleraemergencia'))
            $propiedad->escaleraemergencia = 1;
        else $propiedad->escaleraemergencia = 0;

        if ($request->has('maderapreciosa'))
            $propiedad->maderapreciosa = 1;
        else $propiedad->maderapreciosa = 0;

        if ($request->has('balcon'))
            $propiedad->balcon = 1;
        else $propiedad->balcon = 0;

        if ($request->has('walkincloset'))
            $propiedad->walkincloset = 1;
        else $propiedad->walkincloset = 0;

        if ($request->has('jacuzzi'))
            $propiedad->jacuzzi = 1;
        else $propiedad->jacuzzi = 0;

        if ($request->has('areainfantil'))
            $propiedad->areainfantil = 1;
        else $propiedad->areainfantil = 0;

        if ($request->has('banovisitas'))
            $propiedad->banovisitas = 1;
        else $propiedad->banovisitas = 0;

        if ($request->has('cisterna'))
            $propiedad->cisterna = 1;
        else $propiedad->cisterna = 0;

        if ($request->has('inversorareacomun'))
            $propiedad->inversorareacomun = 1;
        else $propiedad->inversorareacomun = 0;

        if ($request->has('gascomun'))
            $propiedad->gascomun = 1;
        else $propiedad->gascomun = 0;

        if ($request->has('gazebo'))
            $propiedad->gazebo = 1;
        else $propiedad->gazebo = 0;

        if ($request->has('pozo'))
            $propiedad->pozo = 1;
        else $propiedad->pozo = 0;

        if ($request->has('piscina'))
            $propiedad->piscina = 1;
        else $propiedad->piscina = 0;

        if ($request->has('familyroom'))
            $propiedad->familyroom = 1;
        else $propiedad->familyroom = 0;

        if ($request->has('cuartodeservicio'))
            $propiedad->cuartodeservicio = 1;
        else $propiedad->cuartodeservicio = 0;

        if ($request->has('patio'))
            $propiedad->patio = 1;
        else $propiedad->patio = 0;

        if ($request->has('portonelectrico'))
            $propiedad->portonelectrico = 1;
        else $propiedad->portonelectrico = 0;

        if ($request->has('seguridad24horas'))
            $propiedad->seguridad24horas = 1;
        else $propiedad->seguridad24horas = 0;

        if ($request->has('ascensor'))
            $propiedad->ascensor = 1;
        else $propiedad->ascensor = 0;

        if ($request->has('parqueostechados'))
            $propiedad->parqueostechados = 1;
        else $propiedad->parqueostechados = 0;

        if ($request->has('preinstalacionairetinacoinversor'))
            $propiedad->preinstalacionairetinacoinversor = 1;
        else $propiedad->preinstalacionairetinacoinversor = 0;

        if ($request->has('terraza'))
            $propiedad->terraza = 1;
        else $propiedad->terraza = 0;

        if ($request->has('estudio'))
            $propiedad->estudio = 1;
        else $propiedad->estudio = 0;

        if ($request->has('gimnasio'))
            $propiedad->gimnasio = 1;
        else $propiedad->gimnasio = 0;

        if ($request->has('controldeacceso'))
            $propiedad->controldeacceso = 1;
        else $propiedad->controldeacceso = 0;


        $propiedad->metadescription = $request->metadescription;

        $propiedad->save();
        $this->misitemap();

        return Redirect::route('consultarpropiedades');
    }

    protected function buildUniquePropertySlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'propiedad';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $query = Propiedad::query()->where('slug', $slug);

            if ($ignoreId !== null) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }

    public function sectoresPorProvincia(Request $request)
    {
        $provinciaId = (int) $request->query('provincia_id');

        if ($provinciaId <= 0) {
            return response()->json([]);
        }

        $sectores = DB::table('sectores')
            ->select('id', 'sector', 'provincia_id')
            ->where('provincia_id', $provinciaId)
            ->orderBy('sector')
            ->get();

        return response()->json($sectores);
    }

    public function barriosPorSector(Request $request)
    {
        $sectorId = (int) $request->query('sector_id');

        if ($sectorId <= 0) {
            return response()->json([]);
        }

        $barrios = DB::table('barrios')
            ->select('id', 'barrio', 'sector_id')
            ->where('sector_id', $sectorId)
            ->orderBy('barrio')
            ->get();

        return response()->json($barrios);
    }

    protected function shouldRequireReviewForCurrentUser(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return true;
        }

        // User override has highest priority: false means immediate publish.
        if ($user->requiere_aprobacion_propiedades !== null) {
            return (bool) $user->requiere_aprobacion_propiedades;
        }

        $inmobiliaria = InmobiliariaService::get();
        return (bool) optional($inmobiliaria)->aprobacion;
    }

    protected function canManagePropertyApproval(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if (method_exists($user, 'hasAnyRole')) {
            return (bool) $user->hasAnyRole(['admin', 'superadmin']);
        }

        return (int) ($user->rol ?? 0) === 1;
    }
}
