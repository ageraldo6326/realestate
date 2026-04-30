<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Venta;
use Livewire\Component;

use App\Models\Clientes;
use App\Models\Propiedad;
use Illuminate\Support\Facades\DB;
use App\Services\CatalogoService;

class EditarVenta extends Component
{
    public $criterioPropiedad;
    public $criterioComprador;
    public $criterioVendedor;
    public $criterioAsesor;
    public $id_venta;
    public $criterio;

    public $created_at, $id_propiedad, $refPropiedad, $tituloPropiedad, $tipoPropiedad, $zonaPropiedad, $estadoPropiedad,
    $fechaPropiedadCreada, $precio, $comision, $id_vendedor, $nombre_vendedor, $id_comprador, $nombre_comprador, $medio_comprador,
    $id_asesor, $nombre_asesor, $fechaVentaCierre, $fechacreadocomprador, $Id;

    public function mount() {
        $venta = Venta::where('id','=',$this->Id)->first();

        $this->id_propiedad = $venta->id_propiedad;
        $this->refPropiedad = $venta->refPropiedad;
        $this->tituloPropiedad = $venta->tituloPropiedad;
        $this->tituloPropiedad = $venta->tituloPropiedad;
        $this->tipoPropiedad = $venta->tipoPropiedad;
        $this->zonaPropiedad = $venta->zonaPropiedad;
        $this->estadoPropiedad = $venta->estadoPropiedad;
        $this->fechaPropiedadCreada = $venta->fechaPropiedadCreada;
        $this->precio = $venta->precio;
        $this->comision = $venta->comision;
        $this->id_vendedor = $venta->id_vendedor;
        $this->nombre_vendedor = $venta->nombre_vendedor;
        $this->id_comprador = $venta->id_comprador;
        $this->nombre_comprador = $venta->nombre_comprador;
        $this->medio_comprador = $venta->medio_comprador;
        $this->id_asesor = $venta->id_asesor;
        $this->nombre_asesor = $venta->nombre_asesor;
        $this->fechaVentaCierre = $venta->fechaVentaCierre;
        $this->fechacreadocomprador = $venta->fechacreadocomprador;
    }

    public function render()
    {
       $criterio = $this->criterio;
        $usuarios = CatalogoService::asesoresActivos();
        $propiedades = Propiedad::query();

        if($this->criterio!="") {
            $propiedades->select(DB::raw('referencia'),DB::raw('foto_portada'),DB::raw('titulo'));
            $propiedades->where('titulo','like',"%$criterio%");
            $propiedades->orWhere('referencia','like',"%$criterio%");
            $propiedades = $propiedades->get();
        } 

        $vendedores = Clientes::query();

        if($this->criterioVendedor!="") {
            $vendedores->select(DB::raw('id'),DB::raw('nombre'),DB::raw('telefono'));
            $vendedores->where('nombre','like',"%$this->criterioVendedor%");
            $vendedores->orWhere('id','=',"$this->criterioVendedor");
            $vendedores = $vendedores->get();
        }        
        
        $compradores = Clientes::query();

        if($this->criterioComprador!="") {
            $compradores->select(DB::raw('id'),DB::raw('nombre'),DB::raw('telefono'),DB::raw('date(created_at) AS created_at'));
            $compradores->where('nombre','like',"%$this->criterioComprador%");
            $compradores->orWhere('id','=',"$this->criterioComprador");
            $compradores = $compradores->get();
        }                  

        return view('livewire.editar-venta', compact('usuarios','propiedades','vendedores','compradores'));
    }

    public function buscarvendedor($id) {

        $this->criterioVendedor = $id;

        if ($this->criterioVendedor!="") {
            $contacto = Clientes::where('id','=',$this->criterioVendedor)->first();
            if (isset($contacto->id)) {
                $this->id_vendedor = $contacto->id;
                $this->nombre_vendedor = $contacto->nombre;
            }
        }

        $this->criterioVendedor = "";

    }

    public function buscarcomprador($id) {

        $this->criterioComprador = $id;

        if ($this->criterioComprador!="") {
            $contacto = Clientes::where('id','=',$this->criterioComprador)->first();
            if (isset($contacto->id)) {
                $this->id_comprador = $contacto->id;
                $this->nombre_comprador = $contacto->nombre;
                $this->medio_comprador = $contacto->medio;
                $this->fechaVentaCierre = $contacto->fechacierre;
                $this->fechacreadocomprador = $contacto->created_at->format('Y-m-d');
            }
        }

        $this->criterioComprador = "";

    }      

    public function buscarasesor() {

        if ($this->criterioAsesor!="") {
            $asesor = User::where('email','=',$this->criterioAsesor)->first();
            if (isset($asesor->email)) {
                $this->id_asesor = $asesor->email;
                $this->nombre_asesor = $asesor->name;
            }
        }

    }   

    public function buscarpropiedad($id) {

        $this->criterioPropiedad = $id;

        if ($this->criterioPropiedad!="") {

            $propiedad = Propiedad::query();
            $propiedad->leftJoin('zonas','propiedads.zona_id','=','zonas.id');
            $propiedad->leftJoin('estados','propiedads.estado_id','=','estados.id');
            $propiedad->leftJoin('tipos_de_propiedads','propiedads.tipo','=','tipos_de_propiedads.id');
            $propiedad->where('referencia','=',$this->criterioPropiedad);

            $propiedad = $propiedad->first();

            if (isset($propiedad->id)) {
                $this->id_propiedad = $propiedad->id;
                $this->refPropiedad = $propiedad->referencia;
                $this->tituloPropiedad = $propiedad->titulo;
                $this->tipoPropiedad = $propiedad->tipo;
                $this->zonaPropiedad = $propiedad->zona;
                $this->estadoPropiedad = $propiedad->estado;
                $this->precio = number_format($propiedad->precio);
                $this->comision = $propiedad->comision;
                $this->fechaPropiedadCreada = $propiedad->created_at->format('Y-m-d');
            }
        }

        $this->criterio ="";

    }    

    public function grabarventa($id) {

        $this->validate([
            'id_propiedad' => 'required',
            'id_vendedor' => 'required',
            'id_comprador' => 'required',
            'id_asesor' => 'required',
            'fechaVentaCierre' => 'required',
        ]);        

        $venta = Venta::where('id','=',$id)->first();
        $venta->id_propiedad = $this->id_propiedad;
        $venta->refPropiedad = $this->refPropiedad;
        $venta->tituloPropiedad = $this->tituloPropiedad;
        $venta->tipoPropiedad = $this->tipoPropiedad;
        $venta->zonaPropiedad = $this->zonaPropiedad;
        $venta->estadoPropiedad = $this->estadoPropiedad;
        $venta->fechaPropiedadCreada = $this->fechaPropiedadCreada;
        $venta->precio = str_replace([','], '', $this->precio); 
        $venta->comision = $this->comision;
        $venta->id_vendedor = $this->id_vendedor;
        $venta->nombre_vendedor = $this->nombre_vendedor;
        $venta->id_comprador = $this->id_comprador;
        $venta->nombre_comprador =  $this->nombre_comprador; 
        $venta->medio_comprador = $this->medio_comprador;  
        $venta->id_asesor = $this->id_asesor;
        $venta->nombre_asesor = $this->nombre_asesor;
        $venta->fechaVentaCierre = $this->fechaVentaCierre;
        $venta->fechacreadocomprador = $this->fechacreadocomprador;
        
        $venta->save();

        return redirect()->route('registrarventa')->with('ventagrabada', 'Venta actualizada!');
    }    
}
