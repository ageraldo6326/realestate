<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Propiedad;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;

class PropiedadesPorAgentes extends Component
{

    public $criterio, $id_agente;

    public function render()
    {
        $inmobiliaria = InmobiliariaService::get();

        $portadas = CatalogoService::portadas();

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $usuario = User::where('id', $this->id_agente)->first();

        if (!$usuario) {
            abort(404);
        }

        $name = $this->criterio;

        $propiedades = Propiedad::query();

        $propiedades->select('estado_id', 'estado', 'propiedads.id', 'referencia', 'telefono', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'slug', 'propiedads.descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para', 'disponible_paras.disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->where('propiedads.asignada_a_id', $usuario->id);
        if ((bool) optional($inmobiliaria)->aprobacion) {
            $propiedades->where('aprobada', "=", 1);
        }
        if ($this->criterio != '') {
            $propiedades->where(function ($query) use ($name) {
                $query->orwhere('propiedads.titulo', "like", "%$this->criterio%");
                $query->orwhere('propiedads.referencia', $this->criterio);
                $query->orwhere('zona', 'like', "%$this->criterio%");
            });
        }
        $propiedades->where('activa', "=", 1);
        $propiedades->leftJoin('zonas', 'propiedads.zona_id', '=', 'zonas.id');
        $propiedades->leftJoin('estados', 'propiedads.estado_id', '=', 'estados.id');
        $propiedades->leftJoin('disponible_paras', 'propiedads.disponible_para', '=', 'disponible_paras.id');
        $propiedades->leftJoin('users', 'propiedads.asignada_a_id', '=', 'users.id');
        $propiedades->whereNull('users.deleted_at');
        $propiedades->orderByDesc('propiedads.created_at');

        $propiedades = $propiedades->paginate(9);

        return view('livewire.propiedades-por-agentes', compact('portadas', 'zonas', 'disponibles_para', 'tipos_propiedades', 'propiedades', 'inmobiliaria'));
    }
}
