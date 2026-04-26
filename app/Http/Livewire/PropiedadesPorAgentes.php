<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Zonas;
use App\Models\Portada;
use Livewire\Component;
use App\Models\Inmobiliaria;
use App\Models\Disponible_para;
use App\Models\Propiedad;
use App\Models\TiposDePropiedad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PropiedadesPorAgentes extends Component
{

    public $criterio, $id_agente;

    public function render()
    {

        $inmobiliaria = Inmobiliaria::first();

        $portadas = Portada::all();

        $zonas = Zonas::all();

        $disponibles_para = Disponible_para::all();

        $tipos_propiedades = TiposDePropiedad::all();

        $usuario = User::where('id',$this->id_agente)->first();

        $name = $this->criterio;

        $propiedades = Propiedad::query();

        $propiedades->select('estado_id','estado','propiedads.id', 'referencia', 'telefono', 'foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'propiedads.titulo', 'slug' ,'propiedads.descripcion_corta', 'propiedads.descripcion', 'propiedads.metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para' ,'disponible_paras.disponible_para' , 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'propiedads.metadescription', 'propiedads.created_at', 'propiedads.updated_at');
        $propiedades->where('asignada_a',$usuario->email);
        if (optional($inmobiliaria)->aprobacion === "on") {
            $propiedades->where('aprobada',"=",1);
        }
        if ($this->criterio!='') {
            $propiedades->where(function($query) use ($name){
                $query->orwhere('propiedads.titulo',"like","%$this->criterio%");
                $query->orwhere('propiedads.referencia',$this->criterio);
                $query->orwhere('zona','like',"%$this->criterio%");
            });
        }
        $propiedades->where('activa',"=",1);
        $propiedades->leftJoin('zonas','propiedads.zona_id','=','zonas.id');
        $propiedades->leftJoin('estados','propiedads.estado_id','=','estados.id');
        $propiedades->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id');
        $propiedades->leftJoin('users','propiedads.asignada_a','=','users.email');
      
        $propiedades = $propiedades->paginate(9);
        
        return view('livewire.propiedades-por-agentes',compact('portadas','zonas','disponibles_para','tipos_propiedades','propiedades','inmobiliaria'));
    }
}
