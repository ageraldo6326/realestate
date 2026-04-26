<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class CrearVentasController extends Controller
{
    public function index () {

        return view('admin.ventas.create');
    }

    public function grabarVenta(Request $request) {
        
        $venta = new Venta();
        $venta->id_propiedad = $request->id;
        $venta->refPropiedad = $request->referencia;
        $venta->tituloPropiedad = $request->propiedad;
        $venta->tipoPropiedad = $request->tipo;
        $venta->zonaPropiedad = $request->zona;
        $venta->estadoPropiedad = $request->estado;
        $venta->fechaPropiedadCreada = $request->fechaPropiedadCreada;
        $venta->precio = str_replace([','], '', $request->precio); 
        $venta->comision = $request->comision;
        $venta->id_vendedor = $request->id_vendedor;
        $venta->nombre_vendedor = $request->nombre_vendedor;
        $venta->id_comprador = $request->id_comprador;
        $venta->nombre_comprador =  $request->nombre_comprador; 
        $venta->medio_comprador = $request->medio_comprador;  
        $venta->id_asesor = $request->id_asesor;
        $venta->nombre_asesor = $request->nombre_asesor;
        $venta->fechaVentaCierre = $request->fechaVentaCierre;
        
        $venta->save();

        return redirect()->route('registrarventa')->with('ventagrabada', 'Venta registrada!');
    }

    public function ActualizarVenta(Request $request) {

        $venta = Venta::where('id','=',$request->id_venta)->first();

        $venta->refPropiedad = $request->referencia;
        $venta->tituloPropiedad = $request->propiedad;
        $venta->tipoPropiedad = $request->tipo;
        $venta->zonaPropiedad = $request->zona;
        $venta->estadoPropiedad = $request->estado;
        $venta->fechaPropiedadCreada = $request->fechaPropiedadCreada;
        $venta->precio = str_replace([','], '', $request->precio); 
        $venta->comision = $request->comision;
        $venta->id_vendedor = $request->id_vendedor;
        $venta->nombre_vendedor = $request->nombre_vendedor;
        $venta->id_comprador = $request->id_comprador;
        $venta->nombre_comprador =  $request->nombre_comprador; 
        $venta->medio_comprador = $request->medio_comprador;  
        $venta->id_asesor = $request->id_asesor;
        $venta->nombre_asesor = $request->nombre_asesor;
        $venta->fechaVentaCierre = $request->fechaVentaCierre;
        
        $venta->save();

        return redirect()->route('registrarventa')->with('ventaactualizada', 'Venta actualizada!');
    }    

    public function edit($id) {
 
        return view('admin.ventas.edit',compact('id'));
    }

    public function BorrarVenta($id) {

        $venta = Venta::where('id','=',$id)->first();

        $venta->delete();

        return redirect()->route('registrarventa')->with('ventaborrada', 'Venta borrada!');

    }    
}
