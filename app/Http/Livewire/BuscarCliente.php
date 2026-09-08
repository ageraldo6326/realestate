<?php

namespace App\Http\Livewire;

use App\Models\ToDo;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\ToDoTipo;
use App\Models\Clientenota;
use App\Models\ToDoEstatus;
use Livewire\WithPagination;
use App\Services\CatalogoService;
use App\Services\InmobiliariaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BuscarCliente extends Component
{
    use WithPagination;



    public $formTitle = "Estado";
    public $criterio = "";
    public $criterioestatus = "";
    public $criterioprobabilidades = "";
    public $nota, $id_nota;
    public $open = false;

    public $Id, $nombre, $titulo, $tipo_contacto, $telefono, $email, $comentario, $contact_at, $activo, $tipo_contacto2, $captado_por,
        $asignado_a, $medio, $testimonio, $precio_mini, $precio_max, $precio_mini_dolar, $precio_max_dolar, $zona_id, $tipo, $tipo_en_dolares, $habitaciones, $parqueos, $estadopropiedad, $estadopropiedad_en_dolar, $created_at,
        $update_at, $estatus, $probabilidades, $id_tarea, $nombre_tarea, $descripcion_tarea, $fecha_tarea, $id_cliente_tarea, $tipo_tarea, $estatus_tarea, $captadas_por, $fechacierre,
        $grabar, $contacto_actual = "";

    public $tarea_nombre, $tarea_descripcion, $tarea_tipo, $tarea_estatus, $tarea_fecha;

    protected $listeners = ['borrarContacto', 'borrarnota', 'borrartarea'];
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nombre' => 'required',
        'titulo' => 'required',
        'tipo_contacto' => 'required',
        'telefono' => 'required|unique:clientes,telefono',
        'comentario' => 'required',
        'contact_at' => 'required',
        'tipo_contacto2' => 'required',
        'medio' => 'required',
    ];

    public $messages = [
        'telefono.unique' => 'El telefono ya se encuentra registrado en nuestro sistema.',
    ];

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $isAdmin = $user && $user->can('access-admin');
        $contactOwnershipDays = (int) (optional(InmobiliariaService::get())->dias_propiedad_contactos ?? 90);
        if ($contactOwnershipDays < 1) {
            $contactOwnershipDays = 90;
        }
        $contactOwnershipStart = now()->subDays($contactOwnershipDays)->startOfDay();

        $query = Clientes::query();
        if ($isAdmin) {
            $query->where(function ($q) {
                $q->where('captado_por', Auth::id())
                    ->orWhere('asignado_a', Auth::id());
            });
        } else {
            $query->where(function ($q) use ($contactOwnershipStart) {
                $q->where('captado_por', Auth::id())
                    ->orWhere('asignado_a', Auth::id());
            })->where('created_at', '>=', $contactOwnershipStart);
        }

        if ($this->criterio != "") {
            $criterio = $this->criterio;
            $query->where(function ($subQuery) use ($criterio) {
                $subQuery->where('nombre', 'like', "%{$criterio}%")
                    ->orWhere('id', '=', $criterio);
            });
        }
        if ($this->criterioestatus != "") $query->where('estatus', '=', "$this->criterioestatus");
        if ($this->criterioprobabilidades != "") $query->where('probabilidades', '=', "$this->criterioprobabilidades");

        $query->Orderby('id', 'desc');

        $this->grabar = 1;

        $clientes = $query->paginate(9);

        $zonas = CatalogoService::zonas();

        $disponibles_para = CatalogoService::disponiblePara();

        $tipos_propiedades = CatalogoService::tipos();

        $estados_propiedad = CatalogoService::estados();

        $notas = Clientenota::where('id_cliente', '=', $this->Id)->orderby("created_at", "desc")->get();

        $tareas = DB::table('to_dos')
            ->select('to_dos.id', 'to_dos.fechaLimite', 'to_dos.nombre', 'to_dos.descripcion', 'to_do_estatuses.todo_estatus', 'to_do_tipos.todo_tipo')
            ->leftJoin('to_do_estatuses', 'to_dos.todo_estatus', '=', 'to_do_estatuses.id')
            ->leftJoin('to_do_tipos', 'to_dos.todo_tipo', '=', 'to_do_tipos.id')
            ->where('to_dos.cliente_id', '=', $this->Id)
            ->orderBy('to_dos.created_at', 'desc')
            ->get();

        $usuarios = CatalogoService::asesoresActivos();

        $tipos = ToDoTipo::all();
        $estatuses = ToDoEstatus::all();
        return view('livewire.buscar-cliente', compact("clientes", "usuarios", "zonas", "tipos_propiedades", "estados_propiedad", "notas", "tareas", "tipos", "estatuses"));
    }

    public function verificarContacto()
    {
        $cliente = Clientes::where('telefono', $this->telefono)->first();

        if ($cliente != null) {
            $this->grabar = 0;
            return back()->with('TelefonoDuplicado', '¡Contacto Ya Existe Nombre: ' . $cliente->nombre . ' !');
        }
    }

    public function verTarea($id)
    {
        $resultado = DB::table('to_dos')
            ->select('to_dos.*', 'to_do_estatuses.*', 'to_do_tipos.*')
            ->leftJoin('to_do_estatuses', 'to_dos.todo_estatus', '=', 'to_do_estatuses.id')
            ->leftJoin('to_do_tipos', 'to_dos.todo_tipo', '=', 'to_do_tipos.id')
            ->where('to_dos.id', '=', $id)
            ->get();


        $this->tarea_nombre = $resultado[0]->nombre;
        $this->tarea_descripcion = $resultado[0]->descripcion;
        $this->tarea_tipo = $resultado[0]->todo_tipo;
        $this->tarea_estatus = $resultado[0]->todo_estatus;
        $this->tarea_fecha = $resultado[0]->fechaLimite;
    }

    public function store()
    {


        $this->validate([
            'nombre' => 'required',
            'tipo_contacto' => 'required',
            'comentario' => 'required',
            'contact_at' => 'required',
            'tipo_contacto2' => 'required',
            'medio' => 'required',
            'estatus' => 'required',

        ]);

        $cliente = Clientes::where('telefono', $this->telefono)->first();

        if ($cliente == null) {

            $cliente = new Clientes();
            $cliente->nombre = $this->nombre;
            $cliente->titulo = $this->titulo;
            $cliente->tipo_contacto = $this->tipo_contacto;
            $cliente->telefono = $this->telefono;
            $cliente->email = $this->email;
            $cliente->tipo_contacto2 = $this->tipo_contacto2;
            $cliente->medio = $this->medio;
            $cliente->testimonio = $this->testimonio;
            $cliente->captado_por = Auth::user()->id;
            $cliente->asignado_a = Auth::user()->id;
            $cliente->comentario = $this->comentario;
            $cliente->contact_at = $this->contact_at;
            $cliente->estatus = $this->estatus;
            $cliente->probabilidades = $this->probabilidades;
            $cliente->captadas_por = $this->captadas_por;



            if (is_numeric($this->zona_id))
                $cliente->zona_id = $this->zona_id;
            if (is_numeric(str_replace([','], '', $this->precio_mini)))
                $cliente->precio_mini = str_replace([','], '', $this->precio_mini);
            if (is_numeric(str_replace([','], '', $this->precio_max)))
                $cliente->precio_max = str_replace([','], '', $this->precio_max);

            if (is_numeric(str_replace([','], '', $this->precio_mini_dolar)))
                $cliente->precio_mini_dolar = str_replace([','], '', $this->precio_mini_dolar);
            if (is_numeric(str_replace([','], '', $this->precio_max_dolar)))
                $cliente->precio_max_dolar = str_replace([','], '', $this->precio_max_dolar);


            if (is_numeric($this->habitaciones))
                $cliente->habitaciones = $this->habitaciones;
            if (is_numeric($this->parqueos))
                $cliente->parqueos = $this->parqueos;

            if (is_numeric($this->estadopropiedad))
                $cliente->estado = $this->estadopropiedad;
            if (is_numeric($this->tipo))
                $cliente->tipo = $this->tipo;

            if (is_numeric($this->estadopropiedad_en_dolar))
                $cliente->estado_en_dolares = $this->estadopropiedad_en_dolar;
            if (is_numeric($this->tipo_en_dolares))
                $cliente->tipo_en_dolares = $this->tipo_en_dolares;



            if ($this->activo) {
                $cliente->activo = 1;
            } else {
                $cliente->activo = 0;
            }


            $cliente->save();
            $this->Id = $cliente->id;

            return back()->with('success', '¡Contacto Agregado!');
        } else {
            return back()->with('duplicado', '¡Contacto Ya Existe Teléfono:' . $cliente->telefono . '!');
        }
    }

    public function clear()
    {
        $this->Id = 0;
        $this->nombre = "";
        $this->titulo = "";
        $this->tipo_contacto = "";
        $this->telefono = "";
        $this->email = "";
        $this->comentario = "";
        $this->contact_at = "";
        $this->activo = "";
        $this->tipo_contacto2 = "";
        $this->captado_por = "";
        $this->asignado_a = "";
        $this->medio = "";
        $this->testimonio = "";
        $this->precio_mini = "";
        $this->precio_max = "";
        $this->precio_mini_dolar = "";
        $this->precio_max_dolar = "";

        $this->estadopropiedad_en_dolar = "";
        $this->tipo_en_dolares = "";

        $this->zona_id = "";
        $this->tipo = "";
        $this->habitaciones = "";
        $this->parqueos = "";
        $this->estadopropiedad = "";
        $this->created_at = "";
        $this->update_at = "";
        $this->estatus = "";
        $this->probabilidades = "";
        $this->captadas_por = "";
        $this->limpiar_tarea();
        $this->limpiar_nota();
        $this->resetValidation();
        // $this->dispatchBrowserEvent('close-modal');
        // $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function clear2()
    {
        $this->Id = 0;
        $this->nombre = "";
        $this->titulo = "";
        $this->tipo_contacto = "";
        $this->telefono = "";
        $this->email = "";
        $this->comentario = "";
        $this->contact_at = "";
        $this->activo = "";
        $this->tipo_contacto2 = "";
        $this->captado_por = "";
        $this->asignado_a = "";
        $this->medio = "";
        $this->testimonio = "";
        $this->precio_mini = "";
        $this->precio_max = "";
        $this->precio_mini_dolar = "";
        $this->precio_max_dolar = "";
        $this->zona_id = "";
        $this->tipo = "";

        $this->estadopropiedad_en_dolar = "";
        $this->tipo_en_dolares = "";

        $this->habitaciones = "";
        $this->parqueos = "";
        $this->estadopropiedad = "";
        $this->created_at = "";
        $this->update_at = "";
        $this->estatus = "";
        $this->probabilidades = "";
        $this->captadas_por = "";

        $this->open = false;
        $this->resetValidation();
    }


    public function edit($id)
    {
        $this->clear2();
        $this->open = false;

        $this->clear();
        $this->id_tarea = "";
        $this->limpiar_nota();
        $this->limpiar_tarea();
        $this->resetValidation();



        $cliente = Clientes::find($id);
        $this->Id = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->titulo = $cliente->titulo;
        $this->tipo_contacto = $cliente->tipo_contacto;
        $this->telefono = $cliente->telefono;
        $this->email = $cliente->email;
        $this->comentario = $cliente->comentario;
        $this->contact_at =  $cliente->contact_at;
        $this->tipo_contacto2 = $cliente->tipo_contacto2;
        $this->medio = $cliente->medio;
        $this->testimonio = $cliente->testimonio;
        $this->zona_id =  $cliente->zona_id;

        $this->precio_mini = number_format($cliente->precio_mini);
        $this->precio_max =  number_format($cliente->precio_max);

        $this->precio_mini_dolar = number_format($cliente->precio_mini_dolar);
        $this->precio_max_dolar =  number_format($cliente->precio_max_dolar);

        $this->estadopropiedad_en_dolar = $cliente->estado_en_dolares;
        $this->tipo_en_dolares = $cliente->tipo_en_dolares;

        $this->habitaciones = $cliente->habitaciones;
        $this->parqueos = $cliente->parqueos;
        $this->estadopropiedad = $cliente->estado;
        $this->tipo = $cliente->tipo;
        $this->activo = $cliente->activo;
        $this->estatus = $cliente->estatus;
        $this->probabilidades = $cliente->probabilidades;
        $this->captadas_por = $cliente->captadas_por;
        $this->fechacierre = $cliente->fechacierre;
    }

    public function update($id)
    {


        $this->validate([
            'nombre' => 'required',
            'titulo' => 'required',
            'tipo_contacto' => 'required',
            'comentario' => 'required',
            'contact_at' => 'required',
            'tipo_contacto2' => 'required',
            'medio' => 'required',
            'estatus' => 'required',

        ]);


        $cliente = Clientes::find($id);
        $cliente->nombre = $this->nombre;
        $cliente->titulo = $this->titulo;
        $cliente->tipo_contacto = $this->tipo_contacto;
        $cliente->telefono = $this->telefono;
        $cliente->email = $this->email;
        $cliente->tipo_contacto2 = $this->tipo_contacto2;
        $cliente->medio = $this->medio;
        $cliente->testimonio = $this->testimonio;
        $cliente->comentario = $this->comentario;
        $cliente->contact_at = $this->contact_at;
        $cliente->estatus = $this->estatus;
        $cliente->probabilidades = $this->probabilidades;

        if (is_numeric($this->estadopropiedad_en_dolar))
            $cliente->estado_en_dolares = $this->estadopropiedad_en_dolar;

        if (is_numeric($this->tipo_en_dolares))
            $cliente->tipo_en_dolares = $this->tipo_en_dolares;

        if ($cliente->fechacierre == null and $this->estatus == "CIERRE") {
            $cliente->fechacierre = date("Y-m-d");
        }


        if (is_numeric($this->zona_id))
            $cliente->zona_id = $this->zona_id;

        if (is_numeric(str_replace([','], '', $this->precio_mini)))
            $cliente->precio_mini = str_replace([','], '', $this->precio_mini);
        if (is_numeric(str_replace([','], '', $this->precio_max)))
            $cliente->precio_max = str_replace([','], '', $this->precio_max);

        if (is_numeric(str_replace([','], '', $this->precio_mini_dolar)))
            $cliente->precio_mini_dolar = str_replace([','], '', $this->precio_mini_dolar);
        if (is_numeric(str_replace([','], '', $this->precio_max_dolar)))
            $cliente->precio_max_dolar = str_replace([','], '', $this->precio_max_dolar);


        if (is_numeric($this->habitaciones))
            $cliente->habitaciones = $this->habitaciones;
        if (is_numeric($this->parqueos))
            $cliente->parqueos = $this->parqueos;
        if (is_numeric($this->estadopropiedad))
            $cliente->estado = $this->estadopropiedad;
        if (is_numeric($this->tipo))
            $cliente->tipo = $this->tipo;

        if ($this->activo) {
            $cliente->activo = 1;
        } else {
            $cliente->activo = 0;
        }

        $cliente->save();
        return back()->with('success', '¡Contacto Actualizado!');
        // $this->clear();        
        // $this->resetValidation();
        // $this->dispatchBrowserEvent('close-modal');
        // $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function updatePropuesta($id)
    {


        $cliente = Clientes::find($id);

        if (is_numeric($this->zona_id))
            $cliente->zona_id = $this->zona_id;
        if (is_numeric(str_replace([','], '', $this->precio_mini)))
            $cliente->precio_mini = str_replace([','], '', $this->precio_mini);
        if (is_numeric(str_replace([','], '', $this->precio_max)))
            $cliente->precio_max = str_replace([','], '', $this->precio_max);

        if (is_numeric(str_replace([','], '', $this->precio_mini_dolar)))
            $cliente->precio_mini_dolar = str_replace([','], '', $this->precio_mini_dolar);
        if (is_numeric(str_replace([','], '', $this->precio_max_dolar)))
            $cliente->precio_max_dolar = str_replace([','], '', $this->precio_max_dolar);

        if (is_numeric($this->habitaciones))
            $cliente->habitaciones = $this->habitaciones;
        if (is_numeric($this->parqueos))
            $cliente->parqueos = $this->parqueos;

        if (is_numeric($this->estadopropiedad_en_dolar))
            $cliente->estado_en_dolares = $this->estadopropiedad_en_dolar;

        if (is_numeric($this->tipo_en_dolares))
            $cliente->tipo_en_dolares = $this->tipo_en_dolares;


        if (is_numeric($this->estadopropiedad))
            $cliente->estado = $this->estadopropiedad;
        if (is_numeric($this->tipo))
            $cliente->tipo = $this->tipo;
        $cliente->captadas_por = $this->captadas_por;

        $cliente->save();
        $this->dispatchBrowserEvent('propuesta', ['id' => $id]);
    }


    public function salir()
    {
        $this->clear();
        $this->limpiar_nota();
        $this->limpiar_tarea();
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('close-modal-delete');
        $this->dispatchBrowserEvent('close-modal-asignar');
        Session::flush();
    }

    public function agregarnota()
    {

        $this->validate([
            'nota' => 'required',
        ]);

        $nota = new Clientenota();
        $nota->id_cliente = $this->Id;
        $nota->nota = $this->nota;
        $nota->save();
        $this->open = false;
        return back()->with('notaagregada', '!Nota Agregada!');
    }

    public function agregartarea()
    {

        $this->validate([
            'nombre_tarea' => 'required',
            'fecha_tarea' => 'required',
            'descripcion_tarea'  => 'required',
            'tipo_tarea' => 'required',
            'estatus_tarea'  => 'required',
        ]);

        $tarea = new ToDo();

        $tarea->nombre = $this->nombre_tarea;
        $tarea->descripcion = $this->descripcion_tarea;
        $tarea->fechaLimite = $this->fecha_tarea;
        $tarea->todo_tipo = $this->tipo_tarea;
        $tarea->todo_estatus = $this->estatus_tarea;
        $tarea->user_id = Auth::user()->id;
        $tarea->cliente_id = $this->Id;
        $tarea->save();
        $this->limpiar_tarea();
        $this->open = false;
        return back()->with('agregartarea', '¡Tarea Agregado!');
    }

    public function actualizartarea($id)
    {

        $this->validate([
            'nombre_tarea' => 'required',
            'fecha_tarea' => 'required',
        ]);

        $tarea = ToDo::where('id', $id)->first();

        $tarea->nombre = $this->nombre_tarea;
        $tarea->descripcion = $this->descripcion_tarea;
        $tarea->fechaLimite = $this->fecha_tarea;
        $tarea->todo_tipo = $this->tipo_tarea;
        $tarea->todo_estatus = $this->estatus_tarea;

        $tarea->save();
        $this->limpiar_tarea();
        return back()->with('actualizartarea', '¡Tarea actualizada!');
    }

    public function actualizarnota($id)
    {

        $this->validate([
            'nota' => 'required',
        ]);

        $nota = Clientenota::where('id', $id)->first();

        $nota->nota = $this->nota;

        $nota->save();
        $this->limpiar_nota();
        return back()->with('actualizarnota', '¡Nota actualizada!');
    }

    public function editartarea($id)
    {

        $tarea = ToDo::where('id', $id)->first();


        $this->nombre_tarea = $tarea->nombre;
        $this->descripcion_tarea = $tarea->descripcion;
        $this->fecha_tarea = $tarea->fechaLimite;
        $this->tipo_tarea = $tarea->todo_tipo;
        $this->estatus_tarea = $tarea->todo_estatus;
        $this->id_tarea = $tarea->id;
        return back()->with('editartarea', '¡Editando tarea!');
    }

    public function editarnota($id)
    {

        $nota = Clientenota::where('id', $id)->first();

        $this->id_nota = $nota->id;
        $this->nota = $nota->nota;

        return back()->with('editarnota', '¡Editando nota!');
    }

    public function limpiar_tarea()
    {
        $this->id_tarea = "";
        $this->nombre_tarea = "";
        $this->descripcion_tarea = "";
        $this->fecha_tarea = "";
        $this->tipo_tarea = "";
        $this->estatus_tarea = "";
    }

    public function limpiar_nota()
    {
        $this->id_nota = "";
        $this->nota = "";
    }


    public function borrarnota($id)
    {
        $nota = Clientenota::where('id', $id)->first();
        $nota->delete();
        return back()->with('borrarnota', '¡Nota borrada!');
    }

    public function borrartarea($id)
    {
        $tarea = ToDo::where('id', $id)->first();
        $tarea->delete();
        return back()->with('borrartarea', '¡Tarea borrada!');
    }

    public function borrarConfirmacion($id)
    {
        $this->dispatchBrowserEvent('generarBorrarContactoSweetAlert', ['id' => $id]);
    }

    public function borrarContacto($id)
    {
        $cliente = Clientes::find($id);
        $cliente->delete();
    }

    public function asignarContacto($id)
    {
        $this->contacto_actual = Clientes::find($id);
    }

    public function asignar()
    {
        Log::info('asignar ' . $this->contacto_actual . " " . $this->asignado_a);
        $this->dispatchBrowserEvent('close-modal-asignar');
    }
}
