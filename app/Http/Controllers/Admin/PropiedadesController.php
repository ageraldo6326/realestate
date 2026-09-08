<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Jorenvh\Share\Share;
use App\Events\PropertySaved;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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

        $this->ensurePropertyImageDirectory($propiedad);
        $this->storeUploadedPropertyImage($request, $propiedad, 'foto_portada', 'portada');

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


        foreach (range(1, 8) as $index) {
            $field = 'foto' . $index;
            $this->storeUploadedPropertyImage($request, $propiedad, $field, $field);
        }

        $propiedad->video1 = str_replace('watch?v=', 'embed/', $request->video1);


        $propiedad->Moneda = $request->tipomoneda;

        $propiedad->estado_id = $request->estadopropiedad;
        $propiedad->marcadeagua = $request->boolean('marcadeagua');

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
        $this->syncPropertyImagesWithWatermark($propiedad, (bool) $propiedad->marcadeagua);
        PropertySaved::dispatch($propiedad);
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
            ->select('estado_id', 'comision', 'referencia', 'fechacierre', 'estado', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'ciudad', 'sector_id', 'barrio_id', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa', 'marcadeagua')
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
        $propiedad = Propiedad::where('id', '=', $id)->first();

        if (!$propiedad) {
            return back()->with('borrarpropiedad', 'No se encontro la propiedad ' . $id . '.');
        }

        foreach (['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'] as $field) {
            $this->deletePropertyImage($propiedad, $field);
        }

        $propiedad->delete();

        $baseDirectory = public_path('img/propiedades/img');
        if (is_dir($baseDirectory)) {
            $referencedImages = Propiedad::query()
                ->select(['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'])
                ->get()
                ->flatMap(function (Propiedad $property) {
                    return [
                        $property->foto_portada,
                        $property->foto1,
                        $property->foto2,
                        $property->foto3,
                        $property->foto4,
                        $property->foto5,
                        $property->foto6,
                        $property->foto7,
                        $property->foto8,
                    ];
                })
                ->filter()
                ->map(function ($path) {
                    return str_replace('\\', '/', ltrim((string) $path, '/'));
                })
                ->unique()
                ->flip()
                ->all();

            foreach (File::allFiles($baseDirectory) as $file) {
                $absolutePath = $file->getPathname();
                $relativePath = str_replace('\\', '/', ltrim(str_replace(public_path(), '', $absolutePath), '/'));

                if (!array_key_exists($relativePath, $referencedImages)) {
                    @unlink($absolutePath);
                }
            }

            foreach (array_reverse(File::directories($baseDirectory)) as $directory) {
                if (empty(File::files($directory)) && empty(File::directories($directory))) {
                    @rmdir($directory);
                }
            }
        }

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

        $this->ensurePropertyImageDirectory($propiedad);
        $this->storeUploadedPropertyImage($request, $propiedad, 'foto_portada', 'portada');


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

        foreach (range(1, 8) as $index) {
            $field = 'foto' . $index;
            $this->storeUploadedPropertyImage($request, $propiedad, $field, $field);

            if ($request->has('ckfoto' . $index)) {
                $this->deletePropertyImage($propiedad, $field);
            }
        }


        if ($request->video1 != "") {
            $propiedad->video1 = str_replace('watch?v=', 'embed/', $request->video1);
        } else {
            $propiedad->video1 = "";
        }

        $propiedad->estado_id = $request->estadopropiedad;

        $propiedad->Moneda = $request->tipomoneda;
        $propiedad->marcadeagua = $request->boolean('marcadeagua');

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
        $this->syncPropertyImagesWithWatermark($propiedad, (bool) $propiedad->marcadeagua);
        PropertySaved::dispatch($propiedad);

        $baseDirectory = public_path('img/propiedades/img');
        if (is_dir($baseDirectory)) {
            $referencedImages = Propiedad::query()
                ->select(['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'])
                ->get()
                ->flatMap(function (Propiedad $property) {
                    return [
                        $property->foto_portada,
                        $property->foto1,
                        $property->foto2,
                        $property->foto3,
                        $property->foto4,
                        $property->foto5,
                        $property->foto6,
                        $property->foto7,
                        $property->foto8,
                    ];
                })
                ->filter()
                ->map(function ($path) {
                    return str_replace('\\', '/', ltrim((string) $path, '/'));
                })
                ->unique()
                ->flip()
                ->all();

            foreach (File::allFiles($baseDirectory) as $file) {
                $absolutePath = $file->getPathname();
                $relativePath = str_replace('\\', '/', ltrim(str_replace(public_path(), '', $absolutePath), '/'));

                if (!array_key_exists($relativePath, $referencedImages)) {
                    @unlink($absolutePath);
                }
            }

            foreach (array_reverse(File::directories($baseDirectory)) as $directory) {
                if (empty(File::files($directory)) && empty(File::directories($directory))) {
                    @rmdir($directory);
                }
            }
        }

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

        $this->ensurePropertyImageDirectory($propiedad);
        $this->storeUploadedPropertyImage($request, $propiedad, 'foto_portada', 'portada');


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

        foreach (range(1, 8) as $index) {
            $field = 'foto' . $index;
            $this->storeUploadedPropertyImage($request, $propiedad, $field, $field);

            if ($request->has('ckfoto' . $index)) {
                $this->deletePropertyImage($propiedad, $field);
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

        $baseDirectory = public_path('img/propiedades/img');
        if (is_dir($baseDirectory)) {
            $referencedImages = Propiedad::query()
                ->select(['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'])
                ->get()
                ->flatMap(function (Propiedad $property) {
                    return [
                        $property->foto_portada,
                        $property->foto1,
                        $property->foto2,
                        $property->foto3,
                        $property->foto4,
                        $property->foto5,
                        $property->foto6,
                        $property->foto7,
                        $property->foto8,
                    ];
                })
                ->filter()
                ->map(function ($path) {
                    return str_replace('\\', '/', ltrim((string) $path, '/'));
                })
                ->unique()
                ->flip()
                ->all();

            foreach (File::allFiles($baseDirectory) as $file) {
                $absolutePath = $file->getPathname();
                $relativePath = str_replace('\\', '/', ltrim(str_replace(public_path(), '', $absolutePath), '/'));

                if (!array_key_exists($relativePath, $referencedImages)) {
                    @unlink($absolutePath);
                }
            }

            foreach (array_reverse(File::directories($baseDirectory)) as $directory) {
                if (empty(File::files($directory)) && empty(File::directories($directory))) {
                    @rmdir($directory);
                }
            }
        }

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

        $this->ensurePropertyImageDirectory($propiedad);
        $this->storeUploadedPropertyImage($request, $propiedad, 'foto_portada', 'portada');


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

        foreach (range(1, 8) as $index) {
            $field = 'foto' . $index;
            $this->storeUploadedPropertyImage($request, $propiedad, $field, $field);

            if ($request->has('ckfoto' . $index)) {
                $this->deletePropertyImage($propiedad, $field);
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

        $baseDirectory = public_path('img/propiedades/img');
        if (is_dir($baseDirectory)) {
            $referencedImages = Propiedad::query()
                ->select(['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'])
                ->get()
                ->flatMap(function (Propiedad $property) {
                    return [
                        $property->foto_portada,
                        $property->foto1,
                        $property->foto2,
                        $property->foto3,
                        $property->foto4,
                        $property->foto5,
                        $property->foto6,
                        $property->foto7,
                        $property->foto8,
                    ];
                })
                ->filter()
                ->map(function ($path) {
                    return str_replace('\\', '/', ltrim((string) $path, '/'));
                })
                ->unique()
                ->flip()
                ->all();

            foreach (File::allFiles($baseDirectory) as $file) {
                $absolutePath = $file->getPathname();
                $relativePath = str_replace('\\', '/', ltrim(str_replace(public_path(), '', $absolutePath), '/'));

                if (!array_key_exists($relativePath, $referencedImages)) {
                    @unlink($absolutePath);
                }
            }

            foreach (array_reverse(File::directories($baseDirectory)) as $directory) {
                if (empty(File::files($directory)) && empty(File::directories($directory))) {
                    @rmdir($directory);
                }
            }
        }

        $this->misitemap();

        return Redirect::route('consultarpropiedades');
    }

    protected function ensurePropertyImageDirectory(Propiedad $propiedad): string
    {
        $directory = public_path('img/propiedades/img/' . $propiedad->referencia);

        if (!is_dir($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        return rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    protected function storeUploadedPropertyImage(Request $request, Propiedad $propiedad, string $field, string $basename): void
    {
        if (!$request->hasFile($field)) {
            return;
        }

        $directory = $this->ensurePropertyImageDirectory($propiedad);
        $this->deletePropertyImageArtifacts($directory, $basename, (string) data_get($propiedad, $field));

        $uploadedFile = $request->file($field);
        $extension = strtolower((string) ($uploadedFile->getClientOriginalExtension() ?: $uploadedFile->extension() ?: 'jpg'));
        $filename = sprintf('%s-%s-%s.%s', $basename, now()->format('YmdHis'), Str::lower(Str::random(8)), $extension);

        $uploadedFile->move($directory, $filename);

        $propiedad->{$field} = '/img/propiedades/img/' . $propiedad->referencia . '/' . $filename;
    }

    protected function deletePropertyImage(Propiedad $propiedad, string $field): void
    {
        $currentPath = (string) data_get($propiedad, $field);

        if ($currentPath === '') {
            return;
        }

        $directory = $this->ensurePropertyImageDirectory($propiedad);
        $basename = $field === 'foto_portada' ? 'portada' : $field;

        $this->deletePropertyImageArtifacts($directory, $basename, $currentPath);
        $propiedad->{$field} = '';
    }

    protected function deletePropertyImageArtifacts(string $directory, string $basename, ?string $currentPath = null): void
    {
        $targets = [];

        foreach ([$directory . $basename . '.*', $directory . $basename . '-*'] as $pattern) {
            foreach (glob($pattern) ?: [] as $match) {
                $targets[] = $match;
            }
        }

        if ($currentPath) {
            $absoluteCurrentPath = public_path(ltrim($currentPath, '/'));
            $targets[] = $absoluteCurrentPath;
            $targets[] = $this->getWatermarkBackupPath($absoluteCurrentPath);
        }

        foreach (array_unique($targets) as $target) {
            if (is_file($target)) {
                @unlink($target);
            }
        }
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

    protected function syncPropertyImagesWithWatermark(Propiedad $propiedad, bool $withWatermark): void
    {
        $logoPath = public_path('assets/inmobiliaria/logo.png');

        foreach (['foto_portada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'] as $field) {
            $relativePath = (string) data_get($propiedad, $field);

            if ($relativePath === '') {
                continue;
            }

            $absolutePath = public_path(ltrim($relativePath, '/'));

            if (!file_exists($absolutePath)) {
                continue;
            }

            try {
                $backupPath = $this->getWatermarkBackupPath($absolutePath);

                if ($withWatermark) {
                    if (!file_exists($backupPath)) {
                        copy($absolutePath, $backupPath);
                    }

                    if (!file_exists($logoPath)) {
                        continue;
                    }

                    $base = Image::make($backupPath)->fit(850, 650);

                    $targetLogoWidth = max(90, (int) round($base->width() * 0.18));
                    $watermark = Image::make($logoPath)
                        ->widen($targetLogoWidth, function ($constraint) {
                            $constraint->upsize();
                        })
                        ->opacity(50);

                    $base->insert($watermark, 'center')->save($absolutePath, 90);
                } else {
                    if (file_exists($backupPath)) {
                        copy($backupPath, $absolutePath);
                    } elseif (Storage::disk('local')->exists(ltrim($relativePath, '/'))) {
                        file_put_contents($absolutePath, Storage::disk('local')->get(ltrim($relativePath, '/')));
                    }
                }
            } catch (\Throwable $exception) {
                Log::warning('No se pudo aplicar marca de agua a imagen de propiedad.', [
                    'propiedad_id' => $propiedad->id,
                    'field' => $field,
                    'path' => $relativePath,
                    'error' => $exception->getMessage(),
                ]);
            }
        }
    }

    protected function getWatermarkBackupPath(string $absolutePath): string
    {
        return $absolutePath . '.orig';
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

        return (bool) $user->can('access-admin');
    }
}
