<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

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
            $propiedad->syncAssignedAdvisor();
            $propiedad->stripMissingOptionalColumns();
        });
    }

    protected function syncAssignedAdvisor(): void
    {
        $assignedId = $this->attributes['asignada_a_id'] ?? null;
        $assignedEmail = $this->attributes['asignada_a'] ?? null;

        if (empty($assignedId) && !empty($assignedEmail)) {
            $assignedId = User::query()->where('email', (string) $assignedEmail)->value('id');
        }

        if (empty($assignedId) && !empty($this->attributes['captada_por'])) {
            $assignedId = (int) $this->attributes['captada_por'];
        }

        if (empty($assignedId) && Auth::check()) {
            $assignedId = Auth::id();
            if (empty($assignedEmail)) {
                $assignedEmail = (string) Auth::user()->email;
            }
        }

        if (!empty($assignedId)) {
            $this->attributes['asignada_a_id'] = (int) $assignedId;

            if (empty($assignedEmail)) {
                $this->attributes['asignada_a'] = (string) User::query()->where('id', (int) $assignedId)->value('email');
            }
        }
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

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zonas::class, 'zona_id');
    }

    public function provinciaRelacion(): BelongsTo
    {
        return $this->belongsTo(provincia::class, 'provincia');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function barrio(): BelongsTo
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estados::class, 'estado_id');
    }

    public function tipoPropiedad(): BelongsTo
    {
        return $this->belongsTo(TiposDePropiedad::class, 'tipo');
    }

    public function disponiblePara(): BelongsTo
    {
        return $this->belongsTo(Disponible_para::class, 'disponible_para');
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignada_a', 'email');
    }

    public function asesorPorId(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignada_a_id');
    }
}
