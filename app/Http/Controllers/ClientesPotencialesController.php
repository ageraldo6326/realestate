<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientesPotencialesController extends Controller
{
    

    function grafico() {  

        return view('estadisticas.clientespotenciales');
    }
}
