<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\InmobiliariaService;

class QuienesSomosController extends Controller
{
    //

    public function index() {

        $inmobiliaria = InmobiliariaService::get();

        return view("frontend.quienessomos",compact("inmobiliaria"));
    }
}
