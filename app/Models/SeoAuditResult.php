<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoAuditResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmobiliaria_id',
        'seo_audit_run_id',
        'auditable_type',
        'auditable_id',
        'entity_title',
        'canonical_url',
        'is_indexable',
        'is_in_sitemap',
        'score',
        'status',
        'last_http_status',
        'last_checked_at',
        'lastmod_at',
    ];

    protected $casts = [
        'is_indexable' => 'boolean',
        'is_in_sitemap' => 'boolean',
        'last_checked_at' => 'datetime',
        'lastmod_at' => 'datetime',
    ];

    public function run(): BelongsTo
    {
        return $this->belongsTo(SeoAuditRun::class, 'seo_audit_run_id');
    }

    public function findings(): HasMany
    {
        return $this->hasMany(SeoAuditFinding::class);
    }
}
