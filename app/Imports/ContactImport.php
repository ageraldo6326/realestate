<?php

namespace App\Imports;

use App\Models\Clientes;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ContactImport implements ToModel, WithHeadingRow, WithStartRow  
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Clientes([
            "nombre" => $row['first_name'] . " " . $row['last_name'],
            "campana" => $row['campaign_name'],
            "email" => $row['correo_electronico'],
            "telefono" => trim($row['numero_de_telefono']),
            "tipo_contacto" => "Persona Fisica",
            "activo" => 1,
            "tipo_contacto2" => "Comprador",
            "captado_por" => Auth::user()->id,
            "asignado_a" => Auth::user()->id,
            "captadas_por" => "",
            "estatus" => "NUEVO",
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
