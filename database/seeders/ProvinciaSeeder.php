<?php

namespace Database\Seeders;

use App\Models\provincia;
use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    public function run(): void
    {
        $provincias = [
            'AZUA',
            'BAHORUCO',
            'BARAHONA',
            'DAJABON',
            'DISTRITO NACIONAL',
            'DUARTE',
            'EL SEIBO',
            'ELIAS PIÑA',
            'ESPAILLAT',
            'HATO MAYOR',
            'HERMANAS MIRABAL',
            'INDEPENDENCIA',
            'LA ALTAGRACIA',
            'LA ROMANA',
            'LA VEGA',
            'MARIA TRINIDAD SANCHEZ',
            'MONSEÑOR NOUEL',
            'MONTE PLATA',
            'MONTECRISTI',
            'PEDERNALES',
            'PERAVIA',
            'PUERTO PLATA',
            'SAMANA',
            'SAN CRISTOBAL',
            'SAN JOSE DE OCOA',
            'SAN JUAN',
            'SAN PEDRO DE MACORIS',
            'SANCHEZ RAMIREZ',
            'SANTIAGO',
            'SANTIAGO RODRIGUEZ',
            'SANTO DOMINGO',
            'VALVERDE',
        ];

        foreach ($provincias as $nombre) {
            provincia::firstOrCreate(['provincia' => $nombre]);
        }
    }
}
