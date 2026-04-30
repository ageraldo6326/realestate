<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use App\Services\InmobiliariaService;

class EnviarPropiedad extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * 
     * 
     */
    public $subject ="Propiedad solicitada";

    public $cliente;

    public function __construct($cliente)
    {
        //
        
        $this->cliente = $cliente;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cliente = $this->cliente;

        $propiedades = DB::table('propiedads')
        ->select('estado_id','estado','propiedads.id', 'foto_portada', 'provincia','zona_id', 'zona', 'direccion', 'precio', 'titulo', 'descripcion_corta', 'descripcion', 'metadescripcion', 'habitaciones', 'banos', 'parqueos', 'metraje', 'metraje_construccion', 'asignada_a', 'captada_por', 'tipo', 'foto_vendedor', 'propiedads.disponible_para' ,'disponible_paras.disponible_para' , 'destacada', 'foto1', 'foto2', 'foto3', 'foto4', 'video1', 'video2', 'video3', 'video4', 'Moneda', 'vendida', 'lobby', 'plantaelectrica', 'camaravigilancia', 'escaleraemergencia', 'maderapreciosa', 'balcon', 'walkincloset', 'jacuzzi', 'areainfantil', 'banovisitas', 'cisterna', 'inversorareacomun', 'gascomun', 'gazebo', 'pozo', 'piscina', 'familyroom', 'cuartodeservicio', 'patio', 'portonelectrico', 'seguridad24horas', 'ascensor', 'parqueostechados', 'preinstalacionairetinacoinversor', 'terraza', 'estudio', 'gimnasio', 'controldeacceso', 'clicks', 'metadescription', 'propiedads.created_at', 'propiedads.updated_at')
        ->leftJoin('zonas','propiedads.zona_id','=','zonas.id')
        ->leftJoin('estados','propiedads.estado_id','=','estados.id')
        ->leftJoin('disponible_paras','propiedads.disponible_para','=','disponible_paras.id')            
        ->orderBy('created_at','desc')
        ->where("propiedads.zona_id", "=", "$cliente->zona_id")
        ->where("propiedads.precio", ">=", "$cliente->precio_mini")
        ->where("propiedads.precio", "<=", "$cliente->precio_max")
        ->where("propiedads.habitaciones", ">=", "$cliente->habitaciones")
        ->where("propiedads.banos", ">=", "$cliente->banos")
        ->where("propiedads.parqueos", ">=", "$cliente->parqueos")
        ->where("propiedads.estado_id", "=", "$cliente->estado")          
        ->paginate(3);        

        $inmobiliaria = InmobiliariaService::get();
        

        // return $this->view('frontend.propiedades',compact('propiedades','inmobiliaria','zonas','disponibles_para','tipos_propiedades'));

        return $this->view('emails.enviarPropiedad',compact('propiedades','inmobiliaria'));
    }
}
