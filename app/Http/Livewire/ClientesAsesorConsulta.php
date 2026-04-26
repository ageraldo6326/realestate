<?php

namespace App\Http\Livewire;

use App\Models\Clientes;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;


class ClientesAsesorConsulta extends Component
{
    public $fecha_ini;
    public $fecha_fin;


    public function render()
    {
       
        
        if ($this->fecha_ini!=null and $this->fecha_fin!=null) {

            $clientes_por_asesores = DB::table('clientes')
            ->select('name', 'users.id as userid', DB::raw('COUNT(clientes.id) as total'))
            ->leftJoin('users','clientes.captado_por','=','users.id')
            ->where('clientes.created_at', '>=', $this->fecha_ini)
            ->where('clientes.created_at', '<=', $this->fecha_fin)
            ->groupBy('captado_por','name','users.id')
            ->get();  

            return view('livewire.clientes-asesor-consulta',compact("clientes_por_asesores"));
        } else {

            return view('livewire.clientes-asesor-consulta');
        }

        
        
    }

}
