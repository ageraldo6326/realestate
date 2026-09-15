<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoAuditRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmobiliaria_id',
        'trigger',
        'status',
        'initiated_by',
        'started_at',
        'finished_at',
        'summary_json',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'summary_json' => 'array',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(SeoAuditResult::class);
    }
}
