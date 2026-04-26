<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inmobiliaria;


class EmpresaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inmobiliaria = Inmobiliaria::first();

        if ($inmobiliaria) {
            return view("admin.empresa.edit", compact("inmobiliaria"));
        }

        return view("admin.empresa.create");
    }

    public function edit($id)
    {
        $inmobiliaria = Inmobiliaria::where('id', $id)->first();

        if (!$inmobiliaria) {
            return redirect()->route('inmobiliaria.create');
        }

        return view("admin.empresa.edit", compact("inmobiliaria"));
    }

    public function create()
    {
        $inmobiliaria = Inmobiliaria::first();

        if ($inmobiliaria) {
            return redirect()->route('inmobiliaria.edit', $inmobiliaria->id);
        }

        return view("admin.empresa.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:100',
            'correo' => 'required|email|max:255',
            'direccion' => 'required|string',
            'titulo' => 'nullable|string|max:255',
            'metadescription' => 'nullable|string|max:500',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'quienessomos' => 'nullable|string',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
        ]);

        // Asegura comportamiento de registro unico para Empresa.
        $inmobiliaria = Inmobiliaria::first() ?? new Inmobiliaria();

        $inmobiliaria->nombre = $request->nombre;
        $inmobiliaria->correo = $request->correo;
        $inmobiliaria->direccion = $request->direccion;
        $inmobiliaria->telefono = $request->telefono;
        $inmobiliaria->titulo = $request->titulo;
        $inmobiliaria->metadescription = $request->metadescription;
        $inmobiliaria->facebook = $request->facebook;
        $inmobiliaria->instagram = $request->instagram;
        $inmobiliaria->tiktok = $request->tiktok;
        $inmobiliaria->whatsapp = $request->whatsapp;
        $inmobiliaria->quienessomos = $request->quienessomos;

        if ($request->hasFile('logo')) {

            $urlfoto = $request->file("logo");

            $ruta = public_path('/img/') . 'logo.' . $urlfoto->extension();

            $inmobiliaria->logo = '/img/' . 'logo.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('favicon')) {

            $urlfoto = $request->file("favicon");

            $ruta = public_path('/img/') . 'favicon.' . $urlfoto->extension();

            $inmobiliaria->favicon = '/img/' . 'favicon.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }


        $inmobiliaria->save();

        return redirect()->route('inmobiliaria.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:100',
            'correo' => 'required|email|max:255',
            'direccion' => 'required|string',
            'titulo' => 'nullable|string|max:255',
            'metadescription' => 'nullable|string|max:500',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'quienessomos' => 'nullable|string',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
        ]);

        $inmobiliaria = Inmobiliaria::where('id', $id)->first();

        if (!$inmobiliaria) {
            return redirect()->route('inmobiliaria.create');
        }


        $inmobiliaria->nombre = $request->nombre;
        $inmobiliaria->correo = $request->correo;
        $inmobiliaria->telefono = $request->telefono;
        $inmobiliaria->direccion = $request->direccion;
        $inmobiliaria->titulo = $request->titulo;
        $inmobiliaria->metadescription = $request->metadescription;
        $inmobiliaria->facebook = $request->facebook;
        $inmobiliaria->instagram = $request->instagram;
        $inmobiliaria->correo = $request->correo;
        $inmobiliaria->whatsapp = $request->whatsapp;
        $inmobiliaria->quienessomos = $request->quienessomos;

        if ($request->aprobacion == "on") {
            $inmobiliaria->aprobacion = $request->aprobacion;
        } else {
            $inmobiliaria->aprobacion = "";
        }

        if ($request->hasFile('logo')) {

            $urlfoto = $request->file("logo");

            $ruta = public_path('/img/') . 'logo.' . $urlfoto->extension();

            $inmobiliaria->logo = '/img/' . 'logo.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }

        if ($request->hasFile('favicon')) {

            $urlfoto = $request->file("favicon");

            $ruta = public_path('/img/') . 'favicon.' . $urlfoto->extension();

            $inmobiliaria->favicon = '/img/' . 'favicon.' . $urlfoto->extension();

            copy($urlfoto->getRealPath(), $ruta);
        }


        $inmobiliaria->save();

        return redirect()->route("inmobiliaria.index");
    }
}
