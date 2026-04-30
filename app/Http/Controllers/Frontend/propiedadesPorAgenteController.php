<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\InmobiliariaService;

class propiedadesPorAgenteController extends Controller
{
    //

    public function show($id_agente) {

        $inmobiliaria = InmobiliariaService::get();

        return view('frontend.propiedadesPorAgentes',["inmobiliaria" => $inmobiliaria,"id_agente" => $id_agente]);
    }
}
