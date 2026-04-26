<?php

namespace App\Http\Controllers\Admin;

use App\Models\Clientes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MostrarClienteController extends Controller
{
    //
    public function show($id) {
        $cliente = Clientes::where('id',$id)->first();  
        
        return view('admin.clientes.show',compact('cliente'));
    }
}
