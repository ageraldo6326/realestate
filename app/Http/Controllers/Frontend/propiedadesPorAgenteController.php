<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class propiedadesPorAgenteController extends Controller
{
    //

    public function show($id_agente) {

        $inmobiliaria = Inmobiliaria::first();

        return view('frontend.propiedadesPorAgentes',["inmobiliaria" => $inmobiliaria,"id_agente" => $id_agente]);
    }
}
