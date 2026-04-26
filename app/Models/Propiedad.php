<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Propiedad extends Model
{
    use HasFactory;

    private const OPTIONAL_LEGACY_COLUMNS = [
        'comision',
        'fechacierre',
        'marcadeagua',
    ];

    private static ?array $tableColumns = null;

    protected $guarded = [];

    protected $casts = [
        'precio' => 'float',
        'metraje' => 'float',
        'metraje_construccion' => 'float',
        'comision' => 'float',
        'destacada' => 'boolean',
        'vendida' => 'boolean',
        'activa' => 'boolean',
        'aprobada' => 'boolean',
        'marcadeagua' => 'boolean',
        'lobby' => 'boolean',
        'plantaelectrica' => 'boolean',
        'camaravigilancia' => 'boolean',
        'escaleraemergencia' => 'boolean',
        'maderapreciosa' => 'boolean',
        'balcon' => 'boolean',
        'walkincloset' => 'boolean',
        'jacuzzi' => 'boolean',
        'areainfantil' => 'boolean',
        'banovisitas' => 'boolean',
        'cisterna' => 'boolean',
        'inversorareacomun' => 'boolean',
        'gascomun' => 'boolean',
        'gazebo' => 'boolean',
        'pozo' => 'boolean',
        'piscina' => 'boolean',
        'familyroom' => 'boolean',
        'cuartodeservicio' => 'boolean',
        'patio' => 'boolean',
        'portonelectrico' => 'boolean',
        'seguridad24horas' => 'boolean',
        'ascensor' => 'boolean',
        'parqueostechados' => 'boolean',
        'preinstalacionairetinacoinversor' => 'boolean',
        'terraza' => 'boolean',
        'estudio' => 'boolean',
        'gimnasio' => 'boolean',
        'controldeacceso' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $propiedad): void {
            $propiedad->stripMissingOptionalColumns();
        });
    }

    public function setCaptadaPorAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $this->attributes['captada_por'] = null;

            return;
        }

        if (is_numeric($value)) {
            $this->attributes['captada_por'] = (int) $value;

            return;
        }

        $userId = User::query()->where('email', (string) $value)->value('id');
        $this->attributes['captada_por'] = $userId ? (int) $userId : null;
    }

    protected function stripMissingOptionalColumns(): void
    {
        $validColumns = $this->getTableColumns();

        foreach (self::OPTIONAL_LEGACY_COLUMNS as $attribute) {
            if (!in_array($attribute, $validColumns, true) && array_key_exists($attribute, $this->attributes)) {
                unset($this->attributes[$attribute]);
            }
        }
    }

    protected function getTableColumns(): array
    {
        if (self::$tableColumns === null) {
            self::$tableColumns = Schema::getColumnListing($this->getTable());
        }

        return self::$tableColumns;
    }
}
