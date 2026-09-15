<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoAuditFinding extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_audit_result_id',
        'rule_code',
        'severity',
        'message',
        'evidence_json',
        'is_resolved',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'evidence_json' => 'array',
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(SeoAuditResult::class, 'seo_audit_result_id');
    }
}
