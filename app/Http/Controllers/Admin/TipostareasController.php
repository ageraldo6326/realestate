<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTipoTareaRequest;
use App\Http\Requests\Admin\UpdateTipoTareaRequest;
use App\Models\ToDo;
use App\Models\ToDoTipo;
use App\Services\CatalogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TipostareasController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.tipotarea.index');
    }

    public function create()
    {
        return view('admin.tipotarea.create');
    }


    public function store(StoreTipoTareaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated): void {
                ToDoTipo::query()->create([
                    'todo_tipo' => $validated['todo_tipo'],
                    'color' => $validated['color'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('tipostareas.index')
                ->with('status', 'Tipo de tarea registrado correctamente.');
        } catch (Throwable $exception) {
            Log::error('todo_types.store.failed', [
                'todo_tipo' => $validated['todo_tipo'] ?? null,
                'error' => $exception->getMessage(),
                'created_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('tipostareas.create')
                ->withInput()
                ->with('error', 'No fue posible guardar el tipo de tarea. Intenta nuevamente.');
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $tipotarea = ToDoTipo::query()->findOrFail($id);

        return view('admin.tipotarea.edit', compact('tipotarea'));

    }


    public function update(UpdateTipoTareaRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();
        $tipotarea = ToDoTipo::query()->findOrFail($id);

        try {
            DB::transaction(function () use ($tipotarea, $validated): void {
                $tipotarea->update([
                    'todo_tipo' => $validated['todo_tipo'],
                    'color' => $validated['color'],
                ]);
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('tipostareas.index')
                ->with('status', 'Tipo de tarea actualizado correctamente.');
        } catch (Throwable $exception) {
            Log::error('todo_types.update.failed', [
                'todo_tipo_id' => (int) $tipotarea->id,
                'todo_tipo' => $validated['todo_tipo'] ?? null,
                'error' => $exception->getMessage(),
                'updated_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('tipostareas.edit', $tipotarea->id)
                ->withInput()
                ->with('error', 'No fue posible actualizar el tipo de tarea. Intenta nuevamente.');
        }

    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $tipotarea = ToDoTipo::query()->findOrFail($id);

        try {
            $tareasVinculadas = ToDo::query()->where('todo_tipo', $tipotarea->id)->count();

            if ($tareasVinculadas > 0) {
                return redirect()
                    ->route('tipostareas.index')
                    ->with('error', 'No se puede eliminar porque tiene tareas relacionadas.');
            }

            DB::transaction(function () use ($tipotarea): void {
                $tipotarea->delete();
            });

            CatalogoService::forgetAll();

            return redirect()
                ->route('tipostareas.index')
                ->with('status', 'Tipo de tarea eliminado correctamente.');
        } catch (Throwable $exception) {
            Log::error('todo_types.delete.failed', [
                'todo_tipo_id' => (int) $tipotarea->id,
                'error' => $exception->getMessage(),
                'deleted_by' => (int) optional($request->user())->id,
            ]);

            return redirect()
                ->route('tipostareas.index')
                ->with('error', 'No fue posible eliminar el tipo de tarea. Intenta nuevamente.');
        }
    }
}
