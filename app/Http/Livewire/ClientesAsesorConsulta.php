<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;


class ClientesAsesorConsulta extends Component
{
    public $fecha_ini = '';
    public $fecha_fin = '';

    public function applyFilters(): void
    {
        $this->resetErrorBag();
    }

    public function clearFilters(): void
    {
        $this->fecha_ini = '';
        $this->fecha_fin = '';
        $this->resetErrorBag();
    }

    public function getHasDateRangeProperty(): bool
    {
        return filled($this->fecha_ini) && filled($this->fecha_fin);
    }

    public function getInvalidDateRangeProperty(): bool
    {
        return $this->hasDateRange && $this->fecha_fin < $this->fecha_ini;
    }


    public function render()
    {
        $clientes_por_asesores = collect();

        if ($this->hasDateRange && ! $this->invalidDateRange) {

            $clientes_por_asesores = DB::table('clientes')
                ->select('users.name as asesor_nombre', 'users.id as userid', DB::raw('COUNT(clientes.id) as total'))
                ->leftJoin('users', 'clientes.captado_por', '=', 'users.id')
                ->where('clientes.created_at', '>=', $this->fecha_ini)
                ->where('clientes.created_at', '<=', $this->fecha_fin)
                ->groupBy('clientes.captado_por', 'users.name', 'users.id')
                ->get();
        }

        return view('livewire.clientes-asesor-consulta', compact('clientes_por_asesores'));
    }

}
