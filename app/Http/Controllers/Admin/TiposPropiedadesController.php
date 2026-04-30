<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoPropiedadRequest;
use App\Http\Requests\UpdateTipoPropiedadRequest;
use App\Models\TiposDePropiedad;

class TiposPropiedadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.tipopropiedades.index');
    }

    public function create()
    {
        return view('admin.tipopropiedades.create');
    }

    public function store(StoreTipoPropiedadRequest $request)
    {
        TiposDePropiedad::create($request->validated());

        return redirect()
            ->route('tipopropiedades.index')
            ->with('success', 'Tipo de propiedad creado exitosamente.');
    }

    public function edit($id)
    {
        $tipopropiedad = TiposDePropiedad::findOrFail($id);

        return view('admin.tipopropiedades.edit', compact('tipopropiedad'));
    }

    public function update(UpdateTipoPropiedadRequest $request, $id)
    {
        $tipopropiedad = TiposDePropiedad::findOrFail($id);
        $tipopropiedad->update($request->validated());

        return redirect()
            ->route('tipopropiedades.index')
            ->with('success', 'Tipo de propiedad actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $tipopropiedad = TiposDePropiedad::findOrFail($id);
        $tipopropiedad->delete();

        return redirect()
            ->route('tipopropiedades.index')
            ->with('success', 'Tipo de propiedad eliminado exitosamente.');
    }
}
