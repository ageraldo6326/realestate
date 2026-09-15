<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SeedFullSectoresCatalogFromDatosRepDom extends Migration
{
  private const PROVINCES_BY_SOURCE_ID = [
    1 => 'AZUA',
    2 => 'BAHORUCO',
    3 => 'BARAHONA',
    4 => 'DAJABON',
    5 => 'DISTRITO NACIONAL',
    6 => 'DUARTE',
    7 => 'EL SEIBO',
    8 => 'ELIAS PIÑA',
    9 => 'ESPAILLAT',
    10 => 'HATO MAYOR',
    11 => 'HERMANAS MIRABAL',
    12 => 'INDEPENDENCIA',
    13 => 'LA ALTAGRACIA',
    14 => 'LA ROMANA',
    15 => 'LA VEGA',
    16 => 'MARIA TRINIDAD SANCHEZ',
    17 => 'MONSEÑOR NOUEL',
    18 => 'MONTE PLATA',
    19 => 'MONTECRISTI',
    20 => 'PEDERNALES',
    21 => 'PERAVIA',
    22 => 'PUERTO PLATA',
    23 => 'SAMANA',
    24 => 'SAN CRISTOBAL',
    25 => 'SAN JOSE DE OCOA',
    26 => 'SAN JUAN',
    27 => 'SAN PEDRO DE MACORIS',
    28 => 'SANCHEZ RAMIREZ',
    29 => 'SANTIAGO',
    30 => 'SANTIAGO RODRIGUEZ',
    31 => 'SANTO DOMINGO',
    32 => 'VALVERDE',
  ];

  private const PROVINCE_ALIASES = [
    'EL SEYBO' => 'EL SEIBO',
    'MONTE CRISTI' => 'MONTECRISTI',
  ];

  public function up(): void
  {
    if (!Schema::hasTable('sectores') || !Schema::hasTable('provincias')) {
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

    $provinceIds = $this->resolveProvinceIds();
    $now = now();
    $payload = [];
    foreach ($rows as $row) {
      if (!isset($row['provincia_id'], $row['sector'])) {
        continue;
      }

      $sourceProvinceId = (int) $row['provincia_id'];
      if (!isset($provinceIds[$sourceProvinceId])) {
        throw new RuntimeException("No existe una provincia configurada para el ID de origen {$sourceProvinceId}.");
      }

      $sector = trim((string) $row['sector']);
      if ($sector === '') {
        continue;
      }

      $payload[] = [
        'provincia_id' => $provinceIds[$sourceProvinceId],
        'sector' => $sector,
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

  private function resolveProvinceIds(): array
  {
    $existingProvinceIds = [];

    foreach (DB::table('provincias')->orderBy('id')->get(['id', 'provincia']) as $province) {
      $key = $this->provinceKey((string) $province->provincia);
      if ($key !== '' && !isset($existingProvinceIds[$key])) {
        $existingProvinceIds[$key] = (int) $province->id;
      }
    }

    $resolvedIds = [];
    foreach (self::PROVINCES_BY_SOURCE_ID as $sourceId => $provinceName) {
      $key = $this->provinceKey($provinceName);

      if (!isset($existingProvinceIds[$key])) {
        $existingProvinceIds[$key] = (int) DB::table('provincias')->insertGetId([
          'provincia' => $provinceName,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }

      $resolvedIds[$sourceId] = $existingProvinceIds[$key];
    }

    return $resolvedIds;
  }

  private function provinceKey(string $provinceName): string
  {
    $key = Str::upper(Str::ascii(trim($provinceName)));
    $key = preg_replace('/\s+/', ' ', $key) ?: '';

    return self::PROVINCE_ALIASES[$key] ?? $key;
  }
}
