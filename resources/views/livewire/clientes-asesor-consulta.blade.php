<div>

    <div>
        <form class="btn-group" wire:ignore.self>
            <label for="" class="text-lg mx-2">Inicio</label>
            <input type="date" class="form-control" wire:model.lazy='fecha_ini' required>
            <label for="" class="mx-2 text-lg">Fin</label>
            <input type="date" class="form-control" wire:model.lazy='fecha_fin' required> 
        </form>
    </div>
    <div class="col-8">

        <table class="table mt-2 table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="w-75">Asesor(a)</th>
                    <th class="w-25">Cant Clientes</th>
                    <th class="w-25">Ver Clientes</th>
                </tr>
            </thead>
            <tbody>
                
                    @if ($fecha_ini!=null and $fecha_fin!=null)
                        @foreach ($clientes_por_asesores as $clientes_por_asesor)
                        <tr>
                            <td class="text-left">{{ $clientes_por_asesor->name }}</td>
                            <td class="text-left">{{ $clientes_por_asesor->total }}</td>
                            <td class="text-center">
                                <a href="/consulta/verclientesporasesor/{{ $clientes_por_asesor->userid }}/{{ $fecha_ini}}/{{ $fecha_fin }}">
                                    <i class="fa fa-glasses"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
 
            </tbody>
        </table>
        
    </div>
</div>
