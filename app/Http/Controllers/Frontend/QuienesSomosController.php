<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;

class QuienesSomosController extends Controller
{
    //

    public function index() {

        $inmobiliaria = Inmobiliaria::first();

        return view("frontend.quienessomos",compact("inmobiliaria"));
    }
}
