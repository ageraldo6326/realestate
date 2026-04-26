<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Clientes;
use Illuminate\Support\Facades\DB;

class ConsultarCliente extends Component
{
    public $criterio = '';

    public function render()
    {
        $search = trim((string) $this->criterio);
        $normalizedPhone = preg_replace('/\D+/', '', $search);
        $emailSearch = mb_strtolower($search, 'UTF-8');

        $clientes = collect();

        if ($search !== '') {
            $query = Clientes::query()
                ->select(
                    'clientes.id',
                    'clientes.titulo',
                    'clientes.nombre',
                    'clientes.tipo_contacto',
                    'clientes.telefono as cliente_telefono',
                    'clientes.email as cliente_email',
                    DB::raw('COALESCE(asesor_por_id.telefono, asesor_por_email.telefono) as asesor_telefono'),
                    DB::raw('COALESCE(asesor_por_id.email, asesor_por_email.email) as asesor_email'),
                    DB::raw('COALESCE(asesor_por_id.name, asesor_por_email.name) as asesor_nombre'),
                    'clientes.asignado_a',
                    'clientes.created_at'
                )
                ->leftJoin('users as asesor_por_id', 'clientes.asignado_a', '=', 'asesor_por_id.id')
                ->leftJoin('users as asesor_por_email', 'clientes.asignado_a', '=', 'asesor_por_email.email');

            if (str_contains($search, '@')) {
                $query->whereRaw('LOWER(clientes.email) like ?', ["%{$emailSearch}%"]);
            } elseif ($normalizedPhone !== '') {
                $query->where(function ($phoneQuery) use ($search, $normalizedPhone) {
                    $phoneQuery
                        ->where('clientes.telefono', '=', $normalizedPhone)
                        ->orWhere('clientes.telefono', '=', $search)
                        ->orWhere('clientes.telefono', 'like', "%{$normalizedPhone}%")
                        ->orWhere('clientes.telefono', 'like', "%{$search}%");
                });
            }

            $clientes = $query
                ->orderByDesc('clientes.created_at')
                ->limit(12)
                ->get();
        }
        
        return view('livewire.consultar-cliente', [
            'clientes' => $clientes,
            'criterio' => $this->criterio,
        ]);
    }
}
