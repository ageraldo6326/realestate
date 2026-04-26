<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrarVentasController extends Controller
{
    public function index() {

        return view('admin.ventas.registrarventas');
    }
}
