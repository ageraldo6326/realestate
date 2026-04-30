<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorBarrioSeeder extends Seeder
{
  public function run(): void
  {
    $filePath = database_path('data/sectores_datos_rep_dom.json');
    if (!is_file($filePath)) {
      return;
    }

    $rows = json_decode((string) file_get_contents($filePath), true);
    if (!is_array($rows) || empty($rows)) {
      return;
    }

    $now = now();
    $payload = [];
    foreach ($rows as $row) {
      if (!isset($row['provincia_id'], $row['sector'])) {
        continue;
      }

      $payload[] = [
        'provincia_id' => (int) $row['provincia_id'],
        'sector' => trim((string) $row['sector']),
        'created_at' => $now,
        'updated_at' => $now,
      ];
    }

    foreach (array_chunk($payload, 500) as $chunk) {
      DB::table((new Sector())->getTable())->upsert(
        $chunk,
        ['provincia_id', 'sector'],
        ['updated_at']
      );
    }
  }
}
