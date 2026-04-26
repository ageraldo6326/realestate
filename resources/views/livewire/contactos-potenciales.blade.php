<div>
    
    <select class="form-control" name="periodo" id="periodo" wire:model='periodo'>
        <option value="" >Seleccione</option>
        <option value="Ultimos 30 dias" >Últimos 30 Días</option>
        <option value="Esta semana" selected>Esta semana</option>
        <option value="La semana pasada">La semana pasada</option>
        <option value="Este mes">Este mes</option>
        <option value="Mes pasado">Mes pasado</option>
    </select>



    {{ $periodo }}
</div>
