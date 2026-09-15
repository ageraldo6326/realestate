<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmobiliaria_id',
        'canonical_host',
        'checksum',
        'url_count',
        'status',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];
}
