<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\ContactImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CsvController extends Controller
{
    public function index()
    {
        return view('admin.clientes.importContacto');
    }

    public function import(Request $request)
    {
        $request->validate([
            'document_csv' => 'required|mimes:csv,txt,xlx,xls,xlsx',
        ]);

        try {
            $file = $request->file('document_csv');
            Excel::import(new ContactImport, $file);
            return redirect()->route('import.index')->with('success', 'Contactos creado exitosamente.');;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="plantilla_contactos.csv"',
        ];

        $rows = [
            ['first_name', 'last_name', 'campaign_name', 'correo_electronico', 'numero_de_telefono'],
            ['Juan', 'Perez', 'Meta Ads', 'juan@email.com', '8095551234'],
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM so Excel opens it correctly
            fwrite($handle, "\xEF\xBB\xBF");
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
