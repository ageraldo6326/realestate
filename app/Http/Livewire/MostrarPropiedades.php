<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class MostrarPropiedades extends Component
{

    public $criterio;
    use WithPagination;
        
    public function render()
    {        
        $name = $this->criterio;
        
        if ($this->criterio=="") {
            $propiedades = DB::table('propiedads')
            ->select('propiedads.id', 'aprobada', 'foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
            ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
            ->leftJoin('estados','propiedads.estado_id','=','estados.id')
            ->orderBy('created_at','desc')
            ->paginate(20);
        } else {
            $propiedades = DB::table('propiedads')
            ->select('propiedads.id', 'aprobada', 'foto_portada', 'provincia', 'zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'disponible_para', 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
            ->where(function($query) use ($name){
                $query->orwhere('titulo',"like","%$this->criterio%");
                $query->orwhere('propiedads.referencia',$this->criterio);
                $query->orwhere('zona','like',"%$this->criterio%");
            })
            ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
            ->leftJoin('estados','propiedads.estado_id','=','estados.id')
            ->orderBy('created_at','desc')
            ->paginate(20);
        };
        
        return view('livewire.mostrar-propiedades',compact("propiedades"));
    }


}
