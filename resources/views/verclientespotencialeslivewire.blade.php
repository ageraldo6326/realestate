<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @livewireStyles
</head>
<body>

    <select id="mes_filter" wire:model="mes_filter" onchange="emitMesActualizado(this.value)" wire:ignore>
        <option selected value="0">Mes</option>
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
    </select>

    @livewire('clientespotenciales')
   
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Seleccionar el elemento select por su ID
            var mesFilterSelect = document.getElementById('mes_filter');
        });
    
        function emitMesActualizado(value) {
            console.log(value);
            livewire.emit('mesActualizado', value);
        }
  
    </script>    
    
    @livewireScripts    
</body>
</html>
