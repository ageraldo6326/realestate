<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactosTodosController extends Controller
{
    public function index() {
        return view('admin.clientes.indexTodos');
    }
}
