<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Propiedad;
use App\Models\provincia as ProvinciaModel;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Events\PropertySaved;
use App\Services\InmobiliariaService;
use Livewire\WithFileUploads;
use App\Services\CatalogoService;
use App\Services\SitemapService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use Illuminate\Validation\Rule;

class BuscarPropiedad extends Component
{

    private static ?array $propiedadColumns = null;

    private const COVER_FIELD = 'foto_portada';

    private const GALLERY_FIELDS = [
        'foto1',
        'foto2',
        'foto3',
        'foto4',
        'foto5',
        'foto6',
        'foto7',
        'foto8',
    ];

    private const BOOLEAN_FIELDS = [
        'activa',
        'aprobada',
        'destacada',
        'vendida',
        'marcadeagua',
        'lobby',
        'plantaelectrica',
        'camaravigilancia',
        'escaleraemergencia',
        'maderapreciosa',
        'balcon',
        'walkincloset',
        'jacuzzi',
        'areainfantil',
        'banovisitas',
        'cisterna',
        'inversorareacomun',
        'gascomun',
        'gazebo',
        'pozo',
        'piscina',
        'familyroom',
        'cuartodeservicio',
        'patio',
        'portonelectrico',
        'seguridad24horas',
        'ascensor',
        'parqueostechados',
        'preinstalacionairetinacoinversor',
        'terraza',
        'estudio',
        'gimnasio',
        'controldeacceso',
    ];

    public $criterio;
    public $Id;
    public $referencia, $foto_portada, $provincia, $zona_id, $direccion, $precio, $titulo, $slug, $descripcion_corta;
    public $descripcion, $metadescripcion, $habitaciones, $banos, $parqueos, $metraje, $metraje_construccion, $asignada_a;
    public $captado_por, $tipo, $foto_vendedor, $disponible_para, $destacada, $foto1, $foto2, $foto3, $foto4, $foto5, $foto6, $foto7, $foto8;
    public $video1, $video2, $video3, $video4, $moneda, $vendia, $lobby, $plantaelectrica, $camaravigilancia, $escaleraemergencia;
    public $maderapreciosa, $balcon, $walkincloset, $jacuzzi, $areainfantil, $banovisitas, $cisterna, $inversorareacomun, $gascomun;
    public $gazebo, $pozo, $piscina, $familyroom, $cuartodeservicio, $patio, $portonelectrico, $seguridad24horas, $ascensor;
    public $parqueostechados, $preinstalacionairetinacoinversor, $terraza, $estudio, $gimnasio, $controldeacceso, $clicks, $metadescription;
    public $activa, $estado_id, $created_at, $updated_at, $aprobada, $fechacierre, $vendida;
    public $comision, $marcadeagua;

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'borrarPropiedad'
    ];

    public function borrarPropiedad($id)
    {

        $propiedad = Propiedad::find($id);
        if (!$propiedad) {
            return;
        }

        $propiedad->delete();

        Storage::disk('local')->deleteDirectory('propiedades/' . $id);
        File::deleteDirectory(public_path('assets/propiedades/' . $id));
    }

    public function render()
    {
        $name = $this->criterio;

        if ($this->criterio == "") {
            $propiedades = DB::table('propiedads')
                ->select('propiedads.id', 'referencia', 'foto_portada', 'propiedads.provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'activa', 'propiedads.created_at', 'propiedads.updated_at')
                ->selectRaw('COALESCE(propiedads.activa, 0) as activa_estado')
                ->addSelect('provincias.provincia as provincia_nombre', 'sectores.sector as sector_nombre')
                ->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id')
                ->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id')
                ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
                ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
                ->orderBy('propiedads.created_at', 'desc')
                ->where(function ($query) {
                    $query->where('asignada_a', Auth::user()->email)
                        ->orWhere('captada_por', Auth::id())
                        ->orWhere('captada_por', Auth::user()->email)
                        ->orWhere('asignada_a', (string) Auth::id());
                })
                ->paginate(5);
        } else {
            $propiedades = DB::table('propiedads')
                ->select('propiedads.id', 'referencia', 'foto_portada', 'propiedads.provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'activa', 'propiedads.created_at', 'propiedads.updated_at')
                ->selectRaw('COALESCE(propiedads.activa, 0) as activa_estado')
                ->addSelect('provincias.provincia as provincia_nombre', 'sectores.sector as sector_nombre')
                ->where(function ($query) {
                    $query->where('asignada_a', Auth::user()->email)
                        ->orWhere('captada_por', Auth::id())
                        ->orWhere('captada_por', Auth::user()->email)
                        ->orWhere('asignada_a', (string) Auth::id());
                })
                ->where(function ($query) use ($name) {
                    $query->orwhere('titulo', "like", "%$this->criterio%");
                    $query->orwhere('propiedads.referencia', 'like', "%$this->criterio");
                    $query->orwhere('provincias.provincia', 'like', "%$this->criterio%");
                    $query->orwhere('sectores.sector', 'like', "%$this->criterio%");
                    $query->orwhere('zona', 'like', "%$this->criterio%");
                })
                ->leftJoin('provincias', 'propiedads.provincia', '=', 'provincias.id')
                ->leftJoin('sectores', 'propiedads.sector_id', '=', 'sectores.id')
                ->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id')
                ->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id')
                ->orderBy('propiedads.created_at', 'desc')
                ->paginate(5);
        };

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $estados_propiedad = CatalogoService::estados();

        $provincias = ProvinciaModel::all();

        return view('livewire.buscar-propiedad', compact('propiedades', 'zonas', 'disponibles_para', 'tipos_propiedades', 'estados_propiedad', 'provincias'));
    }

    public function updatingcriterio()
    {
        $this->resetpage();
    }

    public function clear()
    {
        $this->reset([
            'Id',
            'referencia',
            'foto_portada',
            'provincia',
            'zona_id',
            'direccion',
            'precio',
            'titulo',
            'slug',
            'descripcion_corta',
            'descripcion',
            'metadescripcion',
            'metadescription',
            'habitaciones',
            'banos',
            'parqueos',
            'metraje',
            'metraje_construccion',
            'asignada_a',
            'captado_por',
            'tipo',
            'foto_vendedor',
            'disponible_para',
            'destacada',
            'foto1',
            'foto2',
            'foto3',
            'foto4',
            'foto5',
            'foto6',
            'foto7',
            'foto8',
            'video1',
            'video2',
            'video3',
            'video4',
            'moneda',
            'vendida',
            'lobby',
            'plantaelectrica',
            'camaravigilancia',
            'escaleraemergencia',
            'maderapreciosa',
            'balcon',
            'walkincloset',
            'jacuzzi',
            'areainfantil',
            'banovisitas',
            'cisterna',
            'inversorareacomun',
            'gascomun',
            'gazebo',
            'pozo',
            'piscina',
            'familyroom',
            'cuartodeservicio',
            'patio',
            'portonelectrico',
            'seguridad24horas',
            'ascensor',
            'parqueostechados',
            'preinstalacionairetinacoinversor',
            'terraza',
            'estudio',
            'gimnasio',
            'controldeacceso',
            'clicks',
            'activa',
            'estado_id',
            'created_at',
            'updated_at',
            'aprobada',
            'fechacierre',
            'marcadeagua',
        ]);

        $this->comision = 0;
        $this->activa = 1;




        $this->emit('limpiarDescripcion');
    }

    public function edit($id)
    {


        $propiedad = DB::table('propiedads')
            ->select('estado_id', 'comision', 'referencia', 'fechacierre', 'estado', 'propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at', 'activa', 'marcadeagua')
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

        $this->Id = $propiedad->id;

        $this->foto_portada = $propiedad->foto_portada;

        $this->titulo = $propiedad->titulo;

        $this->referencia = $propiedad->referencia;

        $this->descripcion_corta = $propiedad->descripcion_corta;

        $this->descripcion = $propiedad->descripcion;

        $this->metadescription = $propiedad->metadescription ?: $propiedad->metadescripcion;
        $this->metadescripcion = $this->metadescription;

        $this->precio = $propiedad->precio;

        if ($propiedad->comision == "" || $propiedad->comision == null) {
            $this->comision = 0;
        } else {
            $this->comision = $propiedad->comision;
        }

        $this->tipo = $propiedad->tipo;

        $this->moneda = $propiedad->Moneda;

        $this->provincia = $propiedad->provincia;

        $this->zona_id = $propiedad->zona_id;

        $this->direccion = $propiedad->direccion;

        $this->precio = $propiedad->precio;

        $this->metadescripcion = $propiedad->metadescripcion;

        $this->habitaciones = $propiedad->habitaciones;

        $this->banos = $propiedad->banos;

        $this->parqueos = $propiedad->parqueos;

        $this->metraje = $propiedad->metraje;

        $this->metraje_construccion = $propiedad->metraje_construccion;

        $this->disponible_para = $propiedad->disponible_para;

        $this->destacada = $propiedad->destacada;

        $this->vendida = $propiedad->vendida;

        $this->lobby = $propiedad->lobby;

        $this->plantaelectrica = $propiedad->plantaelectrica;

        $this->camaravigilancia = $propiedad->camaravigilancia;

        $this->escaleraemergencia = $propiedad->escaleraemergencia;

        $this->maderapreciosa = $propiedad->maderapreciosa;

        $this->balcon = $propiedad->balcon;

        $this->walkincloset = $propiedad->walkincloset;

        $this->jacuzzi = $propiedad->jacuzzi;

        $this->areainfantil = $propiedad->areainfantil;

        $this->banovisitas = $propiedad->banovisitas;

        $this->cisterna = $propiedad->cisterna;

        $this->inversorareacomun = $propiedad->inversorareacomun;

        $this->gascomun = $propiedad->gascomun;

        $this->gazebo = $propiedad->gazebo;

        $this->pozo = $propiedad->pozo;

        $this->piscina = $propiedad->piscina;

        $this->familyroom = $propiedad->familyroom;

        $this->cuartodeservicio = $propiedad->cuartodeservicio;

        $this->patio = $propiedad->patio;

        $this->portonelectrico = $propiedad->portonelectrico;

        $this->seguridad24horas = $propiedad->seguridad24horas;

        $this->ascensor = $propiedad->ascensor;

        $this->parqueostechados = $propiedad->parqueostechados;

        $this->preinstalacionairetinacoinversor = $propiedad->preinstalacionairetinacoinversor;

        $this->terraza = $propiedad->terraza;

        $this->estudio = $propiedad->estudio;

        $this->gimnasio = $propiedad->gimnasio;

        $this->controldeacceso = $propiedad->controldeacceso;

        $this->foto1 = $propiedad->foto1;

        $this->foto2 = $propiedad->foto2;

        $this->foto3 = $propiedad->foto3;

        $this->foto4 = $propiedad->foto4;

        $this->foto5 = $propiedad->foto5;

        $this->foto6 = $propiedad->foto6;

        $this->foto7 = $propiedad->foto7;

        $this->foto8 = $propiedad->foto8;

        $this->estado_id = $propiedad->estado_id;

        $this->video1 = $propiedad->video1;

        $this->activa = $propiedad->activa;

        $this->marcadeagua = $propiedad->marcadeagua;


        $this->emit('editarDescripcion', $propiedad->descripcion);
    }

    public function borrar_foto($foto)
    {
        switch ($foto) {
            case '1':
                $this->foto1 = '';
                break;
            case '2':
                $this->foto2 = '';
                break;
            case '3':
                $this->foto3 = '';
                break;
            case '4':
                $this->foto4 = '';
                break;
            case '5':
                $this->foto5 = '';
                break;
            case '6':
                $this->foto6 = '';
                break;
            case '7':
                $this->foto7 = '';
                break;
            case '8':
                $this->foto8 = '';
                break;
            case 'portada':
                $this->foto_portada = '';
                break;
        }
    }

    protected function propertyRules(?int $propertyId = null): array
    {
        $titleRule = ['required', 'min:10', 'max:60'];

        if ($propertyId) {
            $titleRule[] = Rule::unique('propiedads', 'titulo')->ignore($propertyId);
        } else {
            $titleRule[] = 'unique:propiedads,titulo';
        }

        $rules = [
            'titulo' => $titleRule,
            'descripcion' => ['required'],
            'descripcion_corta' => ['required', 'min:20', 'max:160'],
            'metadescription' => ['required', 'min:20', 'max:160'],
            'zona_id' => ['required'],
            'provincia' => ['required'],
            'moneda' => ['required'],
            'precio' => ['required'],
            'tipo' => ['required'],
            'habitaciones' => ['required'],
            'banos' => ['required'],
            'parqueos' => ['required'],
            'metraje' => ['required'],
            'disponible_para' => ['required'],
            'foto_portada' => [$propertyId ? 'nullable' : 'required', 'image', 'max:5120'],
        ];

        foreach (self::GALLERY_FIELDS as $field) {
            $rules[$field] = ['nullable', 'image', 'max:5120'];
        }

        return $rules;
    }

    protected function photoFields(): array
    {
        return array_merge([self::COVER_FIELD], self::GALLERY_FIELDS);
    }

    protected function fillPropiedad(Propiedad $propiedad, int $storageId, bool $isNew = false): void
    {
        $propiedad->provincia = $this->provincia;
        $propiedad->zona_id = $this->zona_id;
        $propiedad->direccion = $this->direccion;
        $propiedad->precio = str_replace([','], '', $this->precio);

        if ($this->hasPropiedadColumn('comision')) {
            $propiedad->comision = $this->comision ?: 0;
        } else {
            unset($propiedad->comision);
        }
        $propiedad->titulo = $this->titulo;
        $propiedad->slug = Str::slug($this->titulo) . '-' . $storageId;
        $propiedad->descripcion_corta = $this->descripcion_corta;
        $propiedad->descripcion = $this->descripcion;
        $propiedad->metadescripcion = $this->metadescription;
        $propiedad->metadescription = $this->metadescription;
        $propiedad->habitaciones = $this->habitaciones;
        $propiedad->banos = $this->banos;
        $propiedad->parqueos = $this->parqueos;
        $propiedad->metraje = $this->metraje;
        $propiedad->metraje_construccion = $this->metraje_construccion;
        $propiedad->tipo = $this->tipo;
        $propiedad->disponible_para = $this->disponible_para;
        $propiedad->video1 = $this->normalizeVideoInput($this->video1);
        $propiedad->estado_id = $this->estado_id;
        $propiedad->Moneda = $this->moneda;

        if ($this->hasPropiedadColumn('fechacierre')) {
            $propiedad->fechacierre = $this->fechacierre;
        } else {
            unset($propiedad->fechacierre);
        }

        if ($isNew) {
            $propiedad->referencia = 'PROP-' . str_pad($storageId, 10, '0', STR_PAD_LEFT);
            $propiedad->asignada_a = Auth::user()->email;
            $propiedad->asignada_a_id = Auth::id();
            $propiedad->captada_por = Auth::id();
            $propiedad->clicks = 0;
        }

        foreach (self::BOOLEAN_FIELDS as $field) {
            if ($this->hasPropiedadColumn($field)) {
                $propiedad->{$field} = (int) ((bool) $this->{$field});
            }
        }
    }

    protected function hasPropiedadColumn(string $column): bool
    {
        if (self::$propiedadColumns === null) {
            self::$propiedadColumns = Schema::getColumnListing('propiedads');
        }

        return in_array($column, self::$propiedadColumns, true);
    }

    protected function syncPhotos(Propiedad $propiedad, int $storageId): void
    {
        foreach ($this->photoFields() as $field) {
            $incomingPhoto = $this->{$field};
            $currentPath = $propiedad->{$field};

            if ($incomingPhoto instanceof TemporaryUploadedFile) {
                if (is_string($currentPath) && $currentPath !== '') {
                    $this->deletePhotoFiles($currentPath);
                }

                $propiedad->{$field} = $this->storePhoto($incomingPhoto, $storageId, $field);
                continue;
            }

            if ($incomingPhoto === '' || $incomingPhoto === null) {
                if (is_string($currentPath) && $currentPath !== '') {
                    $this->deletePhotoFiles($currentPath);
                }

                $propiedad->{$field} = '';
            }
        }
    }

    protected function storePhoto(TemporaryUploadedFile $photo, int $storageId, string $field): string
    {
        $suffix = $field === self::COVER_FIELD ? 'portada' : $field;

        return $photo->storeAs(
            "propiedades/$storageId",
            Str::slug($this->titulo, '-') . '-' . $suffix . '.' . $photo->getClientOriginalExtension(),
            'local'
        );
    }

    protected function deletePhotoFiles(string $path): void
    {
        Storage::disk('local')->delete($path);
        File::delete(public_path('assets/' . $path));
    }

    protected function normalizeVideoInput(?string $video): string
    {
        if (!$video) {
            return '';
        }

        if (Str::contains($video, 'watch?v=')) {
            return Str::after($video, 'watch?v=');
        }

        if (Str::contains($video, 'youtu.be/')) {
            return Str::afterLast($video, '/');
        }

        if (Str::contains($video, 'youtube.com/embed/')) {
            return Str::afterLast($video, '/');
        }

        return trim($video);
    }

    public function ImageOptimize($image, $fullPath)
    {
        $absolutePath = public_path('assets/' . $fullPath);
        if (!is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        $optimized = Image::make($image)->encode('webp', 90)->limitColors(255)->fit(850, 650);

        if ($this->marcadeagua == 1) {
            $watermarkPath = public_path('assets/inmobiliaria/logo.png');
            if (file_exists($watermarkPath)) {
                $optimized->insert($watermarkPath, 'center', 10, 10, 20);
            }
        }

        $optimized->save($absolutePath);
    }

    public function update($id)
    {
        $this->validate($this->propertyRules($id));

        $propiedad = Propiedad::find($id);
        if (!$propiedad) {
            return;
        }

        $this->fillPropiedad($propiedad, $propiedad->id);
        $this->syncPhotos($propiedad, $propiedad->id);

        $propiedad->save();

        PropertySaved::dispatch($propiedad);

        $this->misitemap();

        session()->flash('status', 'Propiedad actualizada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function store()
    {
        $this->validate($this->propertyRules());

        $id_ultimo = Propiedad::max('id');

        if ($id_ultimo == null) {
            $id_siguiente = 0;
        } else {
            $id_siguiente = ++$id_ultimo;
        }

        $propiedad = new Propiedad();
        $this->fillPropiedad($propiedad, $id_siguiente, true);
        $this->syncPhotos($propiedad, $id_siguiente);

        $propiedad->save();

        PropertySaved::dispatch($propiedad);

        $this->misitemap();

        session()->flash('status', 'Propiedad creada exitosamente');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function misitemap()
    {
        $inmo = InmobiliariaService::get();

        if (!$inmo) {
            return '';
        }

        app(SitemapService::class)->refresh();

        return rtrim((string) $inmo->dominio, '/') . '/sitemap.xml';
    }
}
