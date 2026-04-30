<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedFullSectoresCatalogFromDatosRepDom extends Migration
{
  public function up(): void
  {
    if (!Schema::hasTable('sectores')) {
      return;
    }

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
      DB::table('sectores')->upsert(
        $chunk,
        ['provincia_id', 'sector'],
        ['updated_at']
      );
    }
  }

  public function down(): void
  {
    // Keep catalog data on rollback to avoid orphaning property references.
  }
}
