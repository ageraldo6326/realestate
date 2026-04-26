<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class OptimizarImagenesController extends Controller
{
    public function optimizar(){

        $propiedades = Propiedad::all();
        foreach ($propiedades as $propiedad) {

            $campo_db = $propiedad->foto8;
            $campo = 'foto8.webp';

            try {
            $img = Image::make(ltrim($campo_db,'/'));

            echo ltrim($campo_db,'/')."<br>";

            $img->encode('webp', 90)->fit(850, 650)->limitColors(255)->save('img/propiedades/img/'.$propiedad->referencia.'/'.$campo);

            } catch (\Exception $e) {
                Log::error('Ocurrió un error: ' . $e->getMessage());
            }
            
        }
    }
}
